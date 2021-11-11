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

Route::post('deconnexion', 'Auth\LoginController@logout')->name('logout');
Route::middleware('guest')->group(function () {
    Route::prefix('connexion')->group(function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Auth\LoginController@login');
    });
    Route::prefix('inscription')->group(function () {
        Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('/', 'Auth\RegisterController@register');
    });
});
Route::prefix('passe')->group(function () {
    Route::get('renouvellement', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('renouvellement/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('renouvellement', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Route::name('produits.show')->get('produits/{produit}', 'ProductController');
Route::resource('panier', 'CartController')->only(['index', 'store', 'update', 'destroy']);

// Utilisateur authentifié
Route::middleware('auth')->group(function ()
{
    // Commandes
    Route::prefix('commandes')->group(function ()
    {
        Route::resource('/', 'OrderController')->names(['create' => 'commandes.create','store' => 'commandes.store',])->only(['create', 'store']);
        Route::name('commandes.details')->post('details', 'DetailsController');
    });
});

Route::get('/', 'HomeController@index')->name('home');

