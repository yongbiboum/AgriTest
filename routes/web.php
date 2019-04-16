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

Route::get('/', function(){
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/client', function(){
    echo "Hello Admin";
})->middleware('auth','admin');


Route::match( array( 'GET', 'POST' ), 'categories/{code}', array(
    'as' => 'agriext_categories',
    'uses' => 'CatalogController@categoriesAction'
));
Route::match( array( 'GET', 'POST' ), '/myaccount', array(
    'as' => 'aimeos_shop_account',
    'uses' => 'AccountController@indexAction'
))->middleware('auth','client');

Route::match( array( 'GET', 'POST' ), '/myprodaccount', array(
    'as' => 'producteur_account',
    'uses' => 'ProdAccountController@indexAction'
))->middleware('auth','producteur');


Route::match( array( 'GET', 'POST' ), '/controlaccount', array(
    'as' => 'control_account',
    'uses' => 'ControlAccountController@indexAction'
))->middleware('auth','controleur');

Route::get('test-send-email',function(){
 \Illuminate\Support\Facades\Notification::route('mail','steveyong4@gmail.com')->notify(new \App\Notifications\TestEmailNotification() );
});


