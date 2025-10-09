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

//\Mail::raw('Hallo apa kabar', function($message){
//        $message->to('novan.abdilah@ocbd.co.id', 'Novan Abdilah');
//        $message->subject('NOTIFIKASI ABSEN');
//    });

Route::get('kirimemail', function(){
    \Mail::raw('Hallo apa kabar SHE', function($message){
        $message->to('novanokkey@gmail.com', 'Novan Abdilah');
        $message->subject('NOTIFIKASI SHE');
    });
});


Route::get('/', 'responden\RespondenController@index');
Route::get('/responden', 'responden\RespondenController@index_1')->name('responden.bisnis');
Route::post('/responden/simpan', 'responden\RespondenController@simpanresponden')->name('responden.simpanresponden');
//Route::get('ip_details', 'responden\RespondenController@ip_details');


Route::get('/pertanyaan1/{email}', 'responden\RespondenController@pertanyaan1')->name('responden.pertanyaan1');
Route::post('/pertanyaan1/simpan', 'responden\RespondenController@simpanpertanyaan1')->name('responden.simpanpertanyaan1');
Route::get('/pertanyaan2/{email}', 'responden\RespondenController@pertanyaan2')->name('responden.pertanyaan2');
Route::post('/pertanyaan2/simpan', 'responden\RespondenController@simpanpertanyaan2')->name('responden.simpanpertanyaan2');
Route::get('/pertanyaan3/{email}', 'responden\RespondenController@pertanyaan3')->name('responden.pertanyaan3');
Route::post('/pertanyaan3/simpan', 'responden\RespondenController@simpanpertanyaan3')->name('responden.simpanpertanyaan3');
Route::get('/pertanyaan4/{email}', 'responden\RespondenController@pertanyaan4')->name('responden.pertanyaan4');
Route::post('/pertanyaan4/simpan', 'responden\RespondenController@simpanpertanyaan4')->name('responden.simpanpertanyaan4');
Route::get('/pertanyaan5/{email}', 'responden\RespondenController@pertanyaan5')->name('responden.pertanyaan5');
Route::post('/pertanyaan5/simpan', 'responden\RespondenController@simpanpertanyaan5')->name('responden.simpanpertanyaan5');

Route::get('/selesai', 'responden\RespondenController@selesai')->name('responden.selesai');



Route::get('/dashboard', 'admin\DashboardController@index')->name('admin.dashboard');

Route::get('/dataresponden', 'admin\RespondenController@index')->name('admin.responden');
Route::delete('/dataresponden/hapus/{id}','admin\RespondenController@destroy')->name('admin.responden.hapus');
Route::get('/dataresponden/detail/{id_responden}', 'admin\RespondenController@showdetailresponden')->name('admin.detail.responden');

Route::get('/chart1', 'admin\GrafikNewController@grafik1')->name('admin.grafik.grafik1');
Route::get('/chart2', 'admin\GrafikNewController@grafik2')->name('admin.grafik.grafik2');
Route::get('/chart3', 'admin\GrafikNewController@grafik3')->name('admin.grafik.grafik3');
Route::get('/chart4', 'admin\GrafikNewController@grafik4')->name('admin.grafik.grafik4');
Route::get('/chart5', 'admin\GrafikNewController@grafik5')->name('admin.grafik.grafik5');
Route::get('/chart6', 'admin\GrafikNewController@grafik6')->name('admin.grafik.grafik6');

Route::get('/export', 'admin\RespondenController@export')->name('admin.export');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
