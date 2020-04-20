<?php
namespace app\admin\behavior;


class CheckLogin 
{
	use \traits\controller\Jump;
	public function run()
	{
		//要执行的业务逻辑，判断用户是否登录 
		if(empty(session('adminFlag'))){
            return $this->error('先请登录，再访问','admin/login');
        }
	}
}