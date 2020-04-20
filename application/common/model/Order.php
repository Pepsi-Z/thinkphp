<?php

namespace app\common\model;

use think\Model;

class Order extends Model
{
	// 模型关联的表名
    protected $table = 'shop_orders';
    // 主键
    protected $pk = 'oid';

    //定义一个方法，关联Detail模型
    public function detail()
    {
    	// 如果模型关系是一对多，主模型中需要使用hasMany方法
    	// return $this->hasMany(要关联的模型，两个模型关联的外键，主模型的主键)
    	return $this->hasMany('Detail','orders_oid','oid');
    }


    // 关联用户模型  user是主模型
    public function user()
    {
        return $this->belongsTo('Users','user_uid','uid');
    }



}
