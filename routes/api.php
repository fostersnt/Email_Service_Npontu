<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Email\TransactionalController;
use App\Http\Controllers\Email\CampaignController;
use Faker\Guesser\Name;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//The route group below is mainly for all the action methods in TransactionController class
Route::controller(TransactionalController::class)->group(function(){
    route::post('transactional-email', 'sendTransactionalEmail')->name('transactional-email');
});

//The route group below is mainly for all the actions in the CampaignController class
Route::controller(CampaignController::class)->group(function(){
    route::post('create-campaign-email', 'createCampaignEmail')->name('create-campaign-email');
    route::post('send-campaign-email', 'sendCampaignEmail')->name('send-campaign-email');
    route::get('get-campaign-emails', 'getCampaignEmails')->name('get-campaign-emails');
    route::get('get-single-campaign-email/{campaignId}', 'getSingleCampaignEmail')->name('get-single-campaign-email');
    ROUTE::delete('delete-campaign-email/{campaignId}', 'deleteCampaignEmail')->name('delete-campaign-email');
});