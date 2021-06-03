<?php
/**
 * 产品验证器
 *
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class SendSampleValidate extends BaseValidate
{
    protected $rule = [
        'customer_id'        => 'required',
        'customer_address_id'        => 'required',
        'product_ids'        => 'required',
    ];

    protected $message = [
        'customer_id.required'        => '请选择达人',
        'customer_address_id.required'        => '请选择达人收货地址',
        'product_ids.required'        => '请选择寄样产品',
    ];

    protected $scene = [
        'add'  => ['customer_id', 'customer_address_id', 'product_ids'],
        'edit'  => ['customer_id', 'customer_address_id', 'product_ids'],
    ];


}
