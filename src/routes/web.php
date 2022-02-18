<?php

use Asadbek\Eimzo\Http\Controllers\EimzoController;

Route::group([
    'middleware' => 'web',
    'prefix' => 'eimzo',
    'as' => 'eimzo.',
    'namespace' => 'Asadbek\Eimzo\Http\Controllers'
], function () {
    Route::get('login', [EimzoController::class,'index'])->name('showLogin');
    Route::post('postLogin', [EimzoController::class,'auth'])->name('postLogin');

});
