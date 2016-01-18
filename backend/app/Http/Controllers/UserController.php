<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use App\Models\Friend;
use App\Models\Media;
use App\Models\User;
use App\Models\Wish;
use Faker\Provider\File;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends Controller
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
        $user = DB::table('user')
            ->where('user.id', $id)
            ->where('user.is_deleted', '=', '0')
            ->where('user.is_enable', '=', '1')
            ->join('role', 'user.role_id', '=', 'role.id')
            ->join('media', 'user.media_id', '=', 'media.id')
            ->join('contact', 'user.contact_id', '=', 'contact.id')
            ->select(
                'user.id',
                'first_name',
                'last_name',
                'role.name AS role',
                'media.name AS photo',
                'email',
                'phone',
                'address')
            ->first();

        if($user) {
            $user->count_friends = Friend::where('user_id', $user->id)
                ->where('status', "friend")
                ->where('related_user_id', '!=', Auth::user()->id)
                ->count();

            $user->count_wishes = Wish::where('user_id', $user->id)->count();
            return response()->json(["data" => $user, "result" => "success"], 200);
        } else {
            return response()->json(["result" => "error_user_not_found"], 200);
        }
    }


    public function setPhoto() {
        if(Auth::check()) {
            $text = Input::get('file');
            $destinationPath = 'images/users/';

            $data = $text['$ngfDataUrl'];
            list($type, $data) = explode(';', $data);
            list(, $type) = explode('/', $type);
            list(, $data) = explode(',', $data);

            $fileName = md5(date("YmdHis").rand(5,50)).'.'.$type;
            $data = base64_decode($data);

            $media = Media::where('id', Auth::user()->media_id)->first();

            if (file_put_contents($destinationPath.$fileName, $data)) {
                if($media->id != 1) {
                    $tmp = $media->name;
                    $media->name = URL::to('/')."/".$destinationPath.$fileName;
                    $media->save();

                    $arr = explode("/", $tmp);
                    unlink($destinationPath.$arr[count($arr)-1]);
                } else {
                    $media = new Media();
                    $media->name = URL::to('/')."/".$destinationPath.$fileName;
                    $media->save();
                    $user = Auth::user();
                    $user->media_id = $media->id;
                    $user->save();
                }
                return $this->getProfile();
            } else {
                return response()->json(['result' => 'error'], 200);
            }
        } else {
            return response()->json(['result' => 'error'], 200);
        }

    }

    public function searchUsers($search)
    {
        if (Auth::check()) {
            $users = DB::table('user')
                ->join('role', 'user.role_id', '=', 'role.id')
                ->leftjoin('media', 'user.media_id', '=', 'media.id')
                ->select('user.id', 'first_name', 'last_name', 'role.name AS role', 'media.name AS photo', 'email')
                ->where('user.is_deleted', '=', '0')
                ->where('user.is_enable', '=', '1')
                ->where('user.id', '!=', Auth::user()->id)
                ->where('user.first_name', 'like', '%'.$search.'%')
                ->orWhere('user.last_name', 'like', '%'.$search.'%')
                ->get();

            if($users) {
                foreach($users as $key => $value)
                {
                    $friend = Friend::where('user_id', Auth::user()->id)->where('related_user_id', $value->id)->first();
                    if($friend) {
                        $users[$key]->category = $friend->category->name;
                        $users[$key]->status = $friend->status;
                    } else {
                        $users[$key]->category = null;
                        $users[$key]->status = null;
                    }
                }

            }
            return response()->json(["data" => $users, "result" => "success"], 200);
        } else {
            return response()->json(["result" => "error_access_deny"], 200);
        }
    }

    public function showAll()
    {
        if (Auth::check()) {
            $users = DB::table('user')
                ->join('role', 'user.role_id', '=', 'role.id')
                ->leftjoin('media', 'user.media_id', '=', 'media.id')
                ->select('user.id', 'first_name', 'last_name', 'role.name AS role', 'media.name AS photo', 'email')
                ->where('user.is_deleted', '=', '0')
                ->where('user.is_enable', '=', '1')
                ->where('user.id', '!=', Auth::user()->id)
                ->get();

            if($users) {
                foreach($users as $key => $value)
                {
                    $friend = Friend::whereRaw('user_id = ? AND related_user_id = ?', [Auth::user()->id, $value->id])->first();
                    if($friend) {
                        $users[$key]->category = $friend->category->name;
                        $users[$key]->status = $friend->status;
                    } else {
                        $users[$key]->category = null;
                        $users[$key]->status = null;
                    }
                }
                return response()->json(["data" => $users, "result" => "success"], 200);
            } else {
                return response()->json(["result" => "error_no_any_users"], 200);
            }
        } else {
            return response()->json(["result" => "error_access_deny"], 200);
        }
    }

    public function login()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            if(Auth::user()->is_deleted || !Auth::user()->is_enable) {
                return response()->json(["result" => "error_access_deny"], 200);
            }
            return $this->show(Auth::user()->id);
        } else {
            return response()->json(["result" => "error"], 200);
        }
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(["result" => "success"], 200);
    }

    public function getProfile()
    {
        if(Auth::check()) {
            if(Auth::user()->is_deleted) {
                return response()->json(["result" => "error_user_deleted"], 200);
            } elseif(!Auth::user()->is_enable) {
                return response()->json(["result" => "error_access_deny"], 200);
            } else {
                return $this->show(Auth::user()->id);
            }
        } else {
            return response()->json(["result" => "error_not_auth"], 200);
        }
    }

    public function registration() {
        $data = Input::all();

        if (!isset($data['email'], $data['password'], $data['confirm'])
            || strlen($data['email']) < 4
            || strlen($data['email']) > 255
            || strlen($data['password']) < 4) {
            return response()->json(["result" => "error", "data" => "Error. Invalid data!"], 200);
        }

        if (User::where('email', $data['email'])->first()) {
            return response()->json(["result" => "error", "data" => "User wish email ".$data['email']." is already exists!"], 200);
        }

        if ($data['password'] != $data['confirm']) {
            return response()->json(["result" => "error", "data" => "Invalid password confirmation!"], 200);
        }

        $contact = [];
        if (isset($data['phone'])) {
            $contact['phone'] = $data['phone'];
        }
        if (isset($data['city'])) {
            $contact['address'] = $data['city'];
        }

        $contactResult = false;
        if ($contact) {
            $contactResult = DB::table('contact')->insertGetId($contact);
        }

        if ($contactResult) {
            $data['contact_id'] = $contactResult;
        }

        unset($data['phone'], $data['city'], $data['confirm']);
        $data['password'] = Hash::make($data['password']);

        $userResult = DB::table('user')->insert($data);
        if (!$userResult) {
            return response()->json(["result" => "error", "data" => "Unknown error"], 200);
        }
        return response()->json(["result" => "success"], 200);
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
