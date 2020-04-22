<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Request;
use app\common\model\Cate;
use think\Response;

class CateController extends Controller {
    /**
     * 显示资源列表
     *
     * @return Response
     * @throws DbException
     */
    public function index() {

        $cates = Db::name('base_gonggao')->paginate(10)->appends($_GET);
        // 返回分类页面
        return view('cate/index', ['cates' => $cates]);
    }

    /**
     * 显示创建资源表单页.
     * @return Response
     */
    public function create() {
        return view('cate/insert');
    }

    /**
     * 保存新建的资源
     *
     * @param Request $req
     * @return void
     */
    public function save(Request $req) {
        $data = $req->post();
        $data['time'] = date('Y-m-d H:i:s', time());
        $res = Db::name('base_gonggao')->insert($data);
        if ($res) {
            return $this->success('添加成功', '/cate/index');
        } else {
            return $this->error('添加失败', '/cate/create');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return void
     */
    public function read($id) {
        //
    }

    /**
     * 显示返回修改页面
     *
     * @param int $id
     * @return Response
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function edit($id) {
        $cate = Db::name('base_gonggao')->where('id','=',$id)->find();
        // 返回一个修改页面
        return view('cate/edit', ['cate' => $cate]);
    }

    /**
     * 保存更新的资源
     *
     * @param Request $req
     * @param int $id 要修改的那个分类的id,  cate/update/:id
     * @return void
     * @throws Exception
     * @throws PDOException
     */
    public function update(Request $req, $id) {
        // 获取到表单提交的post数据，里面有修改后的分类名称
        $data = $req->post();
        $res = Db::name('base_gonggao')->where('id','=',$id)->update($data);
        if($res){
            return $this->success('分类修改成功', '/cate/index');
        }else{
            return $this->error('分类修改失败', "/cate/index");
        }
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return void
     * @throws DbException
     * @throws Exception
     */
    public function delete($id) {

        $res = Db::name('base_gonggao')->where('id','=',$id)->delete();
        if ($res) {
            return $this->success('删除成功', '/cate/index');
        } else {
            return $this->error('删除失败', '/cate/index');
        }
    }
}
