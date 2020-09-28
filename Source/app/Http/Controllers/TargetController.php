<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Storage;
use League\Csv\Reader;

class TargetController extends Controller
{
    protected $mdlTarget;
    protected $mdlUsers;

    public function __construct() {
        $this->mdlTarget = new targetsModels ();
    }

    public function index(Request $request) {
        $order = $request->get ( 'order' );
        $dir = $request->get ( 'dir' );
        $pageAppends = array ();
        $listOrder = array ();

        if ($order && $dir) {
            $pageAppends = [
                    'order' => $order,
                    'dir' => $dir
            ];
            $listOrder = array (
                    $order => $dir
            );
        } else {
            $listOrder = array (
                    'id' => 'desc'
            );
        }

        $getListAlls = $this->mdlTarget->getListAll ( 'line', $listOrder );

        $data ['Lists'] = $getListAlls;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['page_appends'] = $pageAppends;
        $data ['allItemCount'] = count ( $getListAlls );

        return view ( 'target.index', $data );
    }

    public function create(Request $request) {
        return view ( 'target.create' );
    }

    public function resist(Request $request) {
        $arrErrors = array ();
        $this->mdlUsers = new UsersModels ();

        // バリデーションルール
        $rules = [
                'csvFile' => 'max:10240',
                'listname' => 'required|min:1|max:128',
                'parameters' => 'required|boolean',
                'status' => 'required|boolean'
        ];
        $validation = Validator::make ( $request->all (), $rules );

        if ($validation->fails ()) {
            $arrErrors ['systemCode'] = 400;
            $arrErrors ['errorMeg'] = $validation->errors ()->all ();

            // $request->flash();
            // return view('admin.create',$arrErrors);
            return redirect ()->back ()
                ->withErrors ( $validation->errors () )
                ->withInput ()
                ->with ( 'systemCode', 400 );
        }

        // 配信リスト情報をDBに登録
        $arrValues = array (
                'name' => $request->listname,
                'parameters' => $request->parameters,
                'notes' => $request->notes,
                'status' => $request->status
        );
        if ($request->id == "") {
            $getTargetId = $this->mdlTarget->resist ( 'line', $arrValues );
        }else {
            $getTargetId = $this->mdlTarget->setUpdate ( $request->id, $arrValues );
            $getTargetId = $request->id;
            $this->mdlTarget->deleteDetails ( $request->id );
        }
        // ファイルの保存
        if (! $request->csvFile){
            $file = false;
            $fileName = false;
        }else{
            $file = Input::file ( 'csvFile' );
            $fileName = \Auth::user ()->id . "_targets_" . date ( "YmdHis" ) . ".csv";

            // Storageに移動
            rename ( $file->getRealPath (), storage_path ( 'app/line/targets/' ) . $fileName );
            $csvFilePath = storage_path ( 'app/line/targets/' ) . $fileName;



            $reader = Reader::createFromPath ( $csvFilePath );
            $results = $reader->fetch ();

            unset ( $arrValues );
            // 配信リスト情報詳細
            foreach ( $results as $row ) {
                $lid = $row [0];
                array_shift ( $row );
                $params = implode ( ",", $row );
                if ($request->parameters == 1) {
                    $arrValues = array (
                            'target_id' => $getTargetId,
                            'uid' => $this->mdlUsers->getLid2UserID ( 'line', $lid ),
                            'lid' => $lid,
                            'params' => $params
                    );
                } else {
                    $arrValues = array (
                            'target_id' => $getTargetId,
                            'uid' => $this->mdlUsers->getLid2UserID ( 'line', $lid ),
                            'lid' => $lid,
                            'params' => ''
                    );
                }
                $this->mdlTarget->resistDetails ( 'line', $arrValues );
            }
        }
        return redirect ( 'target' );
    }

    public function edit($id) {

        $arrValue = array ();
        $arrValue ['systemCode'] = '';

        $arrValue ['listInfo'] = $this->mdlTarget->getOne ( 'line', $id );
        $arrValue ['targetList'] = $this->mdlTarget->getTargetDetailList ( $id );

        return view ( 'target.edit', $arrValue );
    }
}
