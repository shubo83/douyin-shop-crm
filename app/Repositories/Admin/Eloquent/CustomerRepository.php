<?php
namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Attachment;
use App\Http\Model\Common\Customer;
use App\Http\Model\Common\CustomerFansNumberHistory;
use App\Http\Model\Common\CustomerShopSalesHistory;
use App\Http\Model\Common\CustomerShopScoreHistory;
use App\Repositories\Admin\Contracts\CustomerInterface;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerInterface
{
    public function get($param)
    {
        return Customer::addWhere($param)->get();
    }

    public function getPageData($param, $perPage)
    {
        return Customer::addWhere($param)->paginate($perPage);
    }

    public function create($param)
    {
        $param["status"] = "2"; //录入达人，默认状态为已添加

        DB::beginTransaction();
        try {
            $customer = Customer::create($param);

            CustomerFansNumberHistory::create([
                "customer_id" => $customer->id,
                "fans_number" => $param['fans_number'],
            ]);

            CustomerShopScoreHistory::create([
                "customer_id" => $customer->id,
                "shop_score" => $param['shop_score'],
            ]);

            CustomerShopSalesHistory::create([
                "customer_id" => $customer->id,
                "shop_sales" => $param['shop_sales'],
            ]);

            DB::commit();
            return $customer;
        }catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            return false;
        }



    }

    public function findById($id)
    {
        return Customer::find($id);
    }

    public function update($param)
    {
        $data = $this->findById($param['id']);

        DB::beginTransaction();
        try {
            if ($data->fans_number != round($param['fans_number'],2)){
                CustomerFansNumberHistory::create([
                    "customer_id" => $param['id'],
                    "fans_number" => $param['fans_number'],
                ]);
            }

            if ($data->shop_score != round($param['shop_score'],2)){
                CustomerShopScoreHistory::create([
                    "customer_id" => $param['id'],
                    "shop_score" => $param['shop_score'],
                ]);
            }

            if ($data->shop_sales != round($param['shop_sales'],2)){
                CustomerShopSalesHistory::create([
                    "customer_id" => $param['id'],
                    "shop_sales" => $param['shop_sales'],
                ]);
            }

            $data->fill($param);
            $res = $data->save();
            DB::commit();
            return $res;
        }catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $count = Customer::destroy($id);

        return $count;
    }

}
