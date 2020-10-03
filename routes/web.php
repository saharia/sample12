<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('routers','RouterController');

Route::get('telnet', 'RouterController@telnet');
Route::get('ssh', 'RouterController@ssh');
Route::get('files', 'RouterController@getFiles');
Route::get('copyFiles', 'RouterController@copyFiles');
Route::get('diskfreeSpace', 'RouterController@diskFreeSpace');


Route::get('fileExtract', 'RouterController@fileExtract');

Route::get('/canvas', function()
{
    $img = Image::canvas(300, 200, '#ddd');

    

    $img1 = Image::canvas(300, 200);
    $img1->circle(100, 150, 100, function ($draw) {
      $draw->border(1, '000000');
    });

    $img->insert($img1);

    $img3 = Image::canvas(300, 200);
    // define polygon points
    $points = array(
      80,  30,  // Point 1 (x, y)
      220,  30, // Point 2 (x, y)
      250, 100,
      220, 170,
      80, 170,
      50, 100
    );

    // draw a filled blue polygon with red border
    $img3->polygon($points, function ($draw) {
      $draw->border(1, '#ff0000');
    });

    $img->insert($img3);

    $img_0 = Image::canvas(210, 210);
    // draw a filled blue circle
    // draw an empty circle with 5px border
    $img_0->rectangle(120, 60, 160, 100, function ($draw) {
      $draw->border(1, '#000');
    })->rotate(45);
    
    $img->insert($img_0);

    return $img->response('jpg');
});

Route::get('/home', 'HomeController@index')->name('home');
