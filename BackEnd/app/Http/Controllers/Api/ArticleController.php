<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * 获取全部试译文章
     * @return void
     */
    public function index()
    {
        $articles = DB::table('article')
                        ->join('user', 'article.operator', '=', 'user.id')
                        ->where('article.isdel', 0)
                        ->select('article.*', 'user.name as operator')
                        ->orderBy('article.id', 'desc')
                        ->skip($this->start)
                        ->take($this->offset)
                        ->get();
                        
        return json_encode($articles);
    }

    /**
     * 添加试译文章
     * @param  string   $title      文章标题
     * @param  int      $category   文章分类（对应 category 表）
     * @param  string   $url        文章来源地址
     * @param  int      $operator   操作者（对应 user 表）
     * @param  string   $content    文章内容
     * @return void
     */
    public function store(Request $request)
    {
        $this->isNotNull(array(
                'title'     => $request->input('title'),
                'category'  => $request->input('category'),
                'operator'  => $request->input('operator'),
                'content'   => $request->input('content')
            ));
        $this->isUnique('article', array(
                'title' => $request->input('title')
            ));
        $data = array(
                'title'     => $request->input('title'),
                'category'  => $request->input('category'),
                'url'       => $request->input('url'),
                'status'    => 1,
                'isdel'     => 0,
                'passed'    => 0,
                'failed'    => 0,
                'operator'  => $request->input('operator'),
                'content'   => $request->input('content'),
                'udate'     => date('Y-m-d H:i:s'),
                'cdate'     => date('Y-m-d H:i:s')
            );

        $lastId = DB::table('article')
                    ->insertGetId($data);

        if ( $lastId === false ) {
            return response("Service unavailable", 503);
        }

        return $this->show($lastId);
    }

    /**
     * 获取单个文章详细信息
     * @param  int  $id     文章 ID
     * @return void
     */
    public function show($id)
    {
        $article = DB::table('article')
                        ->join('user', 'article.operator', '=', 'user.id')
                        ->select('article.*', 'user.name as operator')
                        ->where('article.id', $id)
                        ->first();

        if ( $article === null ) {
            return response()
                    ->json(['message' => '参数错误！'], 400);
        }
                        
        return json_encode($article);
    }

    /**
     * 更新文章信息
     * @param  int      $request    文章分类（对应 category 表）
     * @param  int      $request    操作者（对应 user 表）
     * @param  string   $request    文章内容
     * @param  int      $id         文章 ID
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->isNotNull(array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'operator'      => $request->input('operator'),
                'content'       => $request->input('content')
            ));
        $this->isUpdateConflict('article', $id, array(
                'title' => $request->input('title')
            ));
        $data = array(
                'category'  => $request->input('category'),
                'title'     => $request->input('title'),
                'url'       => $request->input('url'),
                'operator'  => $request->input('operator'),
                'content'   => $request->input('content'),
                'udate'     => date('Y-m-d H:i:s')
            );

        $result = DB::table('article')
                    ->where('id', $id)
                    ->update($data);

        if ( $result === false ) {
            return response("Service unavailable", 503);
        }

        return $this->show($id);
    }

    /**
     * 删除文章（状态标记）
     * @param  int  $id     文章 ID
     * @return void
     */
    public function destroy($id)
    {
        $result = DB::table('article')
                    ->where('id', $id)
                    ->update(['isdel' => 1]);

        if ( $result === false ) {
            return response("Service unavailable", 503);
        }
    }

    /**
     * 更新文章状态信息（启用/禁用）
     * @param  int  $id     文章 ID
     * @return void
     */
    public function toggleStatus($id)
    {
        $currentStatus = DB::table('article')
                    ->where('id', $id)
                    ->value('status');

        if ( $currentStatus === null ) {
            return response()
                    ->json(['message' => '参数错误！'], 400);
        }

        $result = DB::table('article')
                    ->where('id', $id)
                    ->update(['status' => !$currentStatus]);

        if ( $result === false ) {
            return response("Service unavailable", 503);
        }
    }

    /**
     * 更新文章试译结果（通过/失败）
     * @param  int      $id         文章 ID
     * @param  boolean  $result     试译结果，true 为通过，false 为失败
     * @return void
     */
    public static function recordResult($id, $result = true)
    {
        if ( $result == true ) {
            $field = 'passed';
        } else {
            $field = 'failed';
        }

        $result = DB::table('article')
                    ->where('id', $id)
                    ->increment($field);
    }

    /**
     * 随机获取指定分类的某篇文章
     * @param  int      $id   文章分类 ID（对应 category 表）
     * @return void
     */
    public function getRandomArticle($id)
    {
        $rules = array(
                'category'  => $id,
                'isdel'     => 0,
                'status'    => 1
            );

        $article = DB::table('article')
                        ->where($rules)
                        ->select('id', 'title', 'url', 'content')
                        ->inRandomOrder()
                        ->first();

        if ( $article === null ) {
            return response()
                    ->json(['message' => '本分类下暂无试译文章！'], 400);
        }
                        
        return json_encode($article);
    }
}
