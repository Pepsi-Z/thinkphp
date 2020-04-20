<?php

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\common\model\Cate;
use app\common\model\Good;


class IndexController extends Controller
{
    /**
     * 返回前台首页
     *
     * @return \think\Response
     */
    public function index()
    {
        //现获取到一级分类数据
        // 如果是首页，就需要显示
//        $data =Db::table('shop_goods')->order('salecnt desc')->limit(1)->select();
        $data =Good::order('salecnt desc')->limit('4')->select();
//        dump($data);die;
        return view('index/index',['data'=>$data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
