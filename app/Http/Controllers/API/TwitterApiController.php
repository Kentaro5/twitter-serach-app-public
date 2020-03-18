<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TwitterApiController extends Controller
{
    public $data=[];

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = auth()->user();

        $twitter_auth = new TwitterOAuth(env('TWITTER_CLIENT_ID'),
            env('TWITTER_CLIENT_SECRET'),
            env('TWITTER_CLIENT_ID_ACCESS_TOKEN'),
            env('TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET'));

        $fav_lists = $twitter_auth->get("favorites/list", [
            "count" => 600,
            "user_id" => $user->provider_id
        ]);

        if( $request->request->get('user_name') ){

            $this->data = $this->search_fav_by_user_name( $twitter_auth );
        }else{

            $this->data = $fav_lists;
        }

        return Response::json($this->data);
   }

   public function search_fav_by_user_name( $twitter_auth, $fav_lists )
   {
        $user_name = $request->request->get('hoge');
       $tw_user = $twitter_auth->get("users/lookup", [
            "screen_name" => $user_name
        ]);

        for ($i=0; $i < count($fav_lists); $i++) {

            if( $fav_lists[$i]->user->id === $tw_user[0]->id ){

                $this->data[$i] = $fav_lists[$i];
            }
        }
        return $this->data;
   }
}
