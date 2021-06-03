<?php

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\SoftDeletes;

class SendSampleProduct extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function send_sample()
    {
        return $this->belongsTo(SendSample::class);
    }
}
