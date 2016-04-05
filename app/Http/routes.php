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

// Authentication Routes...
$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

Route::group(['middleware' => 'web'], function () {

    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index',
    ]);

    Route::resource('news', 'BlogController');

    Route::get('gallery', [
        'as' => 'gallery.index',
        'uses' => 'GalleryController@index',
    ]);

    Route::get('gallery/{id}', [
        'as' => 'gallery.category',
        'uses' => 'GalleryController@showCategory',
    ]);

    Route::post('upload/image', function (\App\Http\Forms\UploadForm $form) {
        return $form->persist();
    });

    Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function () {
        Route::get('polls.json', [
            'as' => 'poll.list',
            'uses' => 'PollController@index',
        ]);

        Route::post('poll/vote/{id}', [
            'as' => 'poll.vote',
            'uses' => 'PollController@vote',
        ]);

        Route::post('poll/reset/{id}', [
            'as' => 'poll.reset',
            'uses' => 'PollController@reset',
        ]);

        Route::get('app.js', [
            'uses' => 'AppController@scripts',
        ]);

        Route::get('post/{id}/members.json', [
            'as' => 'post.members.list',
            'uses' => 'PostController@members',
        ]);

        Route::post('post/{id}/members.json', [
            'middleware' => 'auth',
            'as' => 'post.members.add',
            'uses' => 'PostController@addMember',
        ]);
    });
});
/*
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('photo/category', 'PhotoCategoriesController');
});*/
