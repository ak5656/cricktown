<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;



Route::get('/', function () {
    return view('welcome');
});




Route::get('matchComm/{matchid?}', [ApiController::class, 'matchComm']);
Route::get('matchScoreCard/{matchid?}', [ApiController::class, 'matchScoreCard']);

