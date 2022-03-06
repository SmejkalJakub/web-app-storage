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
    return view('home');
})->name('home');

Route::post('/edit/save', 'FileEditController@save_edit')->name('file.edit.save');

Route::get('/edit/generate/link/{file_id}/{admin_id}', 'FileEditController@new_link')->name('file.new.link');
Route::get('/edit/generate/admin/{file_id}/{admin_id}', 'FileEditController@new_admin_link')->name('file.new.admin.link');

Route::post('upload', 'FileController@upload_file')->name('upload.file');
Route::get('/download/{file_link}', 'FileDownloadController@download')->name('file.download');
Route::get('/delete/{file_link}', 'FileController@delete_file')->name('file.delete');

Route::get('/{file_link}', 'FileViewController@view_file')->name('file.view');
Route::get('/{file_id}/{admin_id}', 'FileViewController@view_file_admin')->name('file.view.admin');

