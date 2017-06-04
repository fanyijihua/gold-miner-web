<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    /**
     * 获取全部申请者信息
     * @return json_encode(Object)  全部申请者（分页）
     */
    public function index()
    {
        //
        $applicants = DB::table('applicant')
                        ->join('category', 'applicant.major', '=', 'category.id')
                        ->join('article', 'applicant.articleid', '=', 'article.id')
                        ->select('applicant.id', 'applicant.name', 'applicant.email', 'applicant.status', 'applicant.description', 'applicant.translation', 'applicant.udate', 'applicant.cdate', 'category.category', 'article.content')
                        ->orderBy('status', 'asc')
                        ->skip($this->start)
                        ->take($this->offset)
                        ->get();

        echo json_encode($applicants);
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
     * 添加申请者
     * @param  int      $uid            用户 ID（对应 user 表，如果有的话）
     * @param  string   $name           昵称
     * @param  string   $email          邮箱
     * @param  int      $major          擅长领域
     * @param  string   $description    自我描述
     * @param  string   $translation    试译内容
     * @param  int      $articleId      试译文章 ID
     * @return json_encode(Array)        
     */
    public function store(Request $request)
    {
        //
        $data = array(
                'uid'           => $request->input('uid'),
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'major'         => $request->input('major'),
                'description'   => $request->input('description'),
                'translation'   => $request->input('translation'),
                'articleid'     => $request->input('articleId'),
                'status'        => 0,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('applicant')
                        ->insert($data);

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '申请失败！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($this->ret);
    }

    /**
     * 获取单个试译者详细信息
     * @param  int  $id     试译者 ID
     * @return json_encode(Object)     
     */
    public function show($id)
    {
        //
        $applicant = DB::table('applicant')
                        ->join('category', 'applicant.major', '=', 'category.id')
                        ->join('article', 'applicant.articleid', '=', 'article.id')
                        ->where('applicant.id', $id)
                        ->select('applicant.id', 'applicant.name', 'applicant.email', 'applicant.status', 'applicant.description', 'applicant.translation', 'applicant.udate', 'applicant.cdate', 'category.category', 'article.content')
                        ->first();

        if ( $applicant === null ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '非法参数！';
            echo json_encode($this->ret);
            return;
        }

        echo json_encode($applicant);
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
     * 更新申请结果
     * @param  bool     $result     申请结果，true 为成功，false 为失败
     * @param  int      $id         申请记录的 ID
     * @return json_encode(Array)           
     */
    public function update(Request $request, $id)
    {
        //
        $data = array( 'udate' => date('Y-m-d H:i:s') );
        if ( $request->input('result') == true ) {
            $data['invitation'] = $this->generationToken($id);
            $data['status'] = 1;
        } else {
            $data['status'] = 2;
        }

        $result = DB::table('applicant')
                    ->where('id', $id)
                    ->update($data);

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新信息失败！';
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
     * 检查邮箱是否被占用
     * @param  string   $email  邮箱
     * @return json_encode(Array)
     */
    public function checkEmail( $email )
    {
        if ( false == preg_match('/(.*?)@(.*?)\.(.*?)/', $email) ) {
            $this->ret['status'] = 500;
            $this->ret['message'] = '邮箱格式错误！';
            echo json_encode($this->ret);
            return;
        }

        $result = DB::table('applicant')
                    ->where('email', $email)
                    ->first();

        if ( $result == false ) {
            echo json_encode($this->ret);
            return;
        }

        $this->ret['status'] = 500;
        $this->ret['message'] = '邮箱已被占用！';
        echo json_encode($this->ret);
    }
}
