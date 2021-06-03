<?php
/**
 * 产品验证器
 *
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class CustomerAddressValidate extends BaseValidate
{
    protected $rule = [
        'consignee_name'        => 'required',
        'consignee_mobile'        => 'required',
        'consignee_address'        => 'required',
    ];

    protected $message = [
        'consignee_name.required'        => '收货人姓名不能为空',
        'consignee_mobile.required'        => '收货人手机号不能为空',
        'consignee_address.required'        => '收货人地址不能为空',
    ];

    protected $scene = [
        'add'  => ['consignee_name', 'consignee_mobile', 'consignee_address'],
        'edit'  => ['consignee_name', 'consignee_mobile', 'consignee_address'],
    ];


}
