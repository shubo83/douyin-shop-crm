## 抖音小店达人管理系统(CRM)

本系统适用于，开通抖音小店，有专职销售团队负责寻找抖音带货达人的贸易或供应链公司。

#### 系统主要模块

* 权限管理
* 员工管理(销售、寄样审核等人员)
* 产品管理
* 达人管理
* 寄样管理
* 财务管理
* 数据统计(销售数据)

其他模块根据业务推进持续更新


## 安装
#### clone 项目到本地
```
git clone https://github.com/shubo83/douyin-shop-crm.git
```

#### 安装项目依赖
```
composer install
```

#### 配置数据库


新建本地数据库、用户名、密码，并设置编码格式为utf8mb4

拷贝.env.example文件，更名为.env

执行命令生成应用key

```
php artisan key:generate
```

修改 `.env` 文件内的数据库配置选项

#### 运行数据库迁移
```
php artisan migrate
``` 
#### 菜单生成数据填充
```
php artisan db:seed
``` 
#### 公共磁盘创建
```
php artisan storage:link
``` 

#### 最后一步，别忘了把项目设置为程序运行用户哟

例如我的程序运行用户是www用户，则命令如下:  
```
chown -R www:www ./douyin-shop-crm/
``` 

#### 服务器配置
可参考 [Laravel 7 安装配置](https://learnku.com/docs/laravel/7.x/installation/7447)

#### 访问后台
访问`/admin`，默认超级管理员的账号`root`,密码为`rootroot`。


## 感谢
本项目基于 [laravel-admin](git@github.com:yuxingfei/laravel-admin.git) 开发
