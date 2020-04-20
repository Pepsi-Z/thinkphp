<?php

namespace app\admin\controller;

use app\common\model\Good;
use think\Controller;
//use Think\Db;
use think\Db;
use think\Request;
use app\common\model\Order;
use app\common\model\Detail;
use Exception;

class OrderController extends Controller
{	
	public function index()
    {	
	//1.获取模型里的数据
	//把模型里的数据数据显示到指定的页面上
        $conditon = [];
        // 如果用户名不为空
        if(!empty($_GET['name'])){
            $conditon[] = ['name','like',"%{$_GET['name']}%"];
            $this->assign('name',$_GET['name']);
        }

		// 分页查询，每页2条 只查询满足条件的分页用户
        // appends()用于在点击前台模板中下一页或者上一页时，将查询条件带到后台
        $data = Db::name('base_zuopin')
            ->alias('z')
            ->join('base_match m','z.mid = m.id')
            ->join('base_user u','z.uid = u.uid')
            ->where($conditon)
            ->field('z.*,u.uid,u.uname,u.auth,m.id,m.title')
//            ->select();
            ->paginate(5)
            ->appends($_GET);
//        dump($data);die;
//        $order = Order::where($conditon)->paginate(5)->appends($_GET);

		// 参数1 ：需要返回的视图
            // 参数2 ：需要给视图绑定的数据，数组形式
            // ['在视图中表示通过模型获取到的数据order'=>上面获取到的数据]
            // 也就是说把获取 到的数据，绑定到页面上，并给这个数据起个别名
		return view('order/index',['data'=>$data]);
	}
	// 返回订单修改页面
	public function edit()
    {

        // 返回修改操作
        // 1. 获取要修改的用户的id
        $oid = $_GET['oid'];

        // 根据uid，获取当前要修改的记录
        // 如果只是获取一条记录
        // Users::find($uid);
        // 参数是要获取的用户的id
        $order = Order::get($oid);

      // 2.返回修改页面，将当前记录绑定到页面上
         return view('order/edit',['order'=>$order]);
    }

    // 执行订单修改
    public function update()
    {
         // 1. 获取要修改的用户的id
        $oid = $_GET['oid'];
        // 所有提交的要修改的数据，放在了$_POST全局变量中
        // var_dump($_POST);DIE;
        // 2. 执行修改操作
        // update shop_users set uname = $_POST['uname'],sex = $_POST['sex'],tel= $_POST['tel'],auth = $_POST['auth'] where uid = $_GET['uid']
        // 参数1：表示要修改的记录
        // 参数2 ： 要修改的记录的id
        // 参数3：表示只修改数据表中存在的字段，不存在的直接过滤掉
        try{
           Users::update($_GET,['oid'=>$oid],true); 
           // throw new Exception('修改用户失败啦');
       }catch(\Exception $e){
            return $this->error('用户修改失败','/oredr/edit?oid='.$oid);
       }
         return $this->success('用户修改成功','/order/index');

    }
	//订单删除
	public function delete()
    {
        //写删除的业务逻辑
        // 1. 获取要删除的记录的id
        $oid = $_GET['oid'];
        // 2. 执行删除操作
        // $user = User::get($uid);
        // $user->delete();

        $res = Order::destroy($oid);

        // 3. 如果删除成功跳转到用户首页，失败也是跳转到用户首页，这是提示信息不一样
        if($res){
            return $this->success('订单删除成功','/order/index');
        }else{
             return $this->error('订单删除失败','/order/index');
        }
    }
    // 订单发货
    public function deliver($id)
    {
        $id = session('adminUser');
        dump($id);die;
        $status = Db::table('shop_orders')->where('oid','=',$id)->field('status')->find();
        if($status['status'] == 1){
            $gid = Db::table('shop_details')->where('orders_oid','=',$id)->field('gid,cnt')->find();
            $data = Db::table('shop_goods')->where('gid','=',$gid['gid'])->find();
            $data['salecnt'] = $data['salecnt'] + $gid['cnt'];
            Db::table('shop_goods')->update($data);
            Order::update(['status'=>2],['oid'=>$id]);
        }else{
            Order::update(['status'=>2],['oid'=>$id]);
        }


        return redirect('/order/index');
    }
    //订单详情	
    public function xiangqing($oid)
      {
//          dump($oid);die;
        $res=Detail::where('orders_oid','=',$oid)->select();

//         var_dump($res);die;
        return view('order/liulan',['res'=>$res]);
      }

}
