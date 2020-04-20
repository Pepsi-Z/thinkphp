<?php

namespace app\common\model;

use think\Model;

class Addr extends Model
{
    //
    protected $table = 'user_addr';
    protected $pk = 'aid';

    function User(){
    	return $this -> belongsTo('User','user_id','uid');
    }
}
