<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    protected $notifications = array();
    
    /**
     * 获取所有通知
     *
     * @return void
     * @author Romeo
     */
    public function index()
    {
        $applicants = DB::table('applicant')
                        ->leftjoin('user', 'user.id', '=', 'applicant.uid')
                        ->where('applicant.status', 0)
                        ->select('applicant.id', 'applicant.name', 'applicant.cdate', 'user.name as userName', 'user.avatar as avatar')
                        ->orderBy('applicant.id', 'ASC')
                        ->get();

        $recommends = DB::table('recommend')
                        ->join('user', 'recommend.recommender', '=', 'user.id')
                        ->where('recommend.status', 0)
                        ->select('recommend.id', 'recommend.title', 'recommend.cdate', 'user.name', 'user.avatar')
                        ->orderBy('recommend.id', 'ASC')
                        ->get();

        $this->notifications['applicants'] = $applicants;
        $this->notifications['recommends'] = $recommends;
        $this->notifications['total'] = count($applicants) + count($recommends);

        return json_encode($this->notifications);
    }
}
