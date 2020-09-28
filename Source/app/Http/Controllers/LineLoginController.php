<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\User;
use Illuminate\Support\Facades\Input;

use App\Models\UsersModels;
use App\Models\LineLoginAPI;

class LineLoginController extends Controller
{

    protected $LineLoginAPI;
    protected $mdlUsers;

    public function __construct() {
        $this->mdlUsers = new UsersModels ();
        $this->LineLoginAPI = new LineLoginAPI ();
    }

    /**
     * Lineログインからメンバー表示
     * @param Request $request
     */
    public function showMember(Request $request) {

        $callBackUrl = 'https://tci-bbq.whitebear.tk/line/showMember';
        if (empty($_GET) ){
            $this->LineLoginAPI->getCode($callBackUrl);
            exit;
        }
//         dd($_GET);
        $LineAccessToken = $this->LineLoginAPI->getAccessToken($callBackUrl, $_GET['code']);
        $profileData = $this->LineLoginAPI->getProfile($LineAccessToken);
        $lid = $this->mdlUsers->getUserID2Lid("line", $profileData['userId']);
        if (isset ($lid)){
            // ソート情報
            $pageAppends = array (
                    'created_at' => 'desc'
            );
            $usersLists = $this->mdlUsers->getListAll ( 'line', $pageAppends, config ( 'whitebear.paginate.friends' ) );

            $data ['users'] = $usersLists;
            $data ['order'] = null;
            $data ['dir'] = null;
            $data ['pageAppends'] = $pageAppends;

            return view ( 'friends.member', $data );

        }
    }


}
