<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\AdminUser;
use App\Http\Model\Common\Customer;
use App\Http\Model\Common\Dictionary;
use App\Models\Task;
use App\Services\CustomerService;

class CustomersController extends BaseController
{
    protected $service;
    protected $admin_user;

    public function __construct(CustomerService $customerService)
    {
        parent::__construct();

        $this->service = $customerService;
        $this->admin_user  = session()->get(LOGIN_USER);
    }

    public function index()
    {
        $data = $this->service->getPageData();
        $sales_list = AdminUser::where('role', 2)->get();
        return view('admin.customers.index',compact("data","sales_list"));
    }

    public function search()
    {
        $data = $this->service->searchData();
        return view('admin.customers.search',compact("data"));
    }

    public function export()
    {
        return $this->service->export();
    }

    public function add()
    {
        $shop_categories = Dictionary::where("name","shop_category")->get();
        return view('admin.customers.add-edit',compact("shop_categories"));
    }

    public function create()
    {
        return $this->service->create();
    }

    public function edit($id)
    {
        $shop_categories = Dictionary::where("name","shop_category")->get();
        $item = $this->service->edit($id);

        return view('admin.customers.add-edit',compact("item","shop_categories"));
    }

    public function update()
    {
        return $this->service->update();
    }

    public function del()
    {
        return $this->service->del();
    }

    //踢到公海
    public function highSeas(Customer $customer)
    {
        $result = $customer->update([
            "admin_user_id" => 0,
            "status" => 1
        ]);
        if ($result) {
            return success();
        } else {
            return error();
        }
    }

    //跟进公海客户
    public function followUp(Customer $customer)
    {
        $following_limit = 1000; //30 临时改到1000
        if(Customer::where('status', 2)->where('admin_user_id', $this->admin_user["id"])->count() >= $following_limit) error("每个人不能超过{$following_limit}个跟进达人，可以把不跟进的客户移到公海！");

        if (in_array(1,$this->admin_user["role"])) error("管理员不能跟进达人");

        if ($customer->status != 1){
            return error("客户状态错误，无法跟进");
        }

        $result = $customer->update([
            "admin_user_id" => $this->admin_user["id"],
            "status" => 2
        ]);

        if ($result) {
            return success();
        } else {
            return error();
        }
    }

}
