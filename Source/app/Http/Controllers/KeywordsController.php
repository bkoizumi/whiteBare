<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Log;
use Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
// use Carbon\Carbon;
use App\Models\KeywordsModels;

class KeywordsController extends Controller
{
    protected $mdlKeywords;
    protected $mdlUsers;

    public function __construct() {
        $this->mdlKeywords = new KeywordsModels ();
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
        // 登録されている配信リストの取得
        $lists = $this->mdlKeywords->getAllList ( 'line', $pageAppends, config ( 'whitebear.paginate.autoReplies' ) );

        $data ['lists'] = $lists;
        $data ['order'] = $order;
        $data ['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data ['pageAppends'] = $pageAppends;

        return view ( 'keywords.index', $data );
    }

    public function create(Request $request) {
        return view ( 'keywords.create' );
    }

    public function resist(Request $request) {

        //キーワードヘッダー登録・更新
        $dataRange = explode(" to ", $request->date);
        if(count($dataRange) <2){
            $dataRange[0]='1900/01/01';
            $dataRange[1]='9999/12/31';
        }
        $arrMessageHeader = array (
                'app_type' => 'line',
                'title' => $request->title,
                'valid_from' => $dataRange[0],
                'valid_to' => $dataRange[1],
                'receive_meg_type' => 'text',
                'receive_meg_body' => $request->receive_message,
                'note' => $request->notes,
                'status' => $request->status,
        );

        if($request->keywordsId ==''){
            $KeywordsHeaderID = $this->mdlKeywords->insertKeywordsHeader ( $arrMessageHeader );
        }else{
            $this->mdlKeywords->updateKeywordsHeader ($request->messageId, $arrMessageHeader );
            $KeywordsHeaderID = $request->messageId;
        }

        // テキストメッセージの場合
        if ($request->textMeg) {
            foreach ($request->textMeg as $key => $value) {
                if ($value) {
                    $arrMessageDetails [] = array (
                            'keywords_id' => $KeywordsHeaderID,
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
                    $fileName = $KeywordsHeaderID . '-' . $imgCount;
                    $filePath = $value->getRealPath ();
                    $fileBody = file_get_contents ( $filePath );
                    Storage::disk ( 'sendLineImage' )->put ( $fileName, $fileBody );
                    list ( $width, $height ) = getimagesize ( storage_path ( 'app/line/img/send' ) . '/' . $fileName );

                    $arrMessageDetails [] = array (
                            'keywords_id' => $KeywordsHeaderID,
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
                    $fileName = $KeywordsHeaderID . '-' . $imgMapCount;
                    $filePath = $value->getRealPath ();
                    $fileBody = file_get_contents ( $filePath );
                    Storage::disk ( 'sendLineImage' )->put ( $fileName, $fileBody );
                    list ( $width, $height ) = getimagesize ( storage_path ( 'app/line/img/send' ) . '/' . $fileName );

                    $arrMessageDetails [] = array (
                            'keywords_id' => $KeywordsHeaderID,
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
                            'keywords_id' => $KeywordsHeaderID,
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

        if($request->messageId ==''){
            $MessageHeaderID = $this->mdlKeywords->insertKeywordsDetails ( $arrMessageDetails );
        }else{
            $KeywordsDetailsID = $this->mdlKeywords->updateKeywordsDetails ( $KeywordsHeaderID,$arrMessageDetails );
        }





        Log::debug ($arrMessageHeader);

        return redirect ( 'keywords' );
    }

    public function edit($id) {
        $data = array ();
        $data ['systemCode'] = '';

        $data ['listInfo'] = $this->mdlKeywords->getOne ($id );
        $data ['listDetailInfo'] = $this->mdlKeywords->getDetail ( $id );

        Log::debug ( ($data) );
        return view ( 'keywords.edit', $data );
    }
}
