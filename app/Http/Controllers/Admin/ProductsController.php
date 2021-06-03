<?php

namespace App\Http\Controllers\Admin;

use App\Services\ProductService;

class ProductsController extends BaseController
{
    protected $service;
    protected $admin_user;

    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->service = $productService;
        $this->admin_user  = session(LOGIN_USER);
    }

    public function index()
    {
        $data = $this->service->getPageData();

        return view('admin.products.index',$data);
    }

    public function export()
    {
        return $this->service->export();
    }

    public function add()
    {
        return view('admin.products.add-edit');
    }

    public function create()
    {
        return $this->service->create();
    }

    public function edit($id)
    {
        $item = $this->service->edit($id);

        return view('admin.products.add-edit',compact("item"));
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
