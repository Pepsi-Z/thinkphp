<?php


namespace app\home\controller;


use think\Controller;
use think\Request;
use app\common\model\Users;

class RegController extends Controller
{
    public function reg(){ 
        return view('reg/zhuce');
    }


     public function save(Request $request)
    {
        // var_dump($_POST);die;
        $data = $_POST;
        
         if(empty($_POST['upwd']) || empty($_POST['reupwd'])){
            //遇到错误，返回到原来的添加页面
            return $this->error('密码不能为空','/reg');
        }
        // 2.1 密码跟确认密码是佛一致
        if($_POST['upwd'] !== $_POST['reupwd']){
            return $this->error('密码跟确认密码必须一致','/reg');
        }
        $users = Users::select();
        foreach($users as $k=>$v){
            if(($_POST['uname']) == ($v->uname)){
                return $this->error('这个用户名已存在，请更换一个用户名吧');
            }
        }
         // 3. 向数据库的users表，执行添加操作
         // 引入的方法时：找到当前类Users所在的命名空间，在当前控制器中use一下，记得加上类名
          // $user = new Users;
        // $res = $user->save($data);
        // 添加用户的第二种方法，推荐
         // 参数2：如果是true，会自动的对表单提交过来的数据进行过滤，只保留表中存在的字段的数据
        $res = Users::create($data,true);
        // 表示添加成功
        if($res){
            return $this->success('注册用户成功','/login');
        }else{
            // 注册失败
            return $this->error('注册用户失败','/zhuce');
        }
	}
  


}