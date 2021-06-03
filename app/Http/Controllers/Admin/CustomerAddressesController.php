<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Common\Customer;
use App\Services\CustomerAddressService;
use App\Services\ProductService;

class CustomerAddressesController extends BaseController
{
    protected $service;
    protected $admin_user;
    protected $customer;

    public function __construct(CustomerAddressService $customerAddressService)
    {
        parent::__construct();

        $this->service = $customerAddressService;
        $this->admin_user  = session(LOGIN_USER);
        $this->customer = Customer::find(request('customer_id'));
    }

    public function getListByCustomerId()
    {
        return $this->service->get();
    }

    public function index()
    {
        $this->setTitle("【{$this->customer->nickname}】的地址管理");
        $data = $this->service->getPageData();

        return view('admin.customer_addresses.index',$data);
    }

    public function export()
    {
        return $this->service->export();
    }

    public function add()
    {
        $this->setTitle("【{$this->customer->nickname}】的地址添加");
        return view('admin.customer_addresses.add-edit');
    }

    public function create()
    {
        return $this->service->create();
    }

    public function edit($id)
    {
        $this->setTitle("【{$this->customer->nickname}】的地址修改");
        $item = $this->service->edit($id);

        return view('admin.customer_addresses.add-edit',compact("item"));
    }

    public function update()
    {
        return $this->service->update();
    }

    public function del()
    {
        return $this->service->del();
    }

}
