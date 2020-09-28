<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use DB;
use App\Utils\Common;
use App\Http\Controllers\Controller;
use Session;
use App;
use App\User;
use Validator;
use DateTime;
use App\Utils\Helper;
use Illuminate\Support\Facades\Log;
use Lang;
use Input;
use Hash;
use App\Models\TargetsModels;
use App\Models\UsersModels;
use App\Models\EventModels;
use Storage;
use League\Csv\Reader;

class EventController extends Controller
{
    protected $mdlTarget;
    protected $mdlUsers;
    protected $mdlEvent;

    public function __construct() {
        $this->mdlTarget = new targetsModels ();
        $this->mdlEvent = new EventModels ();
    }

    /**
     * 登録情報一覧
     */
    public function index(Request $request) {

        $order = $request->get ( 'order' );
        $dir = $request->get ( 'dir' );
        $pageAppends = array ();
        $listOrder = array ();

        if ($order && $dir) {
            $pageAppends = array (
                    'order' => $order,
                    'dir' => $dir
            );
            $listOrder = array (
                    $order => $dir
            );
        } else {
            $listOrder = array (
                    'id' => 'desc'
            );
        }

        $getListAlls = $this->mdlEvent->getListAll ( 'line', $listOrder );

        $data ['Lists'] = $getListAlls;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['page_appends'] = $pageAppends;
        $data ['allItemCount'] = count ( $getListAlls );

        return view ( 'event.index', $data );
    }

    /**
     * 新規作成
     */
    public function create(Request $request) {
        $getTargetListAlls = $this->mdlTarget->getListAll ( 'line', array (
                'id' => 'desc'
        ) );
        $data ['Lists'] = $getTargetListAlls;

        return view ( 'event.create', $data );
    }

    /**
     * 登録
     */
    public function resist(Request $request) {
        list($event_start, $event_end) = explode(" to ", $request->start_date);
        $arrValues = array (
                'app_type' => 'line',
                'event_name' => $request->eventName,
                'event_date' => $request->event_date,
                'event_place' => $request->event_place,
                'event_start' => $event_start . ' 00:00:00',
                'event_end' => $event_end . ' 00:00:00',
                'target_id' => $request->target,
                'status' => $request->status
        );
//         dd($arrValues);
        if (isset ( $request->id )) {
            $this->mdlEvent->renewal ($request->id, $arrValues );
        } else {
            $this->mdlEvent->resist ( $arrValues );
        }




        return redirect ( 'event' );
    }

    /**
     * 編集
     */
    public function edit($id) {
        $data = array ();
        $getTargetListAlls = $this->mdlTarget->getListAll ( 'line', array (
                'id' => 'desc'
        ) );
        $data ['Lists'] = $getTargetListAlls;
        $data ['systemCode'] = '';
        $data ['eventInfo'] = $this->mdlEvent->getOne ( 'line', $id );

        return view ( 'event.edit', $data );

    }

}
