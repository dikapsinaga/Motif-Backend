<?php

// $disk = \Storage::disk('gcs');
// $disk->put('hola.txt', "hola hola");

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

Route::get('/admin/login', 'Api\Admin\AdminController@showLoginForm');
Route::post('/admin/login', 'Api\Admin\AdminController@login');

Route::group(['prefix' => 'admin'],function ()
{
    Route::post('/logout','Api\Admin\AdminController@logout');
    Route::get('/home', 'Api\Admin\AdminController@showHome');    
    Route::get('/berita', 'Api\Admin\AdminController@showBerita');
    Route::get('/berita/addBeritaForm', 'Api\Admin\AdminController@addBeritaForm');
    Route::post('/berita/addBerita', 'Api\Admin\AdminController@addBerita');
    Route::get('/berita/showDetails/{id}', 'Api\Admin\AdminController@showDetails');
    Route::get('/berita/editForm/{id}', 'Api\Admin\AdminController@showDetails');
    Route::post('/berita/edit/{id}', 'Api\Admin\AdminController@update');
    Route::get('/berita/deleteForm/{id}', 'Api\Admin\AdminController@showDetails');
    Route::delete('/berita/delete/{id}', 'Api\Admin\AdminController@delete');


    // produk belum dibayarkan
    Route::get('/pembayaran/barang/notPaid', 'Api\Admin\AdminController@showPembayaranProdukNotPaid');

    // produk belum dikonfirmasi
    Route::get('/pembayaran/barang/notConfirmed', 'Api\Admin\AdminController@showPembayaranProdukNotConfirmed'); 
    Route::get('/pembayaran/barang/confirmed/{id}', 'Api\Admin\AdminController@konfirmasiPembayaranProduk'); 

    //produk diproses
    Route::get('/pembayaran/barang/diproses', 'Api\Admin\AdminController@showPesananProdukDiproses'); 
    
    // produk dikirim
    Route::get('/pembayaran/barang/dikirim', 'Api\Admin\AdminController@showPesananProdukDikirim'); 
    
    // getList
    Route::get('/pembayaran/barang/getList/{id}', 'Api\Admin\AdminController@getListProduk');


    Route::get('/pembayaran/investasi/notPaid', 'Api\Admin\AdminController@showPembayaranInvestasiNotPaid');
    Route::get('/pembayaran/investasi/notConfirmed', 'Api\Admin\AdminController@showPembayaranInvestasiNotConfirmed');
    Route::get('/pembayaran/investasi/diproses', 'Api\Admin\AdminController@showPembayaranInvestasiDiproses');


    Route::get('/pembayaran/investasi/getList/{id}', 'Api\Admin\AdminController@getListInvestasi');

    Route::get('/pembayaran/investasi/confirmed/{id}', 'Api\Admin\AdminController@konfirmasiPembayaranInvestasi'); 

    
    Route::get('/pembayaran/investasi/hasil/notPaid', 'Api\Admin\AdminController@showPembayaranHasilInvestasiNotPaid');
    Route::get('/pembayaran/investasi/hasil/notConfirmed', 'Api\Admin\AdminController@showPembayaranHasilInvestasiNotConfirmed');
    Route::get('/pembayaran/investasi/hasil/diproses', 'Api\Admin\AdminController@showPembayaranHasilInvestasiDiproses');


    Route::get('/pembayaran/investasi/hasil/getStatus/{id}', 'Api\Admin\AdminController@getStatusInvestasi');
    
    Route::get('/pembayaran/investasi/hasil/confirmed/{id}', 'Api\Admin\AdminController@konfirmasiPembayaranHasilInvestasi'); 

    
    
    
    
    
    




    










});
