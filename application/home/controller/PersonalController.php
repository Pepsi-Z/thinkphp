<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\Order;
use app\common\model\Addr;
use app\common\model\Users;
use Exception;

class PersonalController extends Controller
{
    //显示个人信息
    public function personalinformation(){
        return view('personal/personalinformation');
    }
    // 显示登录信息
    public function loadinformation()
    {   
        $data = Users::where('uid','=',session('homeUser.uid'))->find();
        return view('personal/loadinformation',['data'=>$data]);
    }
    //修改登录信息
    public function loadupdate(Request $request)
    {
        $data = $request->post();
        if ($data['upwd'] != $data['reupwd']) {
            return $this -> error('两次密码输入不一致','/loadinformation');
        }
        // $data = $request->post('upwd',null,'md5');
        // var_dump($data);die;
        $data['upwd'] = md5($data['upwd']);
        
        try {
            Users::update($data,['uid'=>session('homeUser.uid')],true);
        } catch (\Exception $e) {
            return $this -> error('修改信息失败','/loadinformation');
        }
        return $this -> success('修改信息成功','/loadinformation');
    }
    //修改个人资料
    public function personupdate(Request $request)
    {   
        $data = $request->post();
        $file = $request->file('fp');
         // var_dump($file);die();
        $uid = session('homeUser.uid');
        $info = $file->move(config('app.save_path'));
            if (!$info) {
                return $this -> error('头像上传失败','/personalinformation');
            }else{
                $path = $info->getSaveName();
            } 
        $data['hp'] = $path;
        // var_dump($data);
        $res = Users::update($data,['uid'=>$uid],true);
        //var_dump($res);die();
        if ($res) {
            return $this -> success('信息保存成功','/personalinformation');
        }else{
            return $this -> error('信息保存失败','/personalinformation');
        }
        // try{
        //     Users::update($res,['uid'=>$uid],true);
        // }catch(\Exception $e){
        //     return $this->error('商品信息修改失败','/personalinformation');
        // }
    }
    //显示订单信息
    public function orderinformation()
    {   

        $data = Order::where('user_uid','=',session('homeUser.uid'))->paginate(5)->appends($_GET);

        return view('personal/orderinformation',['data'=>$data]);
    }
    //显示地址信息
    public function addrinformation()
    {
        $data = Addr::where('user_id','=',session('homeUser.uid'))->select();
        return view('personal/addrinformation',['data'=>$data]);
    }
    //显示修改地址信息页面
    public function updateaddr($id)
    {      
        $data = Addr::get($id);
        return view('personal/updateaddr',['data'=>$data,'aid'=>$id]);
    }
    //修改地址信息
    public function doupdateaddr(Request $request)
    {
        $data = $request->post();
        $aid = $request->post('aid');
        // var_dump($data);
        try{
            Addr::update($data,['aid'=>$aid],true);
        }catch(\Exception $e){
            return $this -> error('地址信息修改失败','/updateaddr/'.$aid);
        }
        return $this -> success('地址信息修改成功','/addrinformation');
    }
    //删除地址方法
    public function deleteaddr($id)
    {   
        // var_dump($id);die();
        Addr::destroy($id);
            
        return redirect('/addrinformation');
    }
    //添加地址的页面
    public function addaddr()
    {
        return view('personal/addaddr');
    }

    //添加地址的方法
    public function doaddaddr(Request $request)
    {
        $data = $request->post();
        if (empty($data['aname'])) {
            return $this -> error('收货人不能为空','/addaddr');
        }
        if (empty($data['addr'])) {
            return $this -> error('收货地址不能为空','/addaddr');
        }
        if (empty($data['tel'])) {
            return $this -> error('收货电话不能为空','/addaddr');
        }
        $data['user_id'] = session('homeUser.uid');
        $res = Addr::create($data);
        if ($res) {
            return $this -> success('地址保存成功','/addrinformation');
        }else{
            return $this -> error('地址保存失败','/addaddr');
        }
    }
    //确认订单方法
    public function confirm($id)
    {
        Order::update(['status'=>3],['oid'=>$id],true);
        return redirect('/orderinformation');
    }
     //取消订单方法
    public function cancel($id)
    {
        Order::update(['status'=>4],['oid'=>$id],true);
        return redirect('/orderinformation');
    }

}
