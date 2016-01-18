<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function editFriend()
    {
        if (Auth::check()) {
            $friend = Friend::where('user_id', Auth::user()->id)
                ->where('related_user_id', Input::get('id'))
                ->update(["category_id" => Input::get('categoryId')]);

            if ($friend) {
                return response()->json(["result" => "success"], 200);
            } else {
                return response()->json(["result" => "Unknown error!"], 200);
            }
        } else {
            return response()->json(["result" => "Error. Access deny!"], 200);
        }
    }

    public function addFriend()
    {
        if (Auth::check() && Input::get('id')) {
            $friend = Friend::whereRaw('user_id = ? AND related_user_id = ?', [Auth::user()->id, Input::get('id')])
                ->update(["status" => "friend", "category_id" => Input::get('categoryId')]);

            if (!$friend) {
                $friend = new Friend();
                $friend->user_id = Auth::user()->id;
                $friend->related_user_id = Input::get('id');
                $friend->category_id = Input::get('categoryId');
                $friend->status = "friend";
                $friend->save();
                $friend = null;
            }

            $friend = Friend::whereRaw('user_id = ? AND related_user_id = ?', [Input::get('id'), Auth::user()->id])->first();
            if (!$friend) {
                $friend = new Friend();
                $friend->user_id = Input::get('id');
                $friend->related_user_id = Auth::user()->id;
                $friend->category_id = Input::get('categoryId');
                $friend->save();
            }
            return response()->json(["result" => "success"], 200);
        }
        return response()->json(["result" => "error"], 200);
    }

    public function removeFriend() {
        if (Auth::check() && Input::get('id')) {
            $friend = Friend::whereRaw('user_id = ? AND related_user_id = ?', [Auth::user()->id, Input::get('id')])
                ->delete();

            if ($friend) {
                return response()->json(["result" => "success"], 200);
            }
        }
        return response()->json(["result" => "error"], 200);
    }

    public function showAllFriends() {
        if(Auth::check()) {
            $friends = DB::table('friend')
                ->join('user', 'friend.related_user_id', '=', 'user.id')
                ->leftjoin('media', 'user.media_id', '=', 'media.id')
                ->leftjoin('category', 'friend.category_id', '=', 'category.id')
                ->select(
                    'user.id',
                    'first_name',
                    'last_name',
                    'media.name AS photo',
                    'email',
                    'category.name AS category',
                    'friend.status AS status')
                ->where('user_id', Auth::user()->id)
                ->where('user.is_deleted', '0')
                ->where('user.is_enable', '1')
                ->get();

            return response()->json(['result' => 'success', 'data' => $friends], 200);
        }
        return response()->json(['result' => 'error'], 200);
    }

    public function showUserFriends($id) {
        if(Auth::check()) {
            $friends = DB::table('friend')
                ->join('user', 'friend.related_user_id', '=', 'user.id')
                ->leftjoin('media', 'user.media_id', '=', 'media.id')
                ->select(
                    'user.id',
                    'first_name',
                    'last_name',
                    'media.name AS photo',
                    'email',
                    'friend.status AS status')
                ->where('user_id', $id)
                ->where('related_user_id', '!=', Auth::user()->id)
                ->where('user.is_deleted', '0')
                ->where('user.is_enable', '1')
                ->where('friend.status', 'friend')
                ->get();

            if ($friends) {
                foreach($friends as $key => $value)
                {
                    $friend = Friend::where('user_id', Auth::user()->id)
                        ->where('related_user_id', $value->id)
                        ->where('status', 'friend')
                        ->first();

                    if (!$friend) {
                        $friends[$key]->isMyFriend = 0;
                    } else {
                        $friends[$key]->isMyFriend = 1;
                    }
                }
            }
            return response()->json(['result' => 'success', 'data' => $friends], 200);
        }
        return response()->json(['result' => 'error'], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
