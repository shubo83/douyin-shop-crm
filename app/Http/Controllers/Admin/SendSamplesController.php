<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\AdminUser;
use App\Http\Model\Common\Customer;
use App\Http\Model\Common\CustomerAddress;
use App\Http\Model\Common\Dictionary;
use App\Http\Model\Common\Product;
use App\Http\Model\Common\SendSample;
use App\Http\Model\Common\SendSampleProduct;
use App\Imports\SendSampleImport;
use App\Services\SendSampleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SendSamplesController extends BaseController
{
    protected $service;
    public $admin_user;

    public function __construct(SendSampleService $sendSampleService)
    {
        parent::__construct();

        $this->service = $sendSampleService;
        $this->admin_user  = session()->get(LOGIN_USER);
    }

    public function index()
    {
        $data = $this->service->getPageData();

        return view('admin.send_samples.index',$data);
    }

    public function export()
    {
        return $this->service->export();
    }

    public function add()
    {
        $customers = Customer::where('admin_user_id',$this->admin_user->id)->get();
        $customer_addresses = CustomerAddress::where('customer_id',request('customer_id'))->get();
        $products = Product::all();
        return view('admin.send_samples.add-edit',compact("customers","customer_addresses","products"));
    }

    public function create()
    {
        return $this->service->create();
    }

    public function edit($id)
    {
        $customers = Customer::where('admin_user_id',$this->admin_user->id)->get();
        $item = $this->service->edit($id);
        $customer_addresses = CustomerAddress::where('customer_id',$item->customer_id)->get();
        $products = Product::all();
        return view('admin.send_samples.add-edit',compact("item","customers","products","customer_addresses"));
    }

    public function update()
    {
        return $this->service->update();
    }

    public function del()
    {
        return $this->service->del();
    }

    //?????????????????????
    public function send($id)
    {
        $item = $this->service->edit($id);
        return view('admin.send_samples.send',compact("item"));
    }

    public function doSend()
    {
        return $this->service->send();
    }

    //????????????
    public function reject(SendSample $sendSample)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'reject_reason' => 'required',
            ],
            [
                'reject_reason.required'  => '?????????????????????',
            ]
        );

        if($validator->fails()) {
            return $this->adminError($validator->getMessageBag()->first());
        }

        $res = $sendSample->update([
            "reject_reason" => request('reject_reason'),
            "apply_status" => 2
        ]);

        return $res ? $this->adminSuccess() : $this->adminError();
    }

    //??????
    public function sign(SendSample $sendSample)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'sign_date' => 'required',
            ],
            [
                'sign_date.required'  => '?????????????????????',
            ]
        );

        if($validator->fails()) {
            return $this->adminError($validator->getMessageBag()->first());
        }

        $res = $sendSample->update([
            "sign_date" => request('sign_date'),
            "apply_status" => 4
        ]);

        return $res ? $this->adminSuccess() : $this->adminError();
    }

    public function import()
    {
        $rows = Excel::toCollection(new SendSampleImport(), request()->file("excel"))[0];
        $rows->shift();
        $errors = Validator::make(
            $rows->toArray(),
            [
                '*.0' => 'required',
                '*.4' => 'required',
                '*.8' => 'required',
            ],
            [
                '*.0.required'  => "????????????????????????????????????",
                '*.4.required'  => "????????????????????????????????????",
                '*.8.required'  => "????????????????????????????????????",
            ]
        )->errors();

        if ($errors->count()>0){
            return $this->adminError($errors->first());
        }

        foreach ($rows as $row) {
            $send_sample = SendSample::where('serial_number',$row[0])->first();
            $product_id = Product::where('serial_number',$row[4])->value("id");
            SendSampleProduct::where("send_sample_id",$send_sample->id)->where("product_id",$product_id)->update(["courier_number" => $row[8]]);
            if (SendSampleProduct::where("send_sample_id",$send_sample->id)->whereNull('courier_number')->count()==0){
                SendSample::where('serial_number',$row[0])->update(["apply_status" => 3]); //???????????????????????????????????????????????????????????????
                Customer::where('id',$send_sample->customer_id)->update(["status" => 3]); //??????????????????????????????????????????
            }
        }

        return $this->adminSuccess();
    }

}
