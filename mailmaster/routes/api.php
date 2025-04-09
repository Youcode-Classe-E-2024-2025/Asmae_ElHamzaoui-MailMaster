<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\SubscriberController;

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



Route::prefix('campaigns')->group(function () {
    Route::get('/', [CampaignController::class, 'index']); // Liste de toutes les campagnes
    Route::post('/', [CampaignController::class, 'store']); // Créer une nouvelle campagne
    Route::get('{id}', [CampaignController::class, 'show']); // Afficher une campagne spécifique
    Route::put('{id}', [CampaignController::class, 'update']); // Mettre à jour une campagne
    Route::delete('{id}', [CampaignController::class, 'destroy']); // Supprimer une campagne
});



Route::prefix('newsletters')->group(function () {
    Route::get('/', [NewsletterController::class, 'index']); // Liste de toutes les newsletters
    Route::post('/', [NewsletterController::class, 'store']); // Créer une nouvelle newsletter
    Route::get('{id}', [NewsletterController::class, 'show']); // Afficher une newsletter spécifique
    Route::put('{id}', [NewsletterController::class, 'update']); // Mettre à jour une newsletter
    Route::delete('{id}', [NewsletterController::class, 'destroy']); // Supprimer une newsletter
});



Route::prefix('subscribers')->group(function () {
    Route::get('/', [SubscriberController::class, 'index']); // Liste de tous les abonnés
    Route::post('/', [SubscriberController::class, 'store']); // Ajouter un nouvel abonné
    Route::get('{id}', [SubscriberController::class, 'show']); // Afficher un abonné spécifique
    Route::put('{id}', [SubscriberController::class, 'update']); // Mettre à jour un abonné
    Route::delete('{id}', [SubscriberController::class, 'destroy']); // Supprimer un abonné
});
