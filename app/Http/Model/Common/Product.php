<?php

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
}
