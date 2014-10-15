<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', array('as' => 'index', 'uses' => 'AlbumsController@getList'));
// Route::get('/createAlbum', array('as' => 'create_album_form', 'uses' => 'AlbumsController@getForm'));
// Route::post('/createAlbum', array('as' => 'create_album', 'uses' => 'AlbumsController@postCreate'));
// Route::get('/deleteAlbum/{id}', array('as' => 'delete_album', 'uses' => 'AlbumsController@getDelete'));
// Route::get('/album/{id}', array('as' => 'show_album', 'uses' => 'AlbumsController@getAlbum'));

// Route::get('addImage/{id}', array('as' => 'add_image', 'uses' => 'ImagesController@getForm'));
// Route::post('addImage', array('as' => 'add_image_to_album', 'uses' => 'ImagesController@postAdd'));
// Route::get('deleteImage/{id}', array('as' => 'delete_image', 'uses' => 'ImagesController@getDelete'));

// Route::post('moveImage', array('as' => 'move_image', 'uses' => 'ImagesController@postMove'));

Route::controller('/', 'GalleryController');
