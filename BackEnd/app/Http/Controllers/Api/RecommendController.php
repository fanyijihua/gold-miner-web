<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RecommendController extends Controller
{
    /**
     * 获取所有推荐文章记录（分页）
     * @return json_encode(Object) 全部推荐文章（分页）
     */
    public function index()
    {
        //
        $recommends = DB::table('recommend')
                        ->join('category', 'recommend.category', '=', 'category.id')
                        ->join('user', 'recommend.recommender', '=', 'user.id')
                        ->select('recommend.*', 'user.name as recommender', 'category.category')
                        ->orderBy('status', 'asc')
                        ->skip($this->start)
                        ->take($this->offset)
                        ->get();

        echo json_encode($recommends);
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
     * 添加推荐文章记录
     * @param  int      $category       文章分类（对应 category 表）
     * @param  string   $title          文章标题
     * @param  string   $url            文章来源地址
     * @param  int      $recommender    推荐者（对应 user 表）
     * @param  string   $description    推荐理由
     * @return json_encode(Array)
     */
    public function store(Request $request)
    {
        //
        $data = array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description'),
                'status'        => 0,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('recommend')
                        ->insert($data);

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '推荐文章失败！';
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
     * 更新推荐文章记录
     * @param  int      $category       文章分类（对应 category 表）
     * @param  string   $title          文章标题
     * @param  string   $url            文章来源地址
     * @param  int      $recommender    推荐者（对应 user 表）
     * @param  string   $description    推荐理由
     * @param  int      $id             文章 ID
     * @return json_encode(Array)
     */
    public function update(Request $request, $id)
    {
        //
        $status = DB::table('recommend')
                    ->where('id', $id)
                    ->value('status');

        if ($status != 0) {
            $this->ret['status'] = 403;
            $this->ret['message'] = '文章已被管理员处理，您没有权限！';
            echo json_encode($this->ret);
            return;
        }

        $data = array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s')
            );
        
        $result = DB::table('recommend')
                        ->where('id', $id)
                        ->update($data);

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '推荐文章失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 更新文章处理结果
     * @param  int      $id     文章 ID
     * @param  boolean  $result 推荐结果，true 为通过，false 为未通过
     * @return json_encode(Array)
     */
    public function result($id, $result = true)
    {
        $data = array(
                'status' = 1
            );

        if ($result == false) {
            $data['status'] = 2;
        }

        $result = DB::table('article')
                    ->where('id', $id)
                    ->update($data);

        if ( $result == false ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新推荐结果失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }

}
