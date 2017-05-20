<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = array(
                'email'         => $request->input('email'),
                'major'         => $request->input('major'),
                'description'   => $request->input('description'),
                'translation'   => $request->input('translation'),
                'articleid'     => $this->getArticle(),
                'result'        => 0,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('applicant')
                        ->insert($data);

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '申请失败！';
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = array(
                'invitation'    => $this->generationToken($id),
                'udate'         => date('Y-m-d H:i:s')
            );

        $result = DB::table('applicant')
                    ->where('id', $id)
                    ->update($data);

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新信息失败！';
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

    public function getArticle()
    {
        // $article = DB::table('article')
        //                 ->inRandomOrder()
        //                 ->first();
        // return $article->id;
        return rand(1,100);
    }

    public function checkEmail()
    {
        // $email = 
    }
}
