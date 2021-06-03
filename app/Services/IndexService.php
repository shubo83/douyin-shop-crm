<?php
/**
 * 首页 服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Http\Model\Common\Customer;
use App\Http\Model\Common\CustomerSales;
use App\Libs\SystemInfo;
use App\Http\Model\Admin\AdminLog;
use App\Http\Model\Admin\AdminMenu;
use App\Http\Model\Admin\AdminRole;
use App\Http\Model\Admin\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexService
{
    /**
     * @var Request 框架request对象
     */
    private $request;

    /**
     * IndexService 构造函数.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 统计后台系统信息
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 10:24:47
     */
    public function getInfo()
    {
        $indexConfig = config('admin.admin.index');

        $loginUser   = session(LOGIN_USER);

        if (in_array(1,$loginUser->role)){//管理员

            //默认密码修改检测
            $password_danger = 0;
            if ($indexConfig['password_warning'] && password_verify('123456', base64_decode($loginUser['password']))) {
                $password_danger = 1;
            }

            //是否首页显示提示信息
            $show_notice    = $indexConfig['show_notice'];
            //提示内容
            $notice_content = $indexConfig['notice_content'];

            return [
                //后台用户数量
                'admin_user_count' => AdminUser::count(),
                //后台角色数量
                'admin_role_count' => AdminRole::count(),
                //后台菜单数量
                'admin_menu_count' => AdminMenu::count(),
                //后台日志数量
                'admin_log_count'  => AdminLog::count(),
                //系统信息
                'system_info'      => SystemInfo::getSystemInfo(),
                //访问信息
                'visitor_info'     => $this->request,
                //默认密码警告
                'password_danger'  => $password_danger,
                //当前用户
                'user'             => $loginUser,
                //是否显示提示信息
                'show_notice'      => $show_notice,
                //提示内容
                'notice_content'   => $notice_content,
            ];
        }

        if (in_array(2,$loginUser->role)) {//销售

            $data = [
                //本月业绩
                'performance' => CustomerSales::whereIn('customer_id', Customer::where('admin_user_id',$loginUser['id'])->where("status",3)->pluck('id') )->where('year',date("Y"))->where('month',date("n"))->sum("sales"),
                //跟进中达人
                'following_customer_count' => Customer::where('admin_user_id',$loginUser['id'])->where("status",2)->count(),
                //已跟进达人
                'followed_customer_count' => Customer::where('admin_user_id',$loginUser['id'])->where("status",3)->count(),
                //我的达人总数
                'total_customer'  => Customer::where('admin_user_id',$loginUser['id'])->count(),
            ];
            return $data;
        }




    }

}
