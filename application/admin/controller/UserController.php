<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\common\model\Users;
use Exception;

class UserController extends Controller
{

    /**
     * 返回一个用户列表页面
     *
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 先通过模型获取需要的数据，然后将数据绑定到对应的视图上
        $conditon = [];
        // 如果用户名不为空

        if(!empty($_GET['uname'])){
            $conditon[] = ['uname','like',"%{$_GET['uname']}%"];
            $this->assign('uname',$_GET['uname']);
        }


        // 分页查询，每页2条 只查询满足条件的分页用户
        // appends()用于在点击前台模板中下一页或者上一页时，将查询条件带到后台
        $users = Users::where($conditon)->paginate(8)->appends($_GET);

//        $user = Db::name('')->where($conditon)->paginate(8)->appends($_GET);
        //2.返回用户列表页
        // 如何将数据跟视图绑定

            // 参数1 ：需要返回的视图
            // 参数2 ：需要给视图绑定的数据，数组形式
            // ['在视图中表示通过模型获取到的数据users'=>上面获取到的数据]
            // 也就是说吧获取 到的数据，绑定到页面上，并给这个数据起个别名

        return view('user/index',['user'=>$users]);

    }

    /**
     * 返回一个用户添加页面
     *
     * @return \think\Response
     */
    public function create()
    {
        // 返回 application\admin\view\user\insert.html页面
        // view函数对应的根目录就是当前模块下的view文件夹
        return view('user/insert');

        // return '返回了一个用户添加页面';
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request  请求对象，携带所哟跟请求相关的信息
     * @return \think\Response
     */
    public function save()
    {


        // var_dump($request->post('upwd',null,'md5'));
        // 1. 获取表单提交的数据
        // var_dump($_POST);
        $data = $_POST;
        // var_dump($data);die;

        // 2. 判断数据是否有问题

        // 2.0 密码是否为空
        if(empty($_POST['upwd']) || empty($_POST['reupwd'])){
            //遇到错误，返回到原来的添加页面
            return $this->error('密码不能为空','/user/create');
        }
        // 2.1 密码跟确认密码是佛一致
        if($_POST['upwd'] !== $_POST['reupwd']){
            return $this->error('密码跟确认密码必须一致','/user/create');
        }


        // 没有值的字段，可以生成相应的值

        // $data['upwd'] = md5($_POST['upwd']);

        // $data['create_at'] = time();

        // $data['height'] = '180';

        // var_dump($data);die;

        // 3. 向数据库的users表，执行添加操作
        // 使用模型前，一定要先引入，才能实例化
        // 引入的方法时：找到当前类Users所在的命名空间，在当前控制器中use一下，记得加上类名
        // $user = new Users;
        // $res = $user->save($data);

        // 添加用户的第二种方法，推荐
        // 参数1：表单提交过来的数据
        // 参数2：如果是true，会自动的对表单提交过来的数据进行过滤，只保留表中存在的字段的数据
        if($_POST['auth'] == '1'){
            return $this->error('添加用户失败，只能有一个管理员','/user/create');
        }
//        dump($data);die;
        $res = Users::create($data,true);
        // 表示添加成功
        if($res){
            return $this->success('添加用户成功','/user/index');
        }else{
            // 添加失败
            return $this->error('添加用户失败','/user/create');
        }

        



        // 4. 如果添加成功，跳回到列表页；如果失败，返回添加页
    }

   
    public function edit()
    {
        // 返回修改操作
        // 1. 获取要修改的用户的id
        $uid = $_GET['uid'];

        // 根据uid，获取当前要修改的记录
        // 如果只是获取一条记录
        // Users::find($uid);
        // 参数是要获取的用户的id
        $user = Db::name('base_user')->where('uid','=',$uid)->find();
//        $user = Users::get($uid);
//        dump($user);die;
        $auth = $user['auth'];
        if($auth == '1'){
            return $this->error('该用户不能被修改');
        }
      // 2.返回修改页面，将当前记录绑定到页面上
         return view('user/edit',['user'=>$user]);
    }

   
    public function update()
    {
         // 1. 获取要修改的用户的id
        $uid = $_GET['uid'];
        // 所有提交的要修改的数据，放在了$_POST全局变量中

        // var_dump($_POST);DIE;


        // 2. 执行修改操作
        // update shop_users set uname = $_POST['uname'],sex = $_POST['sex'],tel= $_POST['tel'],auth = $_POST['auth'] where uid = $_GET['uid']
        $auth = $_POST['auth'];

        if($auth == '1'){
            return $this->error('只能有一个店老板，你想干什么？？','/user/index');   
        }
        // 参数1：表示要修改的记录
        // 参数2 ： 要修改的记录的id
        // 参数3：表示只修改数据表中存在的字段，不存在的直接过滤掉
        try{
           Users::update($_POST,['uid'=>$uid],true); 

           // throw new Exception('修改用户失败啦');
       }catch(\Exception $e){
            return $this->error('用户修改失败','/user/edit?uid='.$uid);
       }

         return $this->success('用户修改成功','/user/index');   
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        //写删除的业务逻辑
        // 1. 获取要删除的记录的id
        $uid = $_GET['uid'];
        // 2. 执行删除操作
        $user = Users::get($uid);
        // $user->delete();
        $auth = $user->auth;
        //var_dump($auth);die;
        

        if($auth == '1'){
            return $this->error('该用户不能被删除','/user/index');
        }

        $res = Users::destroy($uid);
        // 3. 如果删除成功跳转到用户首页，失败也是跳转到用户首页，提示信息不一样
        if($res){
            return $this->success('用户删除成功','/user/index');
        }else{
             return $this->error('用户删除失败','/user/index');
        }
    }

    public function xiugaiye($id){
       
        $user = Users::get($id);
        
        //var_dump($user);die;
      // 2.返回修改页面，将当前记录绑定到页面上
         return view('user/xiugaiye',['user'=>$user]);
    }
    public function xiugai(){
        $uid = $_GET['uid'];
        try{
           Users::update($_POST,['uid'=>$uid],true); 
           // throw new Exception('修改用户失败啦');
       }catch(\Exception $e){
            return $this->error('用户修改失败','/user/edit?uid='.$uid);
       }

         return $this->success('密码已修改，请重新登录成功','/admin/logout');
    }
}
