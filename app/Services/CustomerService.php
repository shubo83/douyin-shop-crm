<?php
/**
 * 达人 Service
 *
 */

namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Http\Model\Common\Customer;
use App\Repositories\Admin\Contracts\CustomerInterface;
use App\Traits\Admin\PhpOffice;
use App\Validate\Common\CustomerValidate;
use Illuminate\Http\Request;

class CustomerService extends AdminBaseService
{
    use PhpOffice;

    protected $request;
    protected $interface;
    protected $validate;
    protected $admin_user;

    public function __construct(
        Request $request ,
        CustomerInterface $customerInterface,
        CustomerValidate $customerValidate
    )
    {
        $this->request   = $request;
        $this->interface = $customerInterface;
        $this->validate  = $customerValidate;
        $this->admin_user  = session(LOGIN_USER);
    }

    public function searchData()
    {
        $data = [];
        $request = request();
        if ($request->filled("_keywords")) {
            $model = Customer::query();
            $model->select("customers.*");
            $model->leftJoin("admin_user","admin_user.id","=","customers.admin_user_id");
            $model->where(function ($query) use ($request){
                $query->where("admin_user.nickname","like","%{$request->_keywords}%");
                $query->orWhere("customers.nickname","like","%{$request->_keywords}%");
                $query->orWhere("customers.platform_user_id","like","%{$request->_keywords}%");
            });
            $data = $model->orderByDesc("customers.id")->paginate($this->perPage());
        }

        return array_merge(['data'  => $data],$this->request->query());
    }


    public function getPageData()
    {
        $param = $this->request->input();
        $status = str_replace("admin.customers.index","",$this->request->route()->getName());
        if ($status == 1){ //公海
            $param["admin_user_id"] = 0;
        }else{
            //管理员之外的角色显示自己的客户
            if (!in_array(1,$this->admin_user["role"])){
                $param["admin_user_id"] = $this->admin_user['id'];
            }
        }
        $param["status"] = $status;
        $data  = $this->interface->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    public function export()
    {
        $param = $this->request->input();

        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['ID', '名称', '简介', '是否启用', '创建时间',];
            $body   = [];
            $data   = $this->interface->get($param);
            foreach ($data as $item) {
                $record                = [];
                $record['id']          = $item->id;
                $record['name']        = $item->name;
                $record['description'] = $item->description;
                $record['status']      = $item->status == 1 ? '是' : '否';
                $record['create_time'] = $item->create_time->format('Y-m-d H:i:s');

                $body[] = $record;
            }
            return $this->exportData($header, $body, 'user_level-' . date('Y-m-d-H-i-s'));
        }

        return error();
    }

    public function create()
    {
        if (in_array(1,$this->admin_user["role"])) error("管理员不能录入达人");

        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        if (empty($param["mobile"]) && empty($param["wechat_account"])){
            error("手机号和微信号必填其中一项");
        }

        $param['admin_user_id'] = $this->admin_user["id"];

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
        if (in_array(1,$this->admin_user["role"])) error("管理员不能修改达人");

        $param = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param,[
            'nickname'        => 'required',
            'platform_user_id' => 'required|unique:customers,platform_user_id,'.$param['id'].',id,deleted_at,NULL',
            'contact_person'      => 'required',
            'mobile'      => 'nullable|size:11',
            'wechat_account'       => 'required',
            'fans_number'       => 'required',
            'shop_score'       => 'required',
            'shop_sales'       => 'required',
            'shop_category_id'       => 'required',

        ]);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        if (empty($param["mobile"]) && empty($param["wechat_account"])){
            error("手机号和微信号必填其中一项");
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

}
