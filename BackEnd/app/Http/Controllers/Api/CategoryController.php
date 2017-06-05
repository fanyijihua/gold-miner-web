<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * 获取所有文章类别
     * @return json_encode(Array)
     */
    public function index()
    {
        //
        $category = DB::table('category')
                    ->select('id', 'category', 'description')
                    ->get();

        echo json_encode($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 添加文章类别
     * @param  string   $category       分类名称
     * @param  string   $description    分类描述
     * @return json_encode(Array)
     */
    public function store(Request $request)
    {
        //
        $data = array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('category')
                    ->insert($data);

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '添加类别失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 更新文章类别
     * @param  string   $category       分类名称
     * @param  string   $description    分类描述
     * @param  int      $id             分类 ID
     * @return json_encode(Array)
     */
    public function update(Request $request, $id)
    {
        //
        $data = array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('category')
                    ->where('id', $id)
                    ->update($data);

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新类别失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }

    /**
     * 删除文章类别（不可恢复）
     * @param  int      $id             分类 ID
     * @return json_encode(Array)
     */
    public function destroy($id)
    {
        //
        $result = DB::table('category')
                    ->where('id', $id)
                    ->delete();

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '删除类别失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }
}
