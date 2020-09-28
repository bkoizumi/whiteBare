<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\User;
use Illuminate\Support\Facades\Input;

use App\Models\TargetsModels;
use App\Models\UsersModels;
use App\Models\LineAPI;

class FriendsController extends Controller
{

    protected $mdlTarget;

    protected $mdlUsers;

    protected $mdlMessages;

    protected $mdlEvent;


    public function __construct() {
        $this->mdlTarget = new targetsModels ();
        $this->mdlUsers = new UsersModels ();
        $this->LineAPI = new LineAPI ();
        // $this->mdlMessages = new MessagesModels();
        // $this->mdlEvent = new EventModels();
        // $this->mdlLineMessageSend = new LineMessageSendModels();

    }


    public function index(Request $request) {
        $order = $request->get ( 'order' );
        $dir = $request->get ( 'dir' );
        $page_appends = null;

        // ソート情報
        if ($order && $dir) {
            $pageAppends = array (
                    $order => $dir
            );
        } else {
            $pageAppends = array (
                    'created_at' => 'desc'
            );
        }
        $usersLists = $this->mdlUsers->getListAll ( 'line', $pageAppends, config ( 'whitebear.paginate.friends' ) );

        // ユーザー情報の再取得
        foreach ($usersLists as $key => $values) {
            if ($values->relation_state == 0) {
                if (isset ( $values->thumbnail_url )) {
                    $response = @file_get_contents ( $values->thumbnail_url, NULL, NULL, 0, 1 );
                    if ($response == false) {
                        Log::info ( $values->nick_name . "のプロフィール再取得" );
                        $profile = $this->LineAPI->getProfile ( $values->uid );
                        if (isset ($profile ['pictureUrl'])){
                            $profileArray = array (
                                    // 'nick_name' =>$profile['displayName'],
                                   // 'status_message' =>$profile['statusMessage'],
                                    'thumbnail_url' => $profile ['pictureUrl']
                            );
                        $values->thumbnail_url = $profile ['pictureUrl'];
                        $this->mdlUsers->updateOne ( 'line', $values->uid, $profileArray );
                        }
                    }
                }
            }
        }

        // 登録されている配信リストの取得
        $targetLists = $this->mdlTarget->getListAll ( 'line', array (
                'id' => 'desc'
        ) );

        $data ['targetLists'] = $targetLists;
        $data ['users'] = $usersLists;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['pageAppends'] = $pageAppends;

        return view ( 'friends.index', $data );
    }


    public function resist(Request $request) {

        foreach ($request->check as $key => $lid) {
            $arrValues = array (
                    'target_id' => $request->targetId,
                    'uid' => $this->mdlUsers->getLid2UserID ( 'line', $lid ),
                    'lid' => $lid,
                    'params' => ''
            );
            $this->mdlTarget->resistDetails ( 'line', $arrValues );
        }

        return redirect ( 'friends' );
    }


    public function getListIcons($field, $direction) {
        $list_ic = array (
                'icon-sort-default',
                'icon-sort-default',
                'icon-sort-default',
                'icon-sort-default'
        );
        $list = array (
                'type_asc' => 0,
                'type_desc' => 1,
                'created_at_asc' => 2,
                'created_at_desc' => 3
        );
        if ($field == '') {
            $list_ic [3] = 'icon-sort';
        } else {
            $get_index = $field . '_' . $direction;
            $i = $list [$get_index];
            $list_ic [$i] = "icon-sort";
        }
        return $list_ic;
    }





}
