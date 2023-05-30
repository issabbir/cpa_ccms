<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 11:40 AM
 */

namespace App\Http\Controllers;

use App\Entities\Security\GenNotifications;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $news_id=$request['news_id'];
        $sql = "select cpa_security.cpa_general.get_news_one(:id) from dual";
        $news = DB::selectOne($sql,['id' => $news_id]);

        $newsView= view('news.index', ['data' => $news])->render();

        return response()->json(array(
            'success' => true,
            'newsView'=>$newsView,

        ));

    }

    public function downloadAttachment($news_id) {



        $sql = "select cpa_security.cpa_general.get_news_one(:id) from dual";
        $news = DB::selectOne($sql,['id' => $news_id]);

        if($news) {
            if($news->attachment_filename && $news->attachment_content) {
                $fileArr = explode('.', $news->attachment_filename);
                $content = $news->attachment_content;
                // echo $content; die();
                $contentType = $this->getContentType($fileArr[count($fileArr)-1]);
                $filename = $news->attachment_filename;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
        }
    }

    private $fileTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
    ];

    private function getContentType($fileType)
    {
        $contentType = $this->fileTypes[$fileType];

        if($contentType) {
            return $contentType;
        }

        return '';
    }

    public function readNotification(Request $request,GenNotifications $notifications){
        $result = $notifications->where("notification_id", $request->get('id'))
            ->update([
                "seen_yn" => 'Y'
            ]);

        $id = Auth::user()->user_id;
        $module_id = 41;
        $notifications = DB::select("select CPA_SECURITY.CPA_GENERAL.GET_POP_NOTIFICATIONS($id,$module_id) from dual");

        $arr = array_filter($notifications, array($this, 'filter_callback'));

        $unseen_notification = count($arr);

        if ($result) {
            return response()->json(['status' =>true,'message' =>'Successfully Seen','count'=>$unseen_notification]);
        }
    }
    public function filter_callback($element) {
        if (isset($element->seen_yn) && $element->seen_yn == 'N') {
            return TRUE;
        }
        return FALSE;
    }
    public function seenNotification(Request $request,GenNotifications $notifications){
        $result = $notifications->where("notification_to", Auth::id())->where("module_id", 41)
            ->update([
                "seen_yn" => 'Y'
            ]);

        if ($result) {
            return response()->json(['status' =>true,'message' =>'Successfully Seen']);
        }
    }


}
