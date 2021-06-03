<?php

/**
* 后台设置:后台管理方面的设置
* 此配置文件为自动生成，生成时间2020-07-29 02:34:47
* @author yuxingfei<474949931@qq.com>
*/

return [
    //基本设置:后台的基本信息设置
    'base'=>[
        //后台名称
        'name'=>'抖音小店达人管理系统',
        //后台简称
        'short_name'=>'达人管理',
    ],
    //登录设置:后台登录相关设置
    'login'=>[
        //登录token验证
        'token'=>'1',
        //验证码
        'captcha'=>'1',
        //登录背景
        'background'=>'/static/admin/images/default-background.jpg',
    ],
    //首页设置:后台首页参数设置
    'index'=>[
        //默认密码警告
        'password_warning'=>'1',
        //是否显示提示信息
        'show_notice'=>'0',
        //提示信息内容
        'notice_content'=>'欢迎来到使用本系统，左侧为菜单区域，右侧为功能区。',
    ],
];
