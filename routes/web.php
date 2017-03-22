<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('frontend.content.home');
})->name('mypage');

Auth::routes();

//login
Route::get('login','manage\UserController@login')->name('login');
Route::post('login','manage\UserController@doLogin');
//logout
Route::get('logout',function (){
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
//front end
Route::get('mypage',function(){
    return view('frontend.content.home');
});

Route::group(array('prefix'=>'mypage'),function(){
    Route::get('home','frontend\MypageController@Home')->name('front_home');

    Route::get('front_list_news','frontend\MypageController@List_News')->name('front_list_news');

    Route::get('news_content/{id}','frontend\MypageController@news_Content')->name('news_content');
});

Route::group(array("prefix"=>"manage","middleware"=>"auth"),function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(array('prefix'=>'admin'),function (){
        //show list of users
        Route::get('list_user','manage\UserController@show')->name('list_user');
        // delete temporary
        Route::get('delete/{id}','manage\UserController@delete')->name('delete');
        // show list of deleted users
        Route::get('deleted_user','manage\UserController@Deleted_User')->name('deleted_user');
        //delete user forever
        Route::get('delete_forever/{id}','manage\UserController@Delete_Forever')->name('delete_forever');
        //restore account
        Route::get('restore/{id}','manage\UserController@restore')->name('restore');
        //show list of news
        Route::get('news','manage\NewsController@show')->name('news');
        //add new news
        Route::get('add','manage\NewsController@add')->name('add_news');

        Route::post('add','manage\NewsController@do_Add');
        // delete news
        Route::get('delete_news/{id}','manage\NewController@delete')->name('delete_news');
        //edit news
        Route::get('edit_news/{id}','manage\NewsController@edit')->name('edit_news');
        //get new news's infor
        Route::post('edit_news/{id}','manage\NewsController@do_Edit');


    });
    //edit user's infor
    Route::get('edit_user/{id}','manage\UserController@edit')->name('edit_user');
    //get new user's infor
    Route::post('edit_user/{id}','manage\UserController@do_edit');
});
Route::get('manage',function(){
    if(Auth::check()){
        return redirect()->route('home');
    }
    else return redirect()->route('login');
});