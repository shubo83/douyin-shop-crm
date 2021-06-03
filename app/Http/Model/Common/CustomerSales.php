<?php

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\Model;

class CustomerSales extends BaseModel
{
    protected $guarded = [];

    /**
     * @var array  可搜索字段
     */
    protected $searchField = [];
    protected $whereField = ['year','customer_id','month'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shop()
    {
        return $this->belongsTo(Dictionary::class,"shop_id","id");
    }

}
