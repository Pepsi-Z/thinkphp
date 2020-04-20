<?php

namespace app\common\model;

use think\Model;
//跟用户表关联的用户模型，后期通过这个类，就可以对用户表任意操作
class Users extends Model
{
    //当前模型要关联的表名
    protected $table = 'base_user';

    // 当前模型对应表的主键
    protected $pk    = 'uid';

    protected $insert = ['create_at'];

    // 在模型中就可以对密码进行MD5加密
    public function setUpwdAttr($value)
    {
    	return md5($value);
    }

    // 在模型中添加一个字段的值（注册时间字段）
    public function setCreateAtAttr($value)
    {
    	return time();
    }

    public function Addr()
    {
         return $this -> hasMany('Addr','user_id','uid');
    }
    public function order(){
        return $this ->hasmany('Order','user_uid','uid');
    }

}
