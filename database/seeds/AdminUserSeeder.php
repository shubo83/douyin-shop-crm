<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
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
                    'username' => 'root',
                    'password' => base64_encode(password_hash('rootroot', 1)),
                    'nickname' => '超级管理员',
                    'avatar' => '/static/admin/images/latte.png',
                    'role' => '1',
                    'status' => 1,
                    'delete_time' => 0,
                )
        );

        DB::table('admin_user')->insert($arr);
    }
}
