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
use App\Models\AdminModels;

class AdminController extends Controller
{


    public function __construct() {
        $this->mdlAdmin = new AdminModels ();
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

        $getListAlls = $this->mdlAdmin->getListAll ( 'line', $listOrder );

        $data ['Lists'] = $getListAlls;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['page_appends'] = $pageAppends;
        $data ['allItemCount'] = count ( $getListAlls );

        return view ( 'admin.index', $data );
    }


    public function create(Request $request) {
        $data ['systemCode'] = 0;
        return view ( 'admin.create', $data );
    }


    public function resist(Request $request) {
        $arrErrors = array ();
        // バリデーションルール
        // 更新の場合
        if (isset ( $request->id )) {
            $rules = [
                    'name' => 'required|min:1|max:128',
                    'password' => 'required|min:8|max:32',
                    'email' => 'required|email',
                    'lid' => 'alpha_num|min:1|max:40',
                    'locale' => 'required',
                    'authority' => 'required',
                    'status' => 'required'
            ];
        } else {
            $rules = [
                    'name' => 'required|min:1|max:128',
                    'password' => 'required|min:8|max:32',
                    'email' => 'required|email|unique:admins',
                    'lid' => 'alpha_num|min:1|max:40',
                    'locale' => 'required',
                    'authority' => 'required',
                    'status' => 'required'
            ];
        }
        $validation = Validator::make ( $request->all (), $rules );

        if ($validation->fails ()) {
            $arrErrors ['systemCode'] = 400;
            $arrErrors ['errorMeg'] = $validation->errors ()->all ();

            $request->flash ();
            // return view('admin.create',$arrErrors);
            return redirect ()->back ()->withErrors ( $validation->errors () )->withInput ();
        }

        // パスワードの暗号化等の処理
        $arrValues = array (
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt ( $request->password ),
                'lid' => $request->lid,
                'locale' => $request->locale,
                'authority' => $request->authority,
                'status' => $request->status
        );

        // 更新の場合
        if (isset ( $request->id )) {
            $getUsrId = $this->mdlAdmin->renewal ( $request->id, $arrValues );
        } else {
            $getUsrId = $this->mdlAdmin->resist ( 'line', $arrValues );
        }
        // return view('admin.create',$arrErrors);
        return redirect ( 'admin' );
    }


    public function edit($uid) {

        $arrValue = array ();
        $arrValue ['systemCode'] = '';

        $arrValue ['userInfo'] = $this->mdlAdmin->getOne ( 'line', $uid );

        return view ( 'admin.edit', $arrValue );
    }

}
