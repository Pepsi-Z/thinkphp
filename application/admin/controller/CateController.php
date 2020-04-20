<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Cate;

class CateController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		
        //返回列表页

        // 获取分类数据
       $cates = Cate::order('concat(path,cid)')->paginate(10)->appends($_GET);
       // $data = Cate::order('concat(path,cid)')->select();
       // $data = Cate::query("select * from shop_cate order by concat(path,cid)");
       // var_dump($data);die;

        // 返回分类页面
        return view('cate/index',['cates'=>$cates]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($id)
    {
        // 如果此方法对应的路由由动态的部分，就需要在方法的参数中定义一个参数来匹配动态的那部分内容
        //获取所哟的分类数据
        // select * from shop_cate order by concat(path,cid);
        // select * from shop_cate;
        // 将path,cid两列合并后排序，这样排序后的顺序才是我们需要的
        $cates = Cate::order('concat(path,cid)')->select();

        return view('cate/insert',['cates'=>$cates,'cid'=>$id]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $req)
    {
        // 可以通过$_POST超全局变量来获取表单提交的数据
        // var_dump($_POST);
        // 还可以使用Request对象来获取用户提交的数据
        $data = $req->post();
        // var_dump($data);
        // 组装path字段
        // 如果是一级类  path = 0,

        // 如果不是一级类 path = 父类ID的path+'父类ID,'
        if($data['pid'] == '0'){
            $data['path'] = '0,';
        }else{
            // 当前要添加的分类的父分类
            $data['path']=Cate::get($data['pid'])->path.$data['pid'].',';
        }
        // $data['abc'] ='aaa';

        // 2. 保存到数据库
        try{
             Cate::create($data,true);
        }catch(\Exception $e){
            return $this->error('分类添加失败','/cate/create');
        }

        return $this->success('分类添加成功','/cate/index');
       

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
     * 显示返回修改页面
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取当前分类
        $cate = Cate::find($id);

        // 返回一个修改页面
        return view('cate/edit',['cate'=>$cate]);
    }

    /**
     * 保存更新的资源
     *
     * @param  Request $request  请求对象，所有跟请求相关的信息都在里面，我们只需要获取到用户提交的post
     * @param  int  $id  要修改的那个分类的id,  cate/update/:id
     * @return \think\Response
     */
    public function update(Request $req, $id)
    {
        // 获取到表单提交的post数据，里面有修改后的分类名称
        $data = $req->post();

        // $id 表示要修改的分类的id


        // 2. 执行修改操作
        // $data :要修改的数据
        // 参数2： 要修改的记录的id
        // 参数3： 过滤数据，只提交数据表中有字段的数据
        // update shop_cate set cname = $data['cname'] where cid = $id;

        try{
            Cate::update($data,['cid'=>$id],true);
        }catch(\Execption $e){
            return $this->error('分类修改失败',"/cate/{$id}/edit");
        }

        return $this->success('分类修改成功','/cate/index','',2);
        



        // 3。 判断修改是否成功
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //1. 获取要删除的分类的id

        // 不能删除有子类的分类？
        // 如果一个分类的cid没有在pid这一列出现过，就说明没有任何一个类以当前这个类为父类，也就是说，这个类没有子类

        $cate = Cate::where('pid','=',$id)->find();
        if($cate){
            // 说明当前类有子类
            return $this->error('当前类有子类，不能删除','/cate/index');
        }


        // 2. 执行删除操作
        $res = Cate::destroy($id);

        // 3. 判断删除是否成功
        if($res){
            return $this->success('分类删除成功','/cate/index');
        }else{
             return $this->error('分类删除失败','/cate/index');
        }
    }
}
