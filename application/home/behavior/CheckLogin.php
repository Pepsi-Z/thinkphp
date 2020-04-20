<?php
namespace app\home\behavior;


class CheckLogin 
{
	use \traits\controller\Jump;
	public function run()
	{
		//要执行的业务逻辑，判断用户是否登录 
		if(empty(session('homeFlag'))){
			// 如果用户是通过结算按钮过来的，使用back做一个标记
			session('back','/order/info');
            return $this->error('先请登录，再访问','/login');
        }
	}
}