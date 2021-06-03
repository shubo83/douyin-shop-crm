<?php
namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\SendSample;
use App\Http\Model\Common\SendSampleProduct;
use App\Repositories\Admin\Contracts\SendSampleInterface;
use Illuminate\Support\Facades\DB;

class SendSampleRepository implements SendSampleInterface
{
    public function get($param)
    {
        return SendSample::addWhere($param)->get();
    }

    public function getPageData($param, $perPage)
    {
        return SendSample::addWhere($param)->paginate($perPage);
    }

    public function create($param)
    {
        DB::beginTransaction();
        try {
            $res = SendSample::create($param);

            foreach ($param["products"] as $key=>$product){
                $param["products"][$key]["send_sample_id"] = $res->id;
                $param["products"][$key]["created_at"] = date("Y-m-d H:i:s");
                $param["products"][$key]["updated_at"] = date("Y-m-d H:i:s");
            }

            SendSampleProduct::insert($param["products"]);
            DB::commit();
            return $res;
        }catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            return false;
        }



    }

    public function findById($id)
    {
        return SendSample::find($id);
    }

    public function update($param)
    {
        $data = $this->findById($param['id']);

        DB::beginTransaction();
        try {
            $data->fill($param);
            $res = $data->save();

            SendSampleProduct::where("send_sample_id",$param['id'])->delete();
            foreach ($param["products"] as $key=>$product){
                $param["products"][$key]["send_sample_id"] = $param['id'];
                $param["products"][$key]["created_at"] = date("Y-m-d H:i:s");
                $param["products"][$key]["updated_at"] = date("Y-m-d H:i:s");
            }
            SendSampleProduct::insert($param["products"]);

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

        $count = SendSample::destroy($id);

        return $count;
    }

}
