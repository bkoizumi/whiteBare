<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
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
use Storage;

use App\Models\TargetsModels;
use App\Models\UsersModels;
use App\Models\MessagesModels;
use App\Models\LineAPI;
use App\Models\EventModels;
use Intervention\Image\Facades\Image;

class MessageController extends Controller
{

    protected $mdlTarget;
    protected $mdlUsers;
    protected $mdlMessages;
    protected $mdlEvent;
    protected $LineAPI;


    public function __construct() {
        $this->mdlTarget = new targetsModels ();
        $this->mdlUsers = new UsersModels ();
        $this->mdlMessages = new MessagesModels ();
        $this->mdlEvent = new EventModels ();
        $this->LineAPI = new LineAPI ();

    }


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

        $getListAlls = $this->mdlMessages->getList ( 'line', $listOrder );

        $data ['Lists'] = $getListAlls;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['page_appends'] = $pageAppends;
        $data ['allItemCount'] = count ( $getListAlls );

        return view ( 'message.index', $data );
    }


    /**
     * 新規登録
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Request $request) {
        $data ['targetLists'] = $this->mdlTarget->getListAll ( 'line', array (
                'id' => 'desc'
        ) );

        return view ( 'message.create', $data );
    }


    /**
     * 編集
     *
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id) {

        $data = array ();
        $data ['systemCode'] = '';

        $data ['listInfo'] = $this->mdlMessages->getOne ( 'line', $id );
        $data ['listDetailInfo'] = $this->mdlMessages->getDetail ( 'line', $id );
        $data ['targetLists'] = $this->mdlTarget->getListAll ( 'line', array (
                'id' => 'desc'
        ) );
        return view ( 'message.edit', $data );
    }


    /**
     * 配信メッセージの登録
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function resist(Request $request) {

        //メッセージヘッダー登録・更新
        $arrMessageHeader = array (
                'app_type' => 'line',
                'title' => $request->main_title,
                'send_schedule' => $request->send_date,
                'target_id' => $request->target,
                'status' => $request->resist
        );
        if($request->messageId ==''){
            $MessageHeaderID = $this->mdlMessages->insertMessageHeader ( $arrMessageHeader );
        }else{
            $this->mdlMessages->updateMessageHeader ($request->messageId, $arrMessageHeader );
            $MessageHeaderID = $request->messageId;
        }

        // テキストメッセージの場合
        if ($request->textMeg) {
            foreach ($request->textMeg as $key => $value) {
                if ($value) {
                    $arrMessageDetails [] = array (
                            'message_id' => $MessageHeaderID,
                            'type' => "text",
                            'text' => $value
                    );
                }
            }
        }

        // イメージの場合
        if (isset ( $request->img [0] )) {
            $imgCount = 1;
            foreach ($request->img as $key => $value) {
                if ($value) {
                    $fileName = $MessageHeaderID . '-' . $imgCount;
                    $filePath = $value->getRealPath ();
                    $fileBody = file_get_contents ( $filePath );
                    Storage::disk ( 'sendLineImage' )->put ( $fileName, $fileBody );
                    list ( $width, $height ) = getimagesize ( storage_path ( 'app/line/img/send' ) . '/' . $fileName );

                    $arrMessageDetails [] = array (
                            'message_id' => $MessageHeaderID,
                            'type' => "image",
                            'original_content' => env ( 'APP_URL' ) . '/img/send/' . $fileName . '/' . $height . '/' . $width,
                            'preview_image_url' => env ( 'APP_URL' ) . '/img/send/' . $fileName . '/' . $height . '/' . $width
                    );
                    $imgCount ++;
                }
            }
        }

        // イメージマップの場合
        if (isset ( $request->imgMap [0] )) {
            $imgMapCount = 1;
            foreach ($request->imgMap as $key => $value) {
                if ($value) {
                    $fileName = $MessageHeaderID . '-' . $imgMapCount;
                    $filePath = $value->getRealPath ();
                    $fileBody = file_get_contents ( $filePath );
                    Storage::disk ( 'sendLineImage' )->put ( $fileName, $fileBody );
                    list ( $width, $height ) = getimagesize ( storage_path ( 'app/line/img/send' ) . '/' . $fileName );

                    $arrMessageDetails [] = array (
                            'message_id' => $MessageHeaderID,
                            'type' => "imagemap",
                            'alt_text' => $request->altText,
                            'map_layout' => $request->mapLayout,
                            'original_content' => env ( 'APP_URL' ) . '/img/send/' . $fileName . '/' . $height . '/' . $width,

                            'action_char01' => (isset ( $request->imgMapChar [0] )) ? $request->imgMapChar [0] : NULL,
                            'action_char02' => (isset ( $request->imgMapChar [1] )) ? $request->imgMapChar [1] : NULL,
                            'action_char03' => (isset ( $request->imgMapChar [2] )) ? $request->imgMapChar [2] : NULL,
                            'action_char04' => (isset ( $request->imgMapChar [3] )) ? $request->imgMapChar [3] : NULL,
                            'action_char05' => (isset ( $request->imgMapChar [4] )) ? $request->imgMapChar [4] : NULL,
                            'action_char06' => (isset ( $request->imgMapChar [5] )) ? $request->imgMapChar [5] : NULL,

                            'act_type01' => (isset ( $request->imgMapActionType [0] )) ? $request->imgMapActionType [0] : NULL,
                            'act_type02' => (isset ( $request->imgMapActionType [1] )) ? $request->imgMapActionType [1] : NULL,
                            'act_type03' => (isset ( $request->imgMapActionType [2] )) ? $request->imgMapActionType [2] : NULL,
                            'act_type04' => (isset ( $request->imgMapActionType [3] )) ? $request->imgMapActionType [3] : NULL,
                            'act_type05' => (isset ( $request->imgMapActionType [4] )) ? $request->imgMapActionType [4] : NULL,
                            'act_type06' => (isset ( $request->imgMapActionType [5] )) ? $request->imgMapActionType [5] : NULL
                    );
                    $imgMapCount ++;
                }
            }
        }

        // コンファームの場合
        if (isset ( $request->confirm_title [0] )) {
            $confirmCount = 1;

            foreach ($request->confirm_title as $key => $value) {
                if ($value) {
                    $arrMessageDetails [] = array (
                            'message_id' => $MessageHeaderID,
                            'type' => "confirm",
                            'alt_text' => $request->altText [0],
                            'text' => $value,

                            'action_char01' => (isset ( $request->actionChar [0] )) ? $request->actionChar [0] : NULL,
                            'action_char02' => (isset ( $request->actionChar [1] )) ? $request->actionChar [1] : NULL,

                            'act_type01' => (isset ( $request->actionTextChar [0] )) ? $request->actionTextChar [0] : NULL,
                            'act_type02' => (isset ( $request->actionTextChar [1] )) ? $request->actionTextChar [1] : NULL
                    );
                    $confirmCount ++;
                }
            }
        }
        $MessageDetailsID = $this->mdlMessages->updateMessageDetails ( $MessageHeaderID,$arrMessageDetails );
        return redirect ( 'message' );
    }


    /**
     * メッセージ受信（チャット）
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function receive(Request $request) {
        $getListAlls = $this->mdlMessages->getChatList ( 'line' );

        $data ['Lists'] = $getListAlls;

        return view ( 'message.receive', $data );

    }

    // 受信メッセージの詳細
    public function receiveMegDetail($lid) {

        $getUserInfo = $this->mdlUsers->getUserInfo ( 'line', $lid );
        $getMegLists = $this->mdlMessages->getListChatDetail ( 'line', $lid );

        // ソート
        foreach ($getMegLists as $key => $value) {
            $sort [$key] = $value->id;
            // $value->message = nl2br($value->message);
        }
//         array_multisort ( $getMegLists, $sort );
//         dd($sort);

        $data ['getUserInfo'] = $getUserInfo;
        $data ['MegLists'] = $getMegLists;

        return view ( 'message.receiveMegDetail', $data );
    }

    // メッセージ送信
    public function send(Request $request) {

        $lid = $request->get ( 'lid' );
        $uid = $this->mdlUsers->getLid2UserID ( 'line', $lid );

        // Lineメッセージ送信
        $this->LineAPI->sendTextMessage ( $request->get ( 'message' ) );
        $this->LineAPI->pushMessage ( $uid, $this->LineAPI->message );

        // 送信メッセージの保存
        $arrayMeg = array (
                'app_type' => 'line',
                'meg_type' => 'send',
                'lid' => $lid,
                'message_id' => '',
                'message' => $request->get ( 'message' ),
        );
        $this->mdlMessages->insertOneReceive ( $arrayMeg );

        return redirect ( 'message/receive/' . $lid );
    }

}
