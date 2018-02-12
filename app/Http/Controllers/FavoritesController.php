<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorite;

class FavoritesController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}
	
	public function store(Reply $reply){
//		$reply->favorites()->create(["user_id" => auth()->id()]);
		$reply->favorite();
		 $reply->owner->gainReputation('reply_favorited');
		
//		return back();
		
//		Favorite::create([
//			"user_id" => auth()->id(),
//			"favorited_id" => $reply->id,
//			"favorited_type" => get_class($reply)
//		]);
	}
	
	    /**
     * Delete the favorite.
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
		$reply->owner->loseReputation('reply_favorited');
     }
}
