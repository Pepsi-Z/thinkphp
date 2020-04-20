<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\common\model\Good;
use app\common\model\Cate;



class GoodController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {	
		
		
        // 先判断用户是否登录
        if(empty(session('adminFlag'))){
            return $this->error('先请登录，再访问');
        }

        // 先通过模型获取需要的数据，然后将数据绑定到对应的视图上
        $conditon = [];
        // 如果用户名不为空
        if(!empty($_GET['title'])){
            $conditon[] = ['title','like',"%{$_GET['title']}%"];
            $this->assign('title',$_GET['title']);
        }

        // 分页查询，每页2条 只查询满足条件的分页用户
        // appends()用于在点击前台模板中下一页或者上一页时，将查询条件带到后台
        $goods = Db::name('base_match')->where($conditon)->paginate(8)->appends($_GET);
//        dump($goods);die;
        //2.返回用户列表页
        // 如何将数据跟视图绑定

            // 参数1 ：需要返回的视图
            // 参数2 ：需要给视图绑定的数据，数组形式
            // ['在视图中表示通过模型获取到的数据users'=>上面获取到的数据]
            // 也就是说吧获取 到的数据，绑定到页面上，并给这个数据起个别名

        return view('good/index',['goods'=>$goods]);

    }
    

    /**
     * 商品的添加页面
     *
     * @return \think\Response
     */
    public function create()
    {
         $cates = Cate::order('concat(path,cid)')->select();

        return view('good/insert',['cates'=>$cates]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $req)
    {
        // $_FILES['gpic']
        // 1. 接收到表单提交过来的商品数据
        $data = $req->post();
        // var_dump($data);die;


        // 如何获取上传的商品图片？
        // 获取到表单中文件名为gpic对应的上传文件
        $file = $req->file('img');
        // var_dump($file);die;
        if(empty($file)){
            return $this->error('未上传图片');
        }
        // 移动上传文件到指定的目录public/static/uploads
        // 如何获取这个目录？
        // $file->move('要移动到的目录');
        $info = $file->move(config('app.save_path'));

        if($info){

            // 2018/06/25/ksdjkfjsdljfklsjdklf.jpg
            // 获取刚才上传的文件的保存目录及文件名
            // return $info->getSaveName();

            $data['img'] = $info->getSaveName();
            // $data['ctime'] = time();

        }else{
            // 上传文件失败
            return $info->getError();
        }
        $data['createtime'] = date('Y-m-d H:i:s', time());

        $res = Db::name('base_match')->insert($data);
        if ($res){
            return $this->success('赛事添加成功','/good/index');
        }else{
            return $this->error('赛事添加失败');
        }
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

        $good = Db::name('base_match')->find($id);
        // 2. 返回一个修改页面，将要修改的记录帮上
        return view('good/edit',['good'=>$good]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $req, $id)
    {
        //1.获取要修改的商品数据，
        $data = $req->post();

        // 获取上传图片
        $file = $req->file('img');

        // 可以用户这次修改图片也可能不修改
        if($file){
            // 将上传文件移动到指定的位置
            $info = $file->move(config('app.save_path'));
            // 说明这次修改了图片
            // 获取到上传图片的路径和名称
            $filename = $info->getSaveName();
            $data['img'] = $filename;
        }

        $res = Db::name('base_match')->where('id','=',$id)->update($data);
        if ($res){
            return $this->success('赛事信息修改成功','/good/index');
        }else{
            return $this->error('赛事信息修改失败','/good/index');
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete ($id) {

        $res = Db::name('base_match')->where('id','=',$id)->delete();
        if($res){
            return $this->success('删除成功','/good/index');
        }else{
            return $this->error('删除失败','/good/index');
        }
    }

    // 商品上架
    public function up($id){
        Good::update(['status'=>2],['gid'=>$id]);
        return $this -> success('商品上架成功');
    }
    public function down($id){
        Good::update(['status'=>3],['gid'=>$id]);
        return $this -> success('商品下架成功');
    }


}
