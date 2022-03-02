<?php

use Asadbek\Eimzo\Http\Controllers\EimzoController;
use Asadbek\Eimzo\Http\Controllers\EimzoSignController;

Route::group([
    'middleware' => 'web',
    'prefix' => 'eimzo',
    'as' => 'eimzo.',
    'namespace' => 'Asadbek\Eimzo\Http\Controllers'
], function () {
    Route::get('login', [EimzoController::class,'index'])->name('showLogin');
    Route::post('postLogin', [EimzoController::class,'auth'])->name('postLogin');
    Route::get('sign', [EimzoSignController::class, 'index'])->name('sign.index');
    Route::get('sign', [EimzoSignController::class, 'index'])->name('sign.index');

});
