<?php
namespace app\admin\controller;

class Index
{
    public function index()
    {
    	// return '我是admin模块下的index控制器中的index方法的方法体';
    	// view()表示访问当前模块（admin）下的view目录
    	// 就可以返回view/common/default页面，不需要加后缀
      return view('common/default');
    }
}
