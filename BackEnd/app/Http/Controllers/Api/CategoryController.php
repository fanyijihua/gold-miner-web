<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * 获取所有文章类别
     * @return void
     */
    public function index()
    {
        $category = DB::table('category')
                    ->select('id', 'category', 'description')
                    ->get();

        return json_encode($category);
    }

    /**
     * 添加文章类别
     * @param  string   $category       分类名称
     * @param  string   $description    分类描述
     * @return void
     */
    public function store(Request $request)
    {
        $this->isNotNull(array(
                'category' => $request->input('category')
            ));
        $this->isUnique('category', array(
                'category' => $request->input('category')
            ));
        $data = array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $lastId = DB::table('category')
                    ->insertGetId($data);

        if ( $lastId === false || $lastId === null ) {
            return response("Service unavailable", 503);
        }

        return $this->show($lastId);
    }

    /**
     * 获取指定文章
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        $category = DB::table('category')
                    ->where('id', $id)
                    ->select('id', 'category', 'description')
                    ->first();

        if ( $category === null ) {
            return response()
                    ->json(['message' => '参数错误！'], 400);
        }

        return json_encode($category);
    }

    /**
     * 更新文章类别
     * @param  string   $category       分类名称
     * @param  string   $description    分类描述
     * @param  int      $id             分类 ID
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->isNotNull(array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description')
            ));
        $this->isUpdateConflict('category', $id, array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description')
            ));
        $data = array(
                'category'      => $request->input('category'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('category')
                    ->where('id', $id)
                    ->update($data);

        if ( $result === false ) {
            return response("Service unavailable", 503);
        }

        return $this->show($id);
    }

    /**
     * 删除文章类别（不可恢复）
     * @param  int      $id             分类 ID
     * @return void
     */
    public function destroy($id)
    {
        $result = DB::table('category')
                    ->where('id', $id)
                    ->delete();

        if ( $result === false ) {
            return response("Service unavailable", 503);
        }
    }
}
