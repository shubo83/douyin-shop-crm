<?php
/**
 * 寄样 Service
 *
 */

namespace App\Services;

use App\Http\Model\Common\Customer;
use App\Http\Model\Common\SendSample;
use App\Http\Model\Common\SendSampleProduct;
use App\Repositories\Admin\Contracts\SendSampleInterface;
use App\Traits\Admin\PhpOffice;
use App\Validate\Common\SendSampleValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendSampleService extends AdminBaseService
{
    use PhpOffice;

    protected $request;
    protected $interface;
    protected $validate;
    protected $admin_user;

    public function __construct(
        Request $request ,
        SendSampleInterface $sendSampleInterface,
        SendSampleValidate $sendSampleValidate
    )
    {
        $this->request   = $request;
        $this->interface = $sendSampleInterface;
        $this->validate  = $sendSampleValidate;
        $this->admin_user  = session()->get(LOGIN_USER);
    }

    public function getPageData()
    {
        $param = $this->request->input();
        //管理员和总监之外的角色显示自己的客户
        if (!in_array(1,$this->admin_user["role"]) && !in_array(4,$this->admin_user["role"])){
            $param["admin_user_id"] = $this->admin_user->id;
        }

        $model = SendSampleProduct::query();
        $model->select("send_sample_products.*");
        $model->leftJoin('send_samples', 'send_samples.id', '=', 'send_sample_products.send_sample_id');
        $model->leftJoin('products', 'products.id', '=', 'send_sample_products.product_id');
        $model->leftJoin('admin_user', 'admin_user.id', '=', 'send_samples.admin_user_id');
        $model->leftJoin('customers', 'customers.id', '=', 'send_samples.customer_id');
        $model->with(["product","send_sample"]);
        if ($param["admin_user_id"]){
            $model->whereRaw(" send_sample_id in (select id from send_samples where admin_user_id=".$param["admin_user_id"].")");
        }
        if($this->request->filled("apply_status")) $model->where("send_samples.apply_status",$this->request->apply_status);
        if($this->request->filled("_keywords")) {
            $_keywords = $this->request->_keywords;
            $model->where(function ($query) use ($_keywords) {
                $query->where("products.title","like",'%'.$_keywords.'%');
                $query->orWhere("send_samples.serial_number","like",'%'.$_keywords.'%');
                $query->orWhere("send_sample_products.courier_number","like",'%'.$_keywords.'%');
                $query->orWhere("admin_user.username","like",'%'.$_keywords.'%');
                $query->orWhere("admin_user.nickname","like",'%'.$_keywords.'%');
                $query->orWhere("customers.nickname","like",'%'.$_keywords.'%');
            });
        }

        $data = $model->orderByDesc("send_samples.created_at")->paginate($this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    public function export()
    {
        $param = $this->request->input();

        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['寄样编号', '姓名', '手机', '地址', '产品编号', '产品名称', '数量', '备注', '快递单号'];
            $body   = [];
            $data   = $this->interface->get($param);
            foreach ($data as $item) {
                $send_sample_products = SendSampleProduct::with("product")->where("send_sample_id",$item->id)->get();
                foreach($send_sample_products as $send_sample_product){
                    $record                = [];
                    $record['serial_number']          = $item->serial_number;
                    $record['address_consignee_name'] = $item->address->consignee_name;
                    $record['address_consignee_mobile'] = $item->address->consignee_mobile;
                    $record['address_consignee_address'] = $item->address->consignee_address;
                    $record['product_serial_number'] = $send_sample_product->product->serial_number;
                    $record['product_title'] = $send_sample_product->product->title;
                    $record['product_quantity'] = $send_sample_product->quantity;
                    $record['product_remark'] = $send_sample_product->remark;
                    $record['courier_number'] = "";
                    $body[] = $record;
                }

            }
            return $this->exportData($header, $body, '寄样表-' . date('Y-m-d-H-i-s'));
        }

        return error();
    }

    public function create()
    {
        $serial_number = date("Ymd")."001";
        $db_serial_number = SendSample::orderByDesc("id")->value("serial_number");
        $db_serial_number = str_replace(date("Ymd"),"",$db_serial_number);
        if(strlen($db_serial_number) == 3){
            $serial_number = date("Ymd").str_pad(intval($db_serial_number)+1,3,"0",STR_PAD_LEFT);
        }

        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }
        $param['serial_number'] = $serial_number;
        $param['apply_status'] = 1;
        $param['admin_user_id'] = $this->admin_user->id;
        $param["chat_screen"] = request()->file("chat_screen")->store("chat_screen/".date("Ym"),"public");
        $result = $this->interface->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        return $result ? success('添加成功', $url) : error();
    }

    public function edit($id)
    {
        return $this->interface->findById($id);
    }

    public function update()
    {

        $param = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }
        if($param["is_send"]==1){
            Customer::where("id",$param["customer_id"])->update(["status"=>3]);
            $param["apply_status"] = 3;
        }
        if (request()->hasFile('chat_screen')) {
            $param["chat_screen"] = request()->file("chat_screen")->store("chat_screen/".date("Ym"),"public");
        }

        $result = $this->interface->update($param);

        return $result ? success() : error();
    }

    public function del()
    {
        $id = $this->request->input('id');

        $count = $this->interface->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

    public function send()
    {
        $param = $this->request->input();

        $send_sample = SendSample::find($param['id']);
        $res = $send_sample->update(["apply_status"=>3]);

        foreach (request("products") as $product){
            $res =  SendSampleProduct::where('id',$product["send_sample_product_id"])->update(["courier_number"=>$product['courier_number']]);
        }

        Customer::where("id",$send_sample->customer_id)->update(["status"=>3]);

        return $res ? success() : error();

    }

}
