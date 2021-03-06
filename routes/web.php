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

Route::get('/', 'HomeController@index')->name('index');

/**
 * Auth Routes
 * /login
 * /logout
 */
Auth::routes();

/**
 * Social Authentication OAuth Routes.
 */
Route::group(['prefix' => 'social'], function () {
    Route::get('/callback/{provider}', 'SocialAuthController@callback')->name('social.callback');
    Route::get('/redirect/{provider}', 'SocialAuthController@redirect')->name('social.redirect');
});


Route::group(['middleware' => ['auth', 'jwt.cookie']], function () {
    Route::get('/home', 'HomeController@home')->name('home');

    Route::get('/compose', 'AlertBuilderController@index')->name('builder');
    Route::post('/dispatch', 'AlertBuilderController@dispatchAlert')->name('dispatch');

    Route::group(['prefix' => 'verify'], function () {
        Route::get('/{token}', ['uses' => 'VerifyFrontEndController@verify', 'as' => 'get.verify.token']);
        Route::get('/', ['uses' => 'VerifyFrontEndController@verify', 'as' => 'get.verify']);
        Route::post('/', ['uses' => 'VerifyFrontEndController@verify', 'as' => 'send.verify.token']);
    });

});

