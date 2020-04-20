<?php

namespace app\common\model;

use think\Model;

class Detail extends Model
{
    // 模型关联的表名
    protected $table = 'shop_details';
    // 主键
    protected $pk = 'did';


     // 定义关联模型，通过订单详情模型找到订单模型
    public function order()
    {
    	// return $this->belongsTo('要关联的模型','两个模型关联的外键','主模型的主键')
    	return $this->belongsTo('Order','orders_oid','oid');
    }


    // 事件模型
    public static function init()
    {

        // self::event('事件',执行的操作)
        // $detail形参表示当天生成的那个订单详情记录
        self::event('after_insert', function ($detail) {
            // 找到下单的商品，修改商品的库存量= 库存量-购买数量
            // Good::find(商品id$detail->gid)->setDec('stock',购买量$detail->cnt)

            Good::find($detail->gid)->setDec('stock',$detail->cnt);
        });
    }

    // 关联商品模型  订单详情模型和good模型的关系，因为外键在订单详情中，所以good是主模型
    public function good()
    {
        return $this->belongsTo('Good','gid','gid');
    }
}
