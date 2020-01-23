<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/pelapak/register', 'Api\Pelapak\AuthController@register');
Route::post('/pelapak/login', 'Api\Pelapak\AuthController@login');

Route::group(['prefix' => 'pelapak'],function ()
{
    Route::post('/demo','Api\Pelapak\AuthController@demo');
    Route::post('/logout','Api\Pelapak\AuthController@logout');
    
    Route::get('/berita','Api\Pelapak\BeritaController@index');
    Route::get('/berita/{id}','Api\Pelapak\BeritaController@show');
    

    Route::post('/profile/update', 'Api\Pelapak\PelapakController@updateProfile');
    
    Route::get('/produk', 'Api\Pelapak\ProdukController@index');
    Route::post('/produk/create', 'Api\Pelapak\ProdukController@create');
    Route::get('/produk/{id}', 'Api\Pelapak\ProdukController@show');
    Route::post('/produk/update/{id}', 'Api\Pelapak\ProdukController@update');
    Route::post('/produk/update/foto/{id}', 'Api\Pelapak\ProdukController@changeFoto');
    Route::delete('/produk/delete/{id}', 'Api\Pelapak\ProdukController@delete');

    Route::get('/plan', 'Api\Pelapak\PlanController@index');
    Route::post('/plan/create', 'Api\Pelapak\PlanController@create');
    Route::get('/plan/{id}', 'Api\Pelapak\PlanController@show');
    Route::post('/plan/update/{id}', 'Api\Pelapak\PlanController@update');
    Route::post('/plan/update/foto/{id}', 'Api\Pelapak\PlanController@changeFoto');
    Route::delete('/plan/delete/{id}', 'Api\Pelapak\PlanController@delete');
    Route::post('/plan/bayar/{id}', 'Api\Pelapak\PlanController@bayarPlan');

    Route::get('/plan/progress/{id}', 'Api\Pelapak\ProgressController@index');
    Route::post('/plan/progress/create/{id}', 'Api\Pelapak\ProgressController@create');

    Route::get('/plan/investor/{id}', 'Api\Pelapak\PlanController@showInvestor');

    // Route::get('/plan/progress/{id}', 'Api\Pelapak\ProgressController@show');

    Route::get('/order/produk', 'Api\Pelapak\OrderBarangController@index');
    Route::post('/order/produk/update/resi/{id}', 'Api\Pelapak\OrderBarangController@updateResi');

    // Route::post('/pembelian/produk/create/{id}', 'Api\Pembeli\PembelianBarangController@create');
    // Route::get('/pembelian/produk/{id}', 'Api\Pembeli\PembelianBarangController@show');
    // Route::post('/pembelian/produk/upload/{id}', 'Api\Pembeli\PembelianBarangController@uploadBuktiPembayaran');

});


Route::post('/pembeli/register', 'Api\Pembeli\AuthController@register');
Route::post('/pembeli/login', 'Api\Pembeli\AuthController@login');

Route::group(['prefix' => 'pembeli'],function ()
{
    Route::post('/demo','Api\Pembeli\AuthController@demo');
    Route::post('/logout','Api\Pembeli\AuthController@logout');

    Route::get('/berita','Api\Pelapak\BeritaController@index');
    Route::get('/berita/{id}','Api\Pelapak\BeritaController@show');

    Route::post('/profile/update', 'Api\Pembeli\PembeliController@updateProfile');
    
    Route::get('/produk', 'Api\Pembeli\ProdukController@index');
    Route::get('/produk/{id}', 'Api\Pembeli\ProdukController@show');

    Route::get('/plan', 'Api\Pembeli\PlanController@index');
    Route::get('/plan/{id}', 'Api\Pembeli\PlanController@show');

    Route::get('/plan/progress/{id}', 'Api\Pembeli\ProgressController@index');


    // Route::get('/produk', 'Api\Pelapak\ProdukController@index');
    Route::get('/pembelian/investasi', 'Api\Pembeli\PembelianInvestasiController@index');
    Route::post('/pembelian/investasi/create/{id}', 'Api\Pembeli\PembelianInvestasiController@create');
    Route::get('/pembelian/investasi/{id}', 'Api\Pembeli\PembelianInvestasiController@show');
    Route::post('/pembelian/investasi/upload/{id}', 'Api\Pembeli\PembelianInvestasiController@uploadBuktiPembayaran');


    Route::get('/pembelian/produk', 'Api\Pembeli\PembelianBarangController@index');
    Route::post('/pembelian/produk/create/{id}', 'Api\Pembeli\PembelianBarangController@create');
    Route::get('/pembelian/produk/{id}', 'Api\Pembeli\PembelianBarangController@show');
    Route::post('/pembelian/produk/upload/{id}', 'Api\Pembeli\PembelianBarangController@uploadBuktiPembayaran');


    // Route::get('/produk/{id}', 'Api\Pelapak\ProdukController@show');
    // Route::post('/produk/update/{id}', 'Api\Pelapak\ProdukController@update');
    // Route::post('/produk/update/foto/{id}', 'Api\Pelapak\ProdukController@changeFoto');
    // Route::delete('/produk/delete/{id}', 'Api\Pelapak\ProdukController@delete');

    

});



Route::post('/admin/register', 'Api\Admin\AuthController@register');
Route::get('/admin/login', 'Api\Admin\AdminController@showLoginForm');
Route::post('/admin/login', 'Api\Admin\AdminController@login');


Route::group(['prefix' => 'admin'],function ()
{
    Route::post('/demo','Api\Admin\AuthController@demo');
    Route::post('/logout','Api\Admin\AuthController@logout');
    
    Route::post('/home','Api\Admin\AdminController@showHome');
    Route::get('/berita','Api\Admin\AdminController@showBerita');

    
});