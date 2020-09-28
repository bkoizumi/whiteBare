<?PHP

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;
use Config;
use Log;
use DB;
use Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ConversionLogModels;
use App\Models\UsersModels;

class ImageController extends Controller
{
    public function showImg($type, $message, $img_height, $img_width) {
        switch ($type) {
            case 'receive' :
                $contents = Storage::disk ( 'receiveLineImage' )->get ( $message );
                break;
            case 'send' :
                $contents = Storage::disk ( 'sendLineImage' )->get ( $message );
                break;
            case 'reply' :
                    $contents = Storage::disk ( 'replyLineImage' )->get ( $message );
                    break;

            default :
                    break;
        }
        if ( ($img_width >0) and ($img_height >0) ){
            $img = Image::make ( $contents )->resize ( $img_width, $img_height );
        }else{
            $img = Image::make ( $contents );
        }
        return $img->response ();
    }

//     public function send($message, $img_height, $img_width) {

//         $contents = Storage::disk ( 'sendLineImage' )->get ( $message );
//             if ( ($img_width >0) and ($img_height >0) ){
//             $img = Image::make ( $contents )->resize ( $img_width, $img_height );
//         }else{
//             $img = Image::make ( $contents );
//         }
//         return $img->response ();
//     }

    // // ベースの白い全体画像を生成（今回は正方形とする）
    // $base_img = Image::canvas($img_width, $img_width, '#ffffff');
    // // 全体画像にユーザーが送信したメッセージを挿入
    // $base_img->text($message, $img_width/2, $img_width/4, function($font) {
    // $font->color('#000000');
    // $font->align('center');
    // });

    // // 黒領域の画像を生成
    // $black_img = Image::canvas($img_width, $img_width / 2, '#000000');
    // // 黒領域の画像に'SendMessage'という文字を挿入
    // $black_img->text('SendMessage', $img_width/2, $img_width/4, function($font) {
    // $font->color('#ffffff');
    // $font->align('center');
    // });
    // // 全体画像の下部中央に貼り付け
    // $base_img->insert($black_img, 'bottom');

    // // 全体画像を出力
    // return $base_img->response();

}
