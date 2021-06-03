<?php

namespace App\Http\Model\Common;

use App\Http\Model\Admin\AdminUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class SendSample extends BaseModel
{
    use SoftDeletes;
    protected $guarded = ["product_ids"];
    protected $appends = ["apply_status_text"];
    protected $whereField = ['admin_user_id','customer_id','apply_status'];

    public function admin_user(){
        return $this->belongsTo(AdminUser::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function address(){
        return $this->belongsTo(CustomerAddress::class,"customer_address_id");
    }

    public function send_sample_products()
    {
        return $this->hasMany(SendSampleProduct::class);
    }

    public function getApplyStatusTextAttribute()
    {
        if ($this->apply_status==1) return "审核中";
        if ($this->apply_status==2) return "审核拒绝({$this->reject_reason})";
        if ($this->apply_status==3) return "已发货";
        if ($this->apply_status==4) return "已签收(".date("Y-m-d",strtotime($this->sign_date)).")";
    }
}
