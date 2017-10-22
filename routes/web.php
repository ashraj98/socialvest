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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/webapp', 'HomeController@webapp')->name('webapp');
Route::post('/capitalone/create', 'UserController@createNewCapitalOneCustomer')->name('user.newCO');
Route::post('/purchase/shares', 'UserController@purchaseShares')->name('user.purchase.shares');

Route::post('/transactions/map', 'TransactionController@index')->name('transactions.map');
Route::get('/transactions/latest', 'TransactionController@latest')->name('transactions.latest');

Route::get('/user/positions', 'UserController@positions')->name('user.positions');