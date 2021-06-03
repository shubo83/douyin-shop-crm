<?php

namespace App\Http\Model\Common;

use App\Http\Model\Admin\AdminUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];

    /**
     * @var array  可搜索字段
     */
    protected $searchField = ['nickname', 'wechat_account','mobile'];
    protected $whereField = ['status','admin_user_id','level'];
    protected $appends = ['status_text'];

    public function admin_user()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function shop_category()
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function getStatusTextAttribute()
    {
        if ($this->status==1) return "公海";
        if ($this->status==2) return "跟进中";
        if ($this->status==3) return "已跟进";
    }
}
