<?php
/**
 * 后台基础控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Facades\AuthFacade;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Traits\Admin\AdminTree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , AdminTree;

    public $baseVar;
    /**
     * 构造函数
     *
     * BaseController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        //登录用户信息
        $loginUser   = session(LOGIN_USER);
        //基础变量
        $this->baseVar     = $this->baseVar($loginUser);
        //当前route name
        $url         = request()->route()->getName();

        //使用app()->make 实例化注册类
        $menu = app()->make(AdminMenuInterface::class)->findByRouteName($url);
        if ($menu){
            $this->baseVar['admin']['title'] = $menu->name;
        }
        AuthFacade::adminLog($url,$loginUser,$menu);

        if ('admin.auth.login' !== $url
            && !request()->pjax()
            && session()->has(LOGIN_USER))
        {
            $this->baseVar['admin']['menu'] = $this->getLeftMenu($url,$loginUser);
        }

        //全局通用变量
        view()->share('admin',$this->baseVar['admin']);
        view()->share('debug',$this->baseVar['debug']);
        view()->share('cookiePrefix',$this->baseVar['cookie_prefix']);
    }

    /**
     * 基础变量
     *
     * @param $loginUser
     * @return array
     * Author: Stephen
     * Date: 2020/7/24 16:03:52
     */
    public function baseVar($loginUser) :array
    {
        $admin_config = config('admin.admin.base');
        $perPage      = request()->cookie('admin_per_page') ?? 10;
        $perPage      = $perPage < 100 ? $perPage : 100;

        return [
            'debug'               => env('APP_DEBUG') ? 'true' : 'false',
            'cookie_prefix'       => '',
            'admin'               => [
                'pjax'            => request()->pjax(),
                'user'            => $loginUser,
                'menu'            => 1,
                'name'            => $admin_config['name'] ?? '',
                'author'          => $admin_config['author'] ?? '',
                'version'         => $admin_config['version'] ?? '',
                'short_name'      => $admin_config['short_name'] ?? '',
                'per_page'        => $perPage,
                'per_page_config' => [10,20,30,50,100]
            ]
        ];

    }

    public function setTitle($title){
        $this->baseVar["admin"]["title"] = $title;
        view()->share('admin',$this->baseVar['admin']);
    }


    /**
     * 后台返回成功公用方法
     * @param $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminSuccess($message="操作成功")
    {
        $referer = request('referer',request()->header("referer"));
        return Redirect::to($referer)->with("success_message",$message);
    }

    /**
     * 后台返回失败公用方法
     * @param $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminError($message="操作失败")
    {
        return Redirect::back()->withInput()->with("error_message",$message);
    }

    /**
     * API返回失败公用方法
     *
     * @param string $message
     * @param array $data
     * @return array
     */
    public function apiSuccess($data=[],$message="操作成功")
    {
        return ["code"=>0,"message"=>$message,"data"=>$data];
    }

    /**
     * API返回失败公用方法
     *
     * @param $message
     * @param array $data
     * @return array
     */
    public function apiError($message="操作失败",$data=[])
    {
        return ["code"=>-1,"message"=>$message,"data"=>$data];
    }
}
