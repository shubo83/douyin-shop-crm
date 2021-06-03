<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Admin\AdminUser;
use App\Http\Model\Common\Customer;
use App\Http\Model\Common\SendSample;
use Illuminate\Http\Request;

class StatisticsController extends BaseController
{
    //销售相关数据统计
    public function sales()
    {
        $last_month_start = date('Y-m-01',strtotime('-1 month'));
        $last_month_end = date('Y-m-01');

        $current_month_start = date('Y-m-01');
        $current_month_end = date('Y-m-d');

        $yesterday_month_start = date('Y-m-d',strtotime('-1 day'));
        $yesterday_month_end = date('Y-m-d');

        $sales_users = AdminUser::where('role',2)->get();

        foreach ($sales_users as $sales){
            $sales->customer_total = Customer::where('admin_user_id',$sales->id)->count();//达人数
            $sales->last_month_new_customer_total = Customer::where('admin_user_id',$sales->id)->whereBetween("created_at",[$last_month_start,$last_month_end])->count(); //上月新增达人数
            $sales->current_month_new_customer_total = Customer::where('admin_user_id',$sales->id)->whereBetween("created_at",[$current_month_start,$current_month_end])->count(); //本月新增达人数
            $sales->yesterday_new_customer_total = Customer::where('admin_user_id',$sales->id)->whereBetween("created_at",[$yesterday_month_start,$yesterday_month_end])->count(); //昨日新增达人数
            $sales->send_sample_total = SendSample::where('admin_user_id',$sales->id)->count();//寄样数
            $sales->last_month_new_send_sample_total = SendSample::where('admin_user_id',$sales->id)->whereBetween("created_at",[$last_month_start,$last_month_end])->count(); //上月新增寄样数
            $sales->current_month_new_send_sample_total = SendSample::where('admin_user_id',$sales->id)->whereBetween("created_at",[$current_month_start,$current_month_end])->count(); //本月新增寄样数
            $sales->yesterday_new_send_sample_total = SendSample::where('admin_user_id',$sales->id)->whereBetween("created_at",[$yesterday_month_start,$yesterday_month_end])->count(); //昨日新增寄样数
        }

        return view('admin.statistics.sales',compact("sales_users"));
    }
}
