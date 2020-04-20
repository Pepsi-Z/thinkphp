<?php

namespace app\common\model;

use think\Model;

class Cate extends Model
{
    //当前模型要关联的表
    protected $table = 'shop_cate';
    // 表的主键
    protected $pk = 'cid';

    //定义一个方法，关联Good模型
    public function good()
    {
    	// 如果模型关系是一对多，主模型中需要使用hasMany方法
    	// return $this->hasMany(要关联的模型，两个模型关联的外键，主模型的主键)
    	return $this->hasMany('Good','cate_id','cid');
    }


    // 获取无限极分类的方法
    public static function getTreeCates($cates=[],$pid=0)
    {
        // 获取所有的分类
        if(empty($cates)){
            $cates = self::select();
        }

        // 对分类进行递归遍历，获取到排好序的分类数据（）
        // 第一个一级类
        //     当前一级类下的二级类
        // 第二个一级类
        //     当前一级类下的二级类

        $tmp=[];
        //遍历所有的分类，获取一级分类，pid=0
        foreach($cates as $k=>$v){
            // 满足一级类的条件
            if($v->pid == $pid){
                // $v->sub = 当前类的二级类 ,当前类是家用电器 cid =1
                $v->sub = self::getTreeCates($cates,$v->cid);

                // 将一级类放入$tmp数组
                $tmp[$v->cid] = $v;
            }
        }

        return $tmp;

    }
}
