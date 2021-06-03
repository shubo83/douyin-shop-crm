<?php
namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Customer;
use App\Http\Model\Common\CustomerSales;
use App\Repositories\Admin\Contracts\CustomerSalesInterface;

class CustomerSalesRepository implements CustomerSalesInterface
{

    public function getPageData($param, $perPage)
    {
        $customer_ids = Customer::where("admin_user_id",session(LOGIN_USER)["id"])->pluck("id");
        return CustomerSales::whereIn("customer_id",$customer_ids)->orderByDesc("year")->orderByDesc("month")->addWhere($param)->paginate($perPage);
    }

    public function getPageDataForFinance($param, $perPage)
    {
        return CustomerSales::orderByDesc("year")->orderByDesc("month")->addWhere($param)->paginate($perPage);
    }

}
