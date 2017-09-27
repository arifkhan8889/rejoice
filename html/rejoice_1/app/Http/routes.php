<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function ()    {
      if(Auth::user()){
         return redirect('user');
      }else{      
          return view('auth.login');
      }
    });
    
Route::auth();

Route::group(['middleware' => 'auth'], function() {
  Route::resource('user', 'admin\UserController'); 
  Route::get('my_profile',function() {
       return view('layouts.my_profile');
     });
  Route::resource('video','admin\VideoController');
  Route::resource('audio','admin\AudioController');
  Route::resource('album','admin\AlbumController');
  Route::resource('subscription','admin\SubscriptionController');
  Route::resource('banner','admin\BannerController');
  Route::resource('transaction','admin\TransactionsController');
  Route::resource('all_downloads','admin\DownloadController');
  Route::resource('sermon','admin\SermonsController');
  Route::resource('radio_station','admin\RadioStationController');
  Route::resource('comments','admin\CommentController');
});

Route::group(['prefix'=>'api'], function() {
  Route::post('video','Api\VideoApi@index');
  Route::post('album','Api\AlbumApi@index');
  Route::post('video/recommended','Api\VideoApi@recommended_videos');
  Route::post('audio/recommended','Api\AudioApi@recommended_audios');
  Route::post('audio','Api\AudioApi@index');  
  Route::post('banner','Api\BannerApi@index');
  Route::post('subscribe_user','Api\SubscriptionApi@user_subscribe');
  Route::post('home','Api\HomeApi@index');
  Route::post('subscription_types','Api\SubscriptionApi@index');
  Route::post('subscribed','Api\user_subscribed@is_user_subscribed');
  Route::post('audio_download','Api\Download@audio_download');
  Route::post('get_all_downloads','Api\Download@index');
  Route::post('is_allowed_download','Api\Download@is_allowed_download');
  Route::post('favourites','Api\FavouritesApi@add_delete_favourites');
  Route::post('favourites_list','Api\FavouritesApi@index');
  Route::post('login','Api\UserLoginApi@login');
  Route::post('fb_login','Api\UserLoginApi@fb_login');
  Route::post('google_login','Api\UserLoginApi@google_login');
  Route::post('sermon','Api\SermonsApi@index');
  Route::post('sermon/recommended','Api\SermonsApi@recommended_sermon');
  Route::post('logout','Api\UserLoginApi@logout');
  Route::post('register','Api\UserLoginApi@registration');
  Route::post('search','Api\Search@index');
  Route::post('radio_station','Api\RadioStation@index');
  Route::post('add_comment','Api\CommentsApi@add_comment');
  Route::post('add/remove_hifive','Api\CommentsApi@add_remove_hifive');
  Route::post('comments','Api\CommentsApi@index');
  Route::post('delete_comment','Api\CommentsApi@delete_comment');
});

