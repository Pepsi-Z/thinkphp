<?php

namespace app\home\controller;

use think\Controller;
use Think\Db;
use think\Request;
use app\common\model\Cate;
use app\common\model\Good;
class GoodController extends Controller
{
    // 商品列表页
    public function goodlist(Request $req,$id)
    {

        $condition = [];

        // 如果当期id对应的类是一级类，就需要获取到当前一级类下的二级类，查询二级类下所有的商品
        // 如果当前id对应的是二级类（终极类就是没有子类的类），直接获取到当前id下的商品

        // 获取一级类下的二级类
        // 如果一个分类的path字段中含,$id,这部分数据，那就可以认为当前分类属于$id对应分类的子类
        // column 获取指定名称的列值
        // 获取到$id对应的一级类下的所有的二级类的id的数组
        
        $cate_ids =  Cate::where('path','like',"%,$id,%")->column('cid');
        // 在把这个一级类加入到二级类的数组中
        // 得到一个包含一级类id的二级类id的数组
        array_unshift($cate_ids,$id);
        if($id){
             $condition[] = ['cate_id','in',$cate_ids];
        }
       
        // 如果是通过搜商品名称到的这个方法
        $gname = $req->get('gname');

        if($gname){
             $condition[] = ['gname','like','%'.$gname.'%'];
        }
        // $goods = Good::where('gname','like',$gname)->select();
        // 查询所有二级类下的商品
        // $goods = Good::where('cate_id','in',$cate_ids)->select();

        
        
        $goods = Good::where($condition)->select();

        foreach ($goods as $k => $v) {
            if ($v->status==3) {
               unset($goods[$k]); 
            }
        }
        foreach ($goods as $kk => $vv) {
                if ($vv->stock == 0) {
               unset($goods[$kk]); 
            }
        }
        $res = Good::where($condition)->order('salecnt desc')->limit('3')->select();

        return view('good/jd-glist',['goods'=>$goods,'res'=>$res]);
    }

    // 商品详情页
    public function gooddetail($id)
    {
        // 根据id，获取对应的商品
        $good = Good::find($id);
        return view('good/jd-detail',['good'=>$good]);
    }   
}   
