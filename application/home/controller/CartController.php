<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\Cate;
use app\common\model\Good;
use app\common\model\User;
use app\common\model\Addr;
use app\common\model\Order;
use app\common\model\Detail;

class CartController extends Controller
{
//    一. 添加到购物车
    public function addCart(Request $req)
    {
        // 获取要购买的商品的id
        $gid = $req->post('gid');
        // 获取要购买的商品的信息
        $good = Good::find($gid);
        // 获取要购买的商品的数量
        $cnt = $req->post('cnt');
        //判断商品数量是否足够
        $stock = Good::get($gid)->stock;
        
        if ($cnt>$stock) {
            return $this -> error('商品数量不足'.$cnt.'请重新填写数量!','/gooddetail/'.$gid);
        }
        
        // $stock = $req->post('stock');
        // var_dump($stock);die;   

        // 将要购买的商品的数量加入到要购买的商品的信息中
        $good->cnt = $cnt;



        // 因为要购买的商品需要持续化存储，可以在各页面之间获取到购物车的商品，我们使用session
        // session('健','值')
        // // 存入
        // session('uname','张三');
        // // 取出
        // session('uname')

        // 二维数组的处理方法
        // session('user.name','张三');
        // session('user.age',18);
        // session('user.sex','男');

        // session('user.sex'); 男
        // session('user.name'); 张三
        // $gid表示当前保存的商品的ID
        // session("cart.$gid",$good);cart二维数组，数组中每个元素都是一个商品对象
       // cart ==> 【
       //          3=>[
       //              gid=>3,
       //              gname=>小米电视
       //              price=>2000
       //          ],
       //          4=>[
       //              gid=>4,
       //              gname=>华为手机
       //              price=>1000
       //          ],
       //          6=>[
       //              gid=>6,
       //              gname=>苹果手机
       //              price=>1000
       //          ],
       //     】

        // 将要添加到购物车中的商品保存到session中，为了防止覆盖，我们使用的是一个二维的数组
        // $good是一个一维数组，存放的是一个要购买的商品的信息
        session("cart.$gid",$good);

        // session('cart.3')//找到gid=3的那个商品
        // var_dump(session('cart'));die;

        // var_dump($good);die;
        return view('cart/jd-precart',['good'=>$good]);
    }

// 二. 购物车列表
    public function listCart()
    {
   
        // 1. 获取要购买的商品
        // session('cart')

        // 2计算购物车列表中的总数量和总金额
        // 总金额
         $total = 0;
         // 总数量
         $num = 0;
        // session('cart')是一个二维数组，里面放的是所有要购买的商品的信息（包括购买数量）
        if(empty(session('cart'))){
          return $this -> error('购物车啥都没得啊！','/');
        }
          foreach (session('cart') as $k => $v) {
           $num += $v->cnt;
           $total += $v->cnt * $v->price;
           $stock = $v->stock;
           $gid = $v->gid;
           // var_dump($stock);die;
           if($num > $stock){
             return $this -> error('商品数量不足'.$num.'请重新填写数量!','/gooddetail/'.$gid);
           }
         }


         // 将总数字和总金额写入session中
         session('orders.total',$total);
         session('orders.cnt',$num);

        // 3. 返回购物车列表（显示要购买的商品的信息）
         return view('cart/jd-mycart',['num'=>$num,'total'=>$total]);
       
    }


// 三. 购物车中商品数量+1

      public function incr($id)
      {
     
       
        // return $id;
        // 先从购物车中找到要修改购买数量的那个商品，将这个商品的cnt字段的值+1
       // cart中存放的是对象数组，数组中的每个元素都是一个商品对象，这样购物车中就可以存放很多商品了
        session("cart.$id")->cnt++;
        
        
        
        // 2. 跳转到指定的路由
        return redirect('/cart/list');


      }

// 四. 购物车中商品数量-1

      public function desc($id)
      {
        // 如果要购买的商品的数量小于1，将数量固定为1
        if(session("cart.$id")->cnt <= 1){
          session("cart.$id")->cnt =1;
        
        }else{
          session("cart.$id")->cnt--;
        }

        // 2. 跳转到指定的路由
        return redirect('/cart/list');
      }



// 五. 删除购物车
      public function delete($id)
      {
        // 清空购物车中指定id的商品信息
        session("cart.$id",null);
            // 2. 跳转到指定的路由
        return redirect('/cart/list');
      }
    


}
