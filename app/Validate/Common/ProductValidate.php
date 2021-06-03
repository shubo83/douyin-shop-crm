<?php
/**
 * 产品验证器
 *
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class ProductValidate extends BaseValidate
{
    protected $rule = [
        'title'        => 'required|unique:products,title,NULL,id,deleted_at,NULL',
        'cover' => 'image',
    ];

    protected $message = [
        'title.required'        => '产品名称不能为空',
        'title.unique'        => '产品名称已存在',
        'cover.image' => '请选择代表图',
    ];

    protected $scene = [
        'add'  => ['title', 'cover'],
        'edit'  => ['title', 'cover'],
    ];


}
