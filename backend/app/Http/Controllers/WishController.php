<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Wish;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class WishController extends Controller
{
    public function showAll()
    {
        $wishes = DB::table('wish')
            ->select('wish.id', 'wish.name','category.name AS category','link', 'description', 'media.name AS photo', 'publish_state')
            ->join('media', 'wish.media_id', '=', 'media.id')
            ->join('category', 'wish.category_id', '=', 'category.id')
            ->where('user_id', Auth::user()->id)
            ->orderBy('wish.id')
            ->get();
        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
    }

    public function showFriendWishes($id) {

        $friend = DB::table('friend')

            ->where('user_id','=',$id)
            ->where('status','=','friend')
            ->where('related_user_id','=',Auth::user()->id)
            ->first();

        if($friend) {
            $categoryId = $friend->category_id;

            $wishes = DB::table('wish')
                ->whereRaw(
                    'user_id=? AND publish_state=? AND (wish.category_id=? OR category.name=?)',
                    [
                        $id,
                        1,
                        $categoryId,
                        'All'
                    ])
                ->leftjoin('media', 'wish.media_id', '=', 'media.id')
                ->leftjoin('category', 'wish.category_id', '=', 'category.id')
                ->select(
                    'user_id',
                    'wish.name',
                    'description',
                    'link',
                    'media.name AS photo',
                    'category.name AS category',
                    'publish_state',
                    'present_state'
                )
                ->get();

            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
        else{
            $wishes = DB::table('wish')
                ->where('user_id', $id)
                ->where('publish_state', '=', 1)
                ->where('category.name', '=', 'All')
                ->leftjoin('media', 'wish.media_id', '=', 'media.id')
                ->leftjoin('category', 'wish.category_id', '=', 'category.id')
                ->select(
                    'user_id',
                    'wish.name',
                    'description',
                    'link',
                    'media.name AS photo',
                    'category.name AS category',
                    'publish_state',
                    'present_state'
                )
                ->get();

            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
    }

    public function addWish()
    {
        $text = Input::get("photo");
        $destinationPath = 'images/wishes/';

        $data = $text['$ngfDataUrl'];
        list($type, $data) = explode(';', $data);
        list(, $type) = explode('/', $type);
        list(, $data) = explode(',', $data);

        $fileName = md5(date("YmdHis").rand(5,50)).'.'.$type;
        $data = base64_decode($data);

        $wish =  new Wish();
        $wish->name = Input::get('name');
        $wish->description = Input::get('description');
        $wish->category_id = Input::get('category')['id'];
        $wish->link = Input::get('link');
        $wish->user_id = Auth::user()->id;

        if (file_put_contents($destinationPath.$fileName, $data)) {
            $media = new Media();
            $media->name = URL::to('/')."/".$destinationPath.$fileName;
            $media->save();
            $wish->media_id = $media->id;
        }
        $wish->save();
        return response()->json(['result' => 'success'], 200);
    }

    public function deleteWish($id)
    {
        $wishes = DB::table('wish')->delete($id);
        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
    }

    public function editWish($id)
    {

      //  return response()->json(['result' => 'success', 'data' => $text], 200);


        $wish = Wish::where('id', $id)->first();

        if($wish) {
            $wish->name = Input::get('name');
            $wish->description = Input::get('description');
            $wish->category_id = Input::get('category')['id'];
            $wish->link = Input::get('link');
            $text = Input::get("photo");

            if (isset($text['$ngfDataUrl'])) {
                $destinationPath = 'images/wishes/';
                $data = $text['$ngfDataUrl'];
                list($type, $data) = explode(';', $data);
                list(, $type) = explode('/', $type);
                list(, $data) = explode(',', $data);

                $fileName = md5(date("YmdHis") . rand(5, 50)) . '.' . $type;
                $data = base64_decode($data);
                $media = Media::where('id', $wish->media_id)->first();

                if (file_put_contents($destinationPath.$fileName, $data)) {
                    if($media->id != 3) {
                        $tmp = $media->name;
                        $media->name = URL::to('/')."/".$destinationPath.$fileName;
                        $media->save();

                        $arr = explode("/", $tmp);
                        unlink($destinationPath.$arr[count($arr)-1]);
                    } else {
                        $media = new Media();
                        $media->name = URL::to('/')."/".$destinationPath.$fileName;
                        $media->save();
                        $wish->media_id = $media->id;
                    }
                }
            }

            $wish->save();
            return response()->json(['result' => 'success'], 200);
        } else {
            return response()->json(['result' => 'error'], 200);
        }
    }

    public function changePublishStateTrue($id){
        $data = [
            "publish_state" => 1
        ];
        $wishes = DB::table('wish')
            ->where('id', $id)
            ->update($data);

        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
        return response()->json(['result' => 'success', 'data' => []], 200);
    }

    public function changePublishStateFalse($id){
        $data = [
            "publish_state" => 0
        ];
        $wishes = DB::table('wish')
            ->where('id', $id)
            ->update($data);

        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
        return response()->json(['result' => 'success', 'data' => []], 200);
    }

    public function changePresentStateTrue($id){
        $data = [
            "present_state" => 1
        ];
        $wishes = DB::table('wish')
            ->where('id', $id)
            ->update($data);

        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
        return response()->json(['result' => 'error', 'data' => []], 200);
    }

    public function changePresentStateFalse($id){
        $data = [
            "present_state" => 0
        ];
        $wishes = DB::table('wish')
            ->where('id', $id)
            ->update($data);

        if($wishes) {
            return response()->json(['result' => 'success', 'data' => $wishes], 200);
        }
        return response()->json(['result' => 'error', 'data' => []], 200);
    }

}
