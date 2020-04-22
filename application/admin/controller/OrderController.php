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
        $conditon = [];
        // 如果用户名不为空
        if(!empty($_GET['name'])){
            $conditon[] = ['name','like',"%{$_GET['name']}%"];
            $this->assign('name',$_GET['name']);
        }
        $data = Db::name('base_zuopin')
            ->alias('z')
            ->join('base_match m','z.mid = m.id')
            ->join('base_user u','z.uid = u.uid')
            ->where($conditon)
            ->field('z.*,u.uid,u.uname,u.auth,m.id,m.title')
            ->paginate(5)
            ->appends($_GET);
		return view('order/index',['data'=>$data]);
	}
	// 返回修改页面
	public function edit()
    {

        // 返回修改操作
        // 1. 获取要修改的用户的id
        $id = $_GET['id'];
        $opus = Db::name('base_zuopin')->where('id','=',$id)->find();
        if ($opus['type'] == 1){
            $data['type'] = 2;
            $res = Db::name('base_zuopin')->where('id','=',$id)->update($data);
            if ($res){
                $arr['uid'] = $id;
                $arr['title'] = '您的参赛作品审核已通过！';
                $arr['time'] = date('Y-m-d H:i:s', time());
                $arr['type'] = 1;
                Db::name('base_tongzhi')->insert($arr);
            }
        }else{
            $data['type'] = 1;
            $res = Db::name('base_zuopin')->where('id','=',$id)->update($data);
            if ($res){
                $arr['uid'] = $id;
                $arr['title'] = '您的参赛作品被拒绝参加比赛！';
                $arr['time'] = date('Y-m-d H:i:s', time());
                $arr['type'] = 1;
                Db::name('base_tongzhi')->insert($arr);
            }
        }
        if ($res){
            return redirect('/order/index');
        }

    }

    // 执行修改
    public function update()
    {
        $uid = session('adminUser');
//        $uid = $uid['uid'];
         // 1. 获取要修改的用户的id
        $data = $_POST;
        $data['uid'] = $uid['uid'];
        $arr['zid'] = $data['zid'];
        $arr['uid'] = $data['uid'];
        $arr['score'] = $data['score'];
        $res = Db::name('base_dafen')->insert($arr);
        if ($res){
            return $this->success('修改成功','/order/index');
        }else{
            return $this->error('用户修改失败','/oredr/index');
        }

    }
	//删除
	public function delete()
    {
        $oid = $_GET['oid'];
        $res = Order::destroy($oid);
        if($res){
            return $this->success('订单删除成功','/order/index');
        }else{
             return $this->error('订单删除失败','/order/index');
        }
    }

    public function deliver($id)
    {
        $user = session('adminUser');
        $auth = $user['auth'];
        $data = Db::name('base_zuopin')
            ->alias('z')
            ->where('id','=',$id)
            ->find();

//        if ($auth == 3){
//            echo '打分';
//        }else{
//            return $this->error('只有评委才能打分','/order/index');
//        }
        return view('order/edit',['data'=>$data]);
    }

    public function xiangqing($oid)
      {
//          dump($oid);die;
        $res=Detail::where('orders_oid','=',$oid)->select();

//         var_dump($res);die;
        return view('order/liulan',['res'=>$res]);
      }

}
