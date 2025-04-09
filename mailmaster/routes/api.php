<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SubscriberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes d'authentification
Route::post('/register', 'AuthController@register');    
Route::post('/login', 'AuthController@login');          
Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');  

// Routes pour les abonnés 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/subscribers', 'SubscriberController@store');
    Route::get('/subscribers', 'SubscriberController@index');
    Route::get('/subscribers/{id}', 'SubscriberController@show');
    Route::put('/subscribers/{id}', 'SubscriberController@update');
    Route::delete('/subscribers/{id}', 'SubscriberController@destroy');
});

// Routes pour les newsletters 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/newsletters', 'NewsletterController@store');
    Route::get('/newsletters', 'NewsletterController@index');
    Route::get('/newsletters/{id}', 'NewsletterController@show');
    Route::put('/newsletters/{id}', 'NewsletterController@update');
    Route::delete('/newsletters/{id}', 'NewsletterController@destroy');
});

// Routes pour les campagnes 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/campaigns', 'CampaignController@store');
    Route::get('/campaigns', 'CampaignController@index');
    Route::get('/campaigns/{id}', 'CampaignController@show');
    Route::put('/campaigns/{id}', 'CampaignController@update');
    Route::delete('/campaigns/{id}', 'CampaignController@destroy');
});







