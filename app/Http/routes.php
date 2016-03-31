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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('/', [
        'as' => 'home', 'uses' => 'HomeController@index'
    ]);

    Route::resource('news', 'BlogController');
    Route::get('gallery', [
        'as' => 'gallery.index',
        'uses' => 'GalleryController@index'
    ]);
    Route::get('gallery/{id}', [
        'as' => 'gallery.category',
        'uses' => 'GalleryController@showCategory'
    ]);


    Route::post('upload/image', function(\App\Http\Forms\UploadForm $form) {
        return $form->persist();
    });
});

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::resource('photo/category', 'PhotoCategoriesController');

});
