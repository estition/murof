<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
     /**
     * Boot the trait.
     */
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites(){
		return $this->morphMany(Favorite::class, 'favorited');
	}
	public function favorite(){
		$attributes = ["user_id" => auth()->id()];
		if(!$this->favorites()->where($attributes)->exists()){
			return $this->favorites()->create($attributes);
		}
	}
	/**
     * Unfavorite the current reply.
     */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }
	
	 /**
     * Fetch the favorited status as a property.
     *
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }


	public function isFavorited(){
//		var_dump($this->favorites()->where("user_id", auth()->id())->exists()); exit;
	 return !! $this->favorites->where("user_id", auth()->id())->count();
	}
	public function getFavoritesCountAttribute(){
//		var_dump($this->favorites()->where("user_id", auth()->id())->exists()); exit;
	 return $this->favorites->count();
	}
	
}
