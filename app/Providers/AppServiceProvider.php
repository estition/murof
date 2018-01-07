<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//		\View::composer(['threads.create', 'sssss'] or *, function($view){
//			$view->with('channels', \App\Channel::all());
//		});
		Schema::enableForeignKeyConstraints();
		\View::composer( "*", function($view){
			$channels = \Cache::rememberForever('channels', function(){
				return \App\Channel::all();
			});
			$view->with('channels', $channels);
		});
//		\View::share('channels', \App\Channel::all());
		\Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
	
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->isLocal()){
			$this->app->register (\Barryvdh\Debugbar\ServiceProvider::class);
		}
    }
}
