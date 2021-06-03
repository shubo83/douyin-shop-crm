<?php

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    protected $whereField = ['customer_id'];
}
