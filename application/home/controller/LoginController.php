<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\captcha\Captcha;
use app\common\model\Users;
class LoginController extends Controller
{
   // 1. 返回前台登录页
    public function login()
    {
        return view('login/jd-login');
    }
     // 生成验证码的方法
    public function verify()
    {

        $config = [
            // 验证码字体大小
            'fontSize' => 30,
            // 验证码位数
            'length' => 3,
            // 关闭验证码杂点
            'useNoise' => false,
            // 实现中文的配置项
            // 'useZh'=> true,
            // 'zhSet'=>'们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这'
        ];

        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    // 2. 处理前台登录逻辑
    public function dologin(Request $req)
    {

    
        $data = $req->post();
        // var_dump($data);die;
        // 1. 获取到用户登录的用户名和密码
        $uname = $req->post('uname');
        $upwd = md5($data['upwd']);
        // $upwd = $req->post('upwd',null,'md5');
        $code = $req->post('code');
        // 检测输入的验证码是否正确，$value为用户输入的验证码字符串
            if( !captcha_check($code ))
            {
                // 如果验证失败，就会执行这个代码体
                return $this->error('验证码输入错误，请重新输入验证码');
            }


            $condition = [];
        
            $condition[] = array('uname','=',$uname);
            $condition[] = array('upwd','=',$upwd);
            // var_dump($condition);die;
        $res = Users::where($condition)->find();
        // var_dump($res);die;
        if ($res) {
            session('homeUser',$res);
            session('homeFlag',true);
            session('carts.sum',0);
            return $this -> success('登录成功','/');
        }else{
            return $this -> error('登录失败','/');
        }
        // 2. 判断数据库中此用户是否存在
        // $user = Users::where('uname','=',$uname)->where('upwd','=',$upwd)->find();
        // var_dump($user);die;
        // // 3. 判断用户是否是有效的登录用户
        // if($user){

        //     // 登录成功，需要将登录成功的状态还有当前的登录用户保存到session,这样各页面就知道是否有用户登录成功了
        //       session('homeFlag',true);
        //     // 设置一个变量，用于存储后台登录用户的信息，就可以在任何页面获取到当前用户用的了，比如要获取登录用户的用户名
        //     session('homeUser',$user);

        //     // 如果用户是通过点击结算按钮到的登录页面，登录成功后，应该跳转到用户信息填写页面；
        //     // 如果用户是通过其他页面跳转到登录页面，那登录成功后应该跳转到首页
        //     if(!empty(session('back'))){

               
        //         return $this->success('登录成功','/');
        //     }else{
        //         return $this->success('登录成功','/');
        //     }
            
        // }else{
        //     return $this->error('登录失败，账号或密码错误');
        // }
    }   

    // 3. 退出登录
    public function logout()
    {
        // 判断用户是否登录的session
        session('homeFlag',null);
        // 清空session中保存的前台用户信息
        session('homeUser',null);

         session('back',null);

         session('cart',null);

         session('orders',null);

        // 跳转到首页
        return redirect('/');
    }

    public function zhuce()
    {
        return view('/login/zhuce');
    }
}
