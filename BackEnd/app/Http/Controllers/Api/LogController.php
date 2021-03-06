<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    /**
     * 插入一条时间线索
     * @param $data
     * @return mixed
     */
    public static function writeTimeline($data)
    {
        return DB::table('timeline')->insert($data);
    }

    /**
     * 读取指定文章的时间线索
     * @param $id
     * @return mixed
     */
    public static function readTimeline($id)
    {
    	return DB::table('timeline')
    			->leftJoin('user', 'timeline.uid', '=', 'user.id')
    			->select('timeline.operation', 'timeline.cdate', 'user.id as userId', 'user.name', 'user.avatar')
    			->where('timeline.tid', $id)
    			->get();
    }

    /**
     * 查找指定用户的操作记录
     *
     * @param   int       $userId
     * @param   string    $operation
     * @param   int       $status
     * @return  void
     * @author  Romeo
     */
    public static function checkTimeline($userId, $operation, $status)
    {
        return DB::table('timeline')
                ->join('translation', 'translation.id', '=', 'timeline.tid')
                ->where('timeline.uid', $userId)
                ->where('timeline.operation', $operation)
                ->where('translation.status', $status)
                ->first();
    }
}
