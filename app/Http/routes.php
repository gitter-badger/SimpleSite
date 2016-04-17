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
use Illuminate\Http\JsonResponse;

$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

Route::group(['middleware' => 'web'], function () {

    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index',
    ]);

    Route::get('events.ics', [
        'as' => 'news.events',
        'uses' => 'BlogController@events',
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

    Route::get('users', [
        'as' => 'user.index',
        'uses' => 'UserController@index',
    ]);

    Route::get('profile', [
        'as' => 'profile',
        'uses' => 'UserController@profile',
    ]);

    Route::get('users/tree', [
        'as' => 'user.tree',
        'uses' => 'UserController@tree',
    ]);

    Route::get('user/{id}', [
        'as' => 'user.profile',
        'uses' => 'UserController@userProfile',
    ]);

    Route::group(['middleware' => 'admin'], function () {
        Route::post('upload/image', function (\App\Http\Forms\UploadForm $form) {
            return $form->persist();
        });

        Route::post('upload/photo/{id}', function (\App\Http\Forms\UploadPhotoForm $form) {
            return new JsonResponse($form->persist());
        });

        Route::delete('delete/photo/{id}', function ($id) {
            \App\Photo::find($id)->delete();
            return new JsonResponse(true);
        });
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::post('profile/avatar', function (\App\Http\Forms\UploadAvatarForm $form) {
            return new JsonResponse($form->persist());
        });
    });

    Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function () {
        Route::get('polls.json', [
            'as' => 'poll.list',
            'uses' => 'PollController@index',
        ]);

        Route::get('settings.js', [
            'uses' => 'AppController@settings',
        ]);

        Route::get('post/{id}/members.json', [
            'as' => 'post.members.list',
            'uses' => 'PostController@members',
        ]);

        Route::get('user/{id}/calendar.json', [
            'as' => 'user.calendar',
            'uses' => 'UserController@calendar',
        ]);

        Route::group(['middleware' => 'auth'], function () {
            Route::post('poll/vote/{id}', [
                'middleware' => 'auth',
                'as' => 'poll.vote',
                'uses' => 'PollController@vote',
            ]);

            Route::post('poll/reset/{id}', [
                'middleware' => 'auth',
                'as' => 'poll.reset',
                'uses' => 'PollController@reset',
            ]);

            Route::post('post/{id}/members.json', [
                'middleware' => 'auth',
                'as' => 'post.members.add',
                'uses' => 'PostController@addMember',
            ]);
        });
    });
});
/*
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('photo/category', 'PhotoCategoriesController');
});*/
