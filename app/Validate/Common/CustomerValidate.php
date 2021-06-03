<?php
/**
 * 达人验证器
 *
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class CustomerValidate extends BaseValidate
{
    protected $rule = [
        'nickname'        => 'required',
        'platform_user_id' => 'required|unique:customers,platform_user_id,NULL,id,deleted_at,NULL',
        'contact_person'      => 'required',
        'mobile'      => 'nullable|size:11',
        'fans_number'       => 'required|numeric',
        'shop_score'       => 'required|numeric',
        'shop_sales'       => 'required|numeric',
        'shop_category_id'       => 'required',

    ];

    protected $message = [
        'nickname.required'        => '达人昵称不能为空',
        'platform_user_id.required' => '平台用户ID不能为空',
        'platform_user_id.unique' => '平台用户ID已存在，请确认',
        'contact_person.required'      => '联系人不能为空',
        'mobile.size'      => '请输入11位手机号码',
        'fans_number.required'      => '店铺粉丝量不能为空',
        'fans_number.numeric'      => '店铺粉丝量必须为数字',
        'shop_score.required'      => '店铺评分不能为空',
        'shop_score.numeric'      => '店铺评分必须为数字',
        'shop_sales.required'      => '店铺销量不能为空',
        'shop_sales.numeric'      => '店铺销量必须为数字',
        'shop_category_id.required'      => '请选择店铺类目',

    ];

    protected $scene = [
        'add'  => ['nickname', 'platform_user_id', 'mobile','contact_person','fans_number','shop_score','shop_sales','shop_category_id',],
        'edit'  => ['nickname', 'platform_user_id', 'mobile','contact_person','fans_number','shop_score','shop_sales','shop_category_id',],
    ];


}
