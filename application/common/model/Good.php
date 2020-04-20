<?php

namespace app\common\model;

use think\Model;

class Good extends Model
{
     protected $table = 'shop_goods';
     protected $pk    = 'gid';

     // 下面的代码就是为了在添加数据时，自动给ctime字段赋值的
     // 也可以注释掉，在save方法中生成添加时间数据
     protected $insert = ['ctime']; 
    public function setCtimeAttr(){
    	return time();
    }


    // 定义关联模型，通过商品模型找到分类模型
    public function cate()
    {
    	// return $this->belongsTo('要关联的模型','两个模型关联的外键','主模型的主键')
    	return $this->belongsTo('Cate','cate_id','cid');
    }

}
