<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\IptcController;
use App\Http\Controllers\GpsController;

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
// Route::get('softDelete', function () {
//     post::find(5)->delete();
// });
Route::get('/', 'GpsController@index');
Route::get('test', function () {
    return view('addmetadata');
});
Route::get('test1', function () {
    return view('test1');
});

Route::get('getiptc', function () {
    return view('iptcmeta');
});
Route::get('exif', function () {
    return view('exif');
});
// Route::get('admin_panel', function () {
//     return view('admin')->middleware('authenticated');
// });

Auth::routes();
Route::get('admin/pannel/admin','TodoController@dashboardcountdata')->name('admin_panel')->middleware('authenticated');
Route::get('/home', 'HomeController@index')->name('home');
// Route::get('admin_panel', 'TodoController@edit');
// Route::get('todo_show', 'TodoController@index')->middleware('authenticated');
Route::post('todo_delete', 'TodoController@destroy');
// Route::post('soft_delete', 'TodoController@softdelete');




// Route::get('searchData','TodoController@search');





Route::get('Deleted/data/show', 'TodoController@deleteddata')->name('deleted');


Route::get('rowData','TodoController@rowfilter')->name('getRowData');
Route::get('searchuserData','TodoController@index')->name('searchuserData');
Route::post('get_image', 'IptcController@get_image')->name('get_image');
Route::post('get_iptc', 'IptcController@get_iptcdata')->name('get_iptcdata');
Route::post('edit_iptc', 'IptcController@edit_iptcdata')->name('edit_iptcdata');

Route::get('exifalldata', 'GpsController@index')->name('exifalldata');
Route::get('add_lat_long', 'GpsController@addGpsInfo')->name('addLatLong');
Route::post('upload_image', 'GpsController@upload_image')->name('upload_image');
Route::post('addmetadata', 'GpsController@addGpsInfo')->name('addmetadata');
Route::post('editmetadata', 'GpsController@editGpsInfo')->name('editmetadata');
Route::post('get_Exif', 'GpsController@get_exifdata')->name('get_exifdata');
Route::get('edit_Exif/{id?}', 'GpsController@edit_exifdata')->name('edit_exifdata');
Route::post('addmeta_tag', 'GpsController@addmetatag')->name('addmetatag');



Route::get('testconfig','GpsController@testconfig')->name('test');
Route::get('testlatlong', 'GpsController@get_latlon')->name('get_latlon');