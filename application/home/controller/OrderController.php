<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\Order;
use app\common\model\Detail;

class OrderController extends Controller
{
   //收货人信息确认页
    public function info()
    {
        return view('order/jd-info');
    }

    // 订单结算确认页
    public function jsy(Request $req)
    {
    	// 1. 获取订单需要的数据
   //  	（1）收件人、电话、地址、留言  ： 通过收货信息页提交过来的数据
    	session('orders.rec',$req->post('rec'));
    	session('orders.tel',$req->post('tel'));
    	session('orders.addr',$req->post('addr'));
    	session('orders.umsg',$req->post('umsg'));
    	

 		// （2）购物车中选中的商品      ： session('cart') 购物车这个session
 		$carts = session('cart');
 		// （3）选购商品的总价、总数量   : 
 		// session('orders.total',$total); 
 		// session('orders.num',$num); 
 		 // 已经在别的页面赋好值了
 		$num = session('orders.cnt');
 		$total = session('orders.total');
        
 		// 2. 将上面的数据显示在 订单结算确认页中
 		return view('order/jd-jsy',['carts'=>$carts,'num'=>$num,'total'=>$total]);

    }


    //订单成功方法
    public function ok()
    {   
        
        // sql ="select * from shop_goods where catr_id = order by字段名[desc]"
    	// 1. 获取到要生成的订单数据
    	// 订单号   20180628103522123456 YmdHis随机3位数作为订单号
    	session('orders.oid',date('YmdHis').mt_rand(100,999));
    	// 订单总金额session('orders.total')
    	// 订单总数量session('orders.num')
    	// 当前下单用户的id
    	session('orders.user_uid',session('homeUser.uid'));
    	// 收件人session('orders.rec')
    	// 地址session('orders.addr')
    	// 电话session('orders.tel')
    	// 留言信息session('orders.umsg')
    	// 订单状态1下单未发货2出库,未收货3收货完成4作废
    	session('orders.status',1);
    	// 下单时间
    	session('orders.create_at',time());

    	try{
    		// 2. 添加到数据库中的订单表和订单详情表
	    	// Order::create(data,true);
	    	// 执行添加操作，返回添加成功的那个订单
	    	$order = Order::create(session('orders'),true);

	    	// 订单详情数据是从session('cart')中取的
	    	// [
	    	// 	[gid=>1,gname=>'小米手机',price=>100,cnt=>2],  orders_oid =>1
	    	// 	[gid=>1,gname=>'小米手机2',price=>200,cnt=>2], orders_oid =>1
	    	// 	[gid=>1,gname=>'小米手机3',price=>300,cnt=>2], orders_oid =>1
	    	// 	[gid=>1,gname=>'小米手机4',price=>400,cnt=>2], orders_oid =>1
	    	// ]
	    	// 这种添加方式的话，添加的详情不知道属于哪个订单
	    	// Detail::create(session('cart'),true);
	    	// 这个地方需要用到关联查询
	    	// $order->detail() 先找到跟这个订单相关的订单详情模型，每个模型的orders_oid字段的值就有了，session('cart')中存储了订单详情表中其他其他字段的值

			// $order->detail()就是订单详情模型 
	    	$order->detail()->saveAll(session('cart'));
    	}catch(\Exception $e){
    		// return $this->error('订单提交失败','/');
    	}
    	
    	// 获取到前台页面需要的订单号
    	$orderid = session('orders.oid');
    	// 获取到订单总金额
    	$total = session('orders.total');
    	// 下单成功，清空购物车

    	session('cart',null);
    	session('orders',null);

    	// 3. 如果添加成功，跳转到订单成功页面
    	return view('order/jd-order',['orderid'=>$orderid,'total'=>$total]);
    }


    // 4. 我的订单
    public function myorder()
    {
        // 1. 获取页面需要的数据
        // （1） 当前用户的订单，订单详情
        // 当前用户的订单
        $orders =Order::where('user_uid','=',session('homeUser.uid'))->select();
       

        // 2. 返回我的订单页
        return view('order/jd-myorder',['orders'=>$orders]);
    }

    public function presonal()
    {
        return view('userinfo/presonal');
    }

}
