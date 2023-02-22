<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Email\TransactionalController;
use App\Http\Controllers\Email\CampaignController;

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

//The route group below is mainly for all the action methods in TransactionController class
Route::controller(TransactionalController::class)->group(function(){
    route::post('transactional-email', 'sendTransactionalEmail')->name('transactional-email');
});

//The route group below is mainly for all the actions in the CampaignController class
Route::controller(CampaignController::class)->group(function(){
    route::get('campaign-email', 'sendCampaignEmail')->name('campaign-email');
});