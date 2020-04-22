<?php

namespace app\admin\controller;

use think\Controller;

use think\Db;
use think\Request;
use think\captcha\Captcha;
use app\common\model\Users;


class LoginController extends Controller
{
    //返回一个后台登录页面
    public function login()
    {
        // return md5('1');
        return view('login/login');
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

    //处理登录操作
    public function dologin(Request $req)
    {
        // 1.接收到用户提交过来的登录信息
        // $data = $req->post();
        // var_dump($data);
        
            $data = $_POST;

            $uname = $req->post('uname');
            // 数据库中存的密码需要进行加密
            $upwd = $req->post('upwd',null,'md5');
            $code = $req->post('code');
            $auth = $req->post('auth');

            // 2. 判断验证码是否正确

            // 检测输入的验证码是否正确，$value为用户输入的验证码字符串
            if( !captcha_check($code ))
            {
                // 如果验证失败，就会执行这个代码体
                return $this->error('验证码输入错误，请重新输入验证码');
            }

            // 3. 判断当前登录用户是否存在
            // 如果用户名和密码都对，表示存在此用户
            // select * from users where uname = 'zhangsan' and upwd='123456';
            // find表是只获取1条记录
            $where['uname'] = $uname;
            $where['upwd'] = $upwd;
            $user = Db::name('base_user')->where($where)->find();
//            $user = Db::name('base_user')->where($where)->find();
//            dump($user);die;
//            $user = Users::where('uname','=',$uname)->where('upwd','=',$upwd)->find();
//
//            $auth = $user->auth;
            
            if($user['auth'] == '4'){
                return $this->error('没有权限，不能登录！！');
                die;
            }
            // 4. 如果存在就登录，如果不存在就不能登录
            if($user){
                // 如果登录成功，在session中记录一下
                // session_start();
                // $_SESSION['adminFlag'] =true;

                // 框架中的session，提供了一个辅助函数session（）来读取和写入session
                // session('键','值')
                // 设置一个名叫adminFlag的session，表示后台用户是否登录
                session('adminFlag',true);
                // 设置一个变量，用于存储后台登录用户的信息，就可以在任何页面获取到当前用户用的了，比如要获取登录用户的用户名
                session('adminUser',$user);

                return $this->success('登录成功','/admin/index');
            }else{
                // 如果登录失败
                return $this->error('登录失败,请检查账号或密码');
            }
        

    }


    // 退出登录
    public function logout()
    {
        // 删除session
        session('adminFlag',null);
        session('adminUser',null);

        // 跳转到登录页面
        $this->success('退出登录成功','/admin/login');
    }

    

}
