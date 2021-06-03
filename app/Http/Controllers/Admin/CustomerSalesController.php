<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\AdminUser;
use App\Http\Model\Common\Customer;
use App\Http\Model\Common\CustomerSales;
use App\Http\Model\Common\Dictionary;
use App\Imports\SendSampleImport;
use App\Services\CustomerSalesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerSalesController extends BaseController
{
    protected $service;
    protected $admin_user;
    protected $customer;

    public function __construct(CustomerSalesService $customerSalesService)
    {
        parent::__construct();

        $this->service = $customerSalesService;
        $this->admin_user  = session(LOGIN_USER);
    }

    //销售额(销售用)
    public function index()
    {
        $customers = Customer::where("admin_user_id", $this->admin_user['id'])->where("status",3)->get();
        $data = $this->service->getPageData();

        $data["years"] = CustomerSales::whereIn("customer_id", $customers->pluck('id'))->distinct("year")->orderByDesc('year')->pluck('year');
        $data["customers"] = $customers;

        return view('admin.customer_sales.index',$data);
    }

    public function manage()
    {
        $data = $this->service->getPageDataForFinance();
        $data["customers"] = Customer::all();
        $data["years"] = CustomerSales::distinct("year")->orderByDesc('year')->pluck('year');
        $data["shops"] = Dictionary::where('name',"shop")->get();
        return view('admin.customer_sales.manage',$data);
    }

    public function performance()
    {
        $sales_users = AdminUser::where('role',2)->get();

        $shops = Dictionary::where('name',"shop")->get();
        foreach ($sales_users as $sales){

            $customer_ids = Customer::where('admin_user_id', $sales->id)->where('status',3)->pluck('id');

            foreach($shops as $shop){
                $model = CustomerSales::query();
                $model->where('shop_id',$shop->id);
                $model->whereIn('customer_id',$customer_ids);
                if (request()->filled("year")){
                    $model->where("year",request("year"));
                }
                if (request()->filled("month")){
                    $model->where("month",request("month"));
                }
                $sales->{"total_sales_".$shop->id} = floatval($model->sum("sales"));

            }

        }

        $shops = Dictionary::where('name',"shop")->get();

        $admin_user = new AdminUser();
        $admin_user->nickname = "其他";
        //业绩总和
        foreach($shops as $shop){

            $model = CustomerSales::query();
            $model->where('shop_id',$shop->id);
            if (request()->filled("year")){
                $model->where("year",request("year"));
            }
            if (request()->filled("month")){
                $model->where("month",request("month"));
            }
            $all_total_sales = $model->sum("sales");

            $admin_user->{"total_sales_".$shop->id} = round( floatval($all_total_sales - $sales_users->sum("total_sales_{$shop->id}")), 2);
        }

        $sales_users->push($admin_user);

        $sales_users = $sales_users->sortByDesc("total_sales_200");
        $years = CustomerSales::distinct("year")->orderByDesc('year')->pluck('year');

        return view('admin.customer_sales.performance',compact("sales_users","years","shops"));
    }

    public function import()
    {
        $rows = Excel::toCollection(new SendSampleImport(), request()->file("excel"))[0];
        $rows->shift();
        $errors = Validator::make(
            $rows->toArray(),
            [
                '*.2' => 'required',
                '*.8' => 'required',
                '*.12' => 'required',
                '*.18' => 'required',
                '*.24' => 'required',
            ],
            [
                '*.2.required'  => "抖音号不能为空，请确认",
                '*.8.required'  => "成交金额不能为空，请确认",
                '*.12.required'  => "预估佣金不能为空，请确认",
                '*.18.required'  => "退款金额不能为空，请确认",
                '*.24.required'  => "统计日期不能为空，请确认",
            ]
        )->errors();

        if ($errors->count()>0){
            return $this->adminError($errors->first());
        }

        $temp_date = explode("~",$rows[0]["24"])[0];
        $year = date("Y",strtotime($temp_date));
        $month = date("n",strtotime($temp_date));

        foreach ($rows as $row) {

            $customer = Customer::where('platform_user_id',$row[2])->first();

            $sales = floatval($row[8] - $row[12] - $row[18]);
            if ($customer && $sales>0){
                CustomerSales::updateOrCreate([
                    "customer_id" => $customer->id,
                    "year" => $year,
                    "month" => $month,
                    "shop_id" => request("shop_id"),
                ],[
                    "sales" => $sales
                ]);
            }
        }

        return $this->adminSuccess();
    }

}
