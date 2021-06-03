<?php
namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Product;
use App\Repositories\Admin\Contracts\ProductInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    public function get($param)
    {
        return Product::addWhere($param)->get();
    }

    public function getPageData($param, $perPage)
    {
        return Product::addWhere($param)->paginate($perPage);
    }

    public function create($param)
    {
        DB::beginTransaction();
        try {
            $res = Product::create($param);
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
        return Product::find($id);
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

        $count = Product::destroy($id);

        return $count;
    }

}
