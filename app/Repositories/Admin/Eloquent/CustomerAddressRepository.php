<?php
namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\CustomerAddress;
use App\Repositories\Admin\Contracts\CustomerAddressInterface;
use Illuminate\Support\Facades\DB;

class CustomerAddressRepository implements CustomerAddressInterface
{
    public function get($param)
    {
        return CustomerAddress::addWhere($param)->get();
    }

    public function getPageData($param, $perPage)
    {
        return CustomerAddress::addWhere($param)->paginate($perPage);
    }

    public function create($param)
    {
        DB::beginTransaction();
        try {
            $res = CustomerAddress::create($param);
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
        return CustomerAddress::find($id);
    }

    public function update($param)
    {
        $data = $this->findById($param['id']);

        DB::beginTransaction();
        try {
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

        $count = CustomerAddress::destroy($id);

        return $count;
    }

}
