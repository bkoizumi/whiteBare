<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
// use Carbon\Carbon;
use App\Models\AutoResponseModels;



class AutorepliesController extends Controller
{
    protected $mdlAutoreplies;
    protected $mdlUsers;

    public function __construct(){
      $this->mdlAutoReplies = new AutoResponseModels();
    }


    public function index(Request $request){
        $order = $request->get('order');
        $dir = $request->get('dir');
        $page_appends = null;

        //ソート情報
        if ($order && $dir) {
            $pageAppends = array($order => $dir);
        }else{
            $pageAppends = array('created_at' => 'desc');
        }
        //登録されている配信リストの取得
        $lists = $this->mdlAutoReplies->getAllList('line', $pageAppends, config('whitebear.paginate.autoReplies'));

        $data['lists'] = $lists;
        $data['order'] = $order;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['pageAppends'] = $pageAppends;
       return view('autoreplies.index', $data);
    }


    public function create(Request $request){
        return view('autoreplies.create');
    }


    public function resist(Request $request){
        return redirect('autoreplies');
    }


   public function edit($id){
        return view('autoreplies.index');
    }
}
