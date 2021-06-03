<?php
/**
 * 产品 Service
 *
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\CustomerAddressInterface;
use App\Traits\Admin\PhpOffice;
use App\Validate\Common\CustomerAddressValidate;
use Illuminate\Http\Request;

class CustomerAddressService extends AdminBaseService
{
    use PhpOffice;

    protected $request;
    protected $interface;
    protected $validate;
    protected $admin_user;

    public function __construct(
        Request $request ,
        CustomerAddressInterface $customerAddressInterface,
        CustomerAddressValidate $customerAddressValidate
    )
    {
        $this->request   = $request;
        $this->interface = $customerAddressInterface;
        $this->validate  = $customerAddressValidate;
        $this->admin_user  = session(LOGIN_USER);
    }

    public function get()
    {
        $param = $this->request->input();
        return $this->interface->get($param);
    }

    public function getPageData()
    {
        $param = $this->request->input();
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
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

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
