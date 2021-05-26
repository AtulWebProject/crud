<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
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
Route::get('todo_create', 'TodoController@create')->name('showData')->middleware('authenticated');
Route::get('todo_edit_data/{id}', 'TodoController@edit')->name('todo_edit')->middleware('authenticated');
Route::post('todo_submit', 'TodoController@store')->name('submit_data');
Route::post('todo_update/{id}', 'TodoController@update')->name('todo.update');
// Route::get('searchData','TodoController@search');
Route::get('searchuserData','TodoController@index')->name('searchuserData');
Route::get('dsearchuserData','TodoController@deletedsearch')->name('deletedsearchuserData');
Route::get('searchData','TodoController@examsearch');
Route::post('view/data','TodoController@viewdata')->name('todo_view');
Route::get('rowData','TodoController@rowfilter')->name('getRowData');
Route::get('deletedrowData','TodoController@deletedrowfilter')->name('deletedrowData');
Route::get('fetch_addeddata', 'TodoController@index')->name('alldata')->middleware('authenticated');
Route::get('fetch_userdata', 'HomeController@usersData')->middleware(['authenticated','can:isAdmin'])->name('userdata');



Route::get('fetch_userUpdatedData', 'TodoController@getusersData')->name('todo.getdata');

Route::get('export', 'TodoController@export')->name('export');
Route::post('/email/already', 'TodoController@Email_already')->name('check_email');
Route::get('Deleted/data/show', 'TodoController@deleteddata')->name('deleted');
Route::post('Deleted/data/show', 'TodoController@restore')->name('restore');
Route::post('pDeleted/data/show', 'TodoController@forcedelete')->name('forcedelete');
Route::post('active/data/show', 'TodoController@activeDactivateUser')->name('activeUser');
Route::post('dactive/data/show', 'TodoController@activeDactivateUser')->name('dactiveUser');
Route::post('changepassword/user.xamp', 'HomeController@changepassword')->name('changepassword');
Route::post('userProfile/changepass', 'HomeController@changeUser_password')->name('pass_change');
Route::post('userProfile/Image', 'HomeController@profile_Pic')->name('userImage');
Route::get('userProfile', 'HomeController@profile')->name('profile');
//http://localhost/laravel/blog/public/fetch_addeddata
//http://localhost/laravel/blog/public/todo_edit_data/fetch_addeddata