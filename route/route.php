<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 表示是前台还是后台模块      Index控制器         表示Index控制器中的index方法

// admin                     /Index             /index


// 定义一条路由(一个路径，对应一个需要执行的方法)

// 使用强制路由,一个路由，对应一个闭包（也是一个方法）
Route::rule('xxoo1',function(){
	echo "欢迎大家来到我们美丽的家";
});



// 只要执行以下这些路由，就一定要判断一下后台用户是否登录，只有登录后才能执行相关路由。举个栗子，没有登录，就不能看用户列表

// 在执行路由之前，先判断一下有没有权限，如果有权限，再去执行相关路由
Route::group([],function(){

	// 访问后台首页
	Route::rule('admin/index','admin/Index/index');
	// 后台模块需要实现的功能
	// 用户模块
	// 添加用户页面的路由
	Route::rule('user/create','admin/UserController/create');
	// 执行用户添加的路由
	Route::rule('user/save','admin/UserController/save');
	// 返回用户列表的路由
	Route::rule('user/index','admin/UserController/index');
	// 返回修改用户页面的路由
	Route::rule('user/edit','admin/UserController/edit');
	//个人信息修改
	Route::rule('user/:id/xiugaiye','admin/UserController/xiugaiye');
	//执行修改操作的路由
	Route::rule('user/xiugai','admin/UserController/xiugai');
	// 执行用户修改的路由
	Route::rule('user/update','admin/UserController/update');
	// 删除用户的路由
	Route::rule('user/delete','admin/UserController/delete');
	
})->after(['\app\admin\behavior\CheckLogin']);





// 分类模块 静态路由+动态路由
// /cate/create/分类id


Route::group(['name'=>'cate/','prefix'=>'admin/CateController/'],function(){
	Route::rule('create/[:id]','create');
	Route::rule('save','save');
	Route::rule('index','index');
	Route::rule('delete/:id','delete');
	Route::rule(':id/edit','edit');
	Route::rule('update/:id','update');
})->after(['\app\admin\behavior\CheckLogin']);

Route::group([],function(){
    // 商品模块
	Route::rule('good/create','admin/GoodController/create');
	Route::rule('good/save','admin/GoodController/save');
	Route::rule('good/index','admin/GoodController/index');
	Route::rule('good/delete/:id','admin/GoodController/delete');
	Route::rule('good/:id/edit','admin/GoodController/edit');
	Route::rule('good/update/:id','admin/GoodController/update');
   // 商品上架路由
	Route::rule('good/up/:id','admin/GoodController/up');
   // 商品下架路由
	Route::rule('good/down/:id','admin/GoodController/down');
})->after(['\app\admin\behavior\CheckLogin']);






// 获取项目根目录的路由
Route::rule('rootpath',function(){
	// 获取app.php配置文件中的配置项
	return config('app.save_path');
	// return config('app.app_path');
});	

// 后台登录
 Route::rule('admin/login','admin/LoginController/login');
// 生成验证码的路由
 Route::rule('admin/code','admin/LoginController/verify');
 // 后台登录处理路由
 Route::rule('admin/dologin','admin/LoginController/dologin');
 Route::rule('admin/logout','admin/LoginController/logout');
// 订单模块



// 前台模块需要实现的功能
// 首页
Route::rule('/','home/IndexController/index');
// 列表页
Route::rule('/goodlist/[:id]','home/GoodController/goodlist');
// 详情页
Route::rule('/gooddetail/:id','home/GoodController/gooddetail');




// 购物车页
// 添加到购物车
Route::rule('cart/add','home/CartController/addCart');
// 购物车列表页
Route::rule('cart/list','home/CartController/listCart');
// 商品购买数量+1
Route::rule('cart/incr/:id','home/CartController/incr');
// 商品购买数量-1
Route::rule('cart/desc/:id','home/CartController/desc');
// 删除购物车中的商品
Route::rule('cart/delete/:id','home/CartController/delete');


// 只有登录的用户才能执行这个路由


Route::group([],function(){
	// 收货人信息确认页
	Route::rule('order/info','home/OrderController/info');
	// 订单结算确认页
	Route::rule('order/jsy','home/OrderController/jsy');
	// 订单成功页
	Route::rule('order/ok','home/OrderController/ok');
	// 我的订单
	Route::rule('order/myorder','home/OrderController/myorder');
	Route::rule('order/presonal','home/OrderController/presonal');

})->after(['\app\home\behavior\CheckLogin']);


// 订单管理 
// 返回订单修改页面
Route::rule('order/edit','admin/OrderController/edit');
// 执行订单修改
Route::rule('order/update/:id','admin/OrderController/update');
//  浏览订单
Route::rule('order/index','admin/OrderController/index');
//订单详情
Route::rule('liulan/xiangqing/:oid','admin/OrderController/xiangqing');
// 订单删除
Route::rule('order/delete','admin/OrderController/delete');
// 订单状态修改
Route::rule('order/deliver/:id','admin/OrderController/deliver');


Route::group([],function(){
//显示个人中心登录信息页面路由
	Route::rule('loadinformation','home/PersonalController/loadinformation');

	//显示个人中心个人信息页面路由
	Route::rule('personalinformation','home/PersonalController/personalinformation');

	//显示订单信息页面
	Route::rule('orderinformation','home/PersonalController/orderinformation');

	//确认收货方法
	Route::rule('confirm/:id','home/PersonalController/confirm');

	//取消订单方法
	Route::rule('cancel/:id','home/PersonalController/cancel');

	//修改个人信息
	Route::rule('loadupdate','home/PersonalController/loadupdate');

	//修改个人资料
	Route::rule('personupdate','home/PersonalController/personupdate');
})->after(['\app\home\behavior\CheckLogin']);



// 登录页
Route::rule('/login','home/LoginController/login');
//生成验证码
Route::rule('login/code','home/LoginController/verify');
// 处理处理逻辑
Route::rule('/dologin','home/LoginController/dologin');
// 退出登录
Route::rule('/logout','home/LoginController/logout');
// 注册页
Route::rule('/zhuce','home/RegController/reg');

Route::rule('/save','home/RegController/save');

return [

];
