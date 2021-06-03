<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = array (
            0 => array(
                    'id' => 1,
                    'setting_group_id' => 1,
                    'name' => '基本设置',
                    'description' => '后台的基本信息设置',
                    'code' => 'base',
                    'content' => '[{"name":"后台名称","field":"name","type":"text","content":"聚惠供应链","option":""},{"name":"后台简称","field":"short_name","type":"text","content":"聚惠供应链","option":""}]',
                    'sort_number' => 1000,
                    'create_time' => 1587879871,
                    'update_time' => 1596008207,
                    'delete_time' => 0,
                ),
            1 => array(
                    'id' => 2,
                    'setting_group_id' => 1,
                    'name' => '登录设置',
                    'description' => '后台登录相关设置',
                    'code' => 'login',
                    'content' => '[{"name":"登录token验证","field":"token","type":"switch","content":"1","option":null},{"name":"验证码","field":"captcha","type":"select","content":"1","option":"0||不开启\r\n1||图形验证码"},{"name":"登录背景","field":"background","type":"image","content":"\/storage\/attachment\/bUGWlU7XvCgFYQ2ZreVaD4FtTpumeftPNl1GLUfF.jpeg","option":null}]',
                    'sort_number' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595556703,
                    'delete_time' => 0,
                ),
            2 => array(
                    'id' => 3,
                    'setting_group_id' => 1,
                    'name' => '首页设置',
                    'description' => '后台首页参数设置',
                    'code' => 'index',
                    'content' => '[{"name":"默认密码警告","field":"password_warning","type":"switch","content":"0","option":null},{"name":"是否显示提示信息","field":"show_notice","type":"switch","content":"0","option":null},{"name":"提示信息内容","field":"notice_content","type":"text","content":"欢迎来到使用本系统，左侧为菜单区域，右侧为功能区。","option":null}]',
                    'sort_number' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1596008219,
                    'delete_time' => 0,
                ),
        );

        DB::table('setting')->insert($arr);
    }
}
