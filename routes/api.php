<?php

use App\Http\Controllers\IRedMailController;
use Illuminate\Http\Request;

Route::prefix('email')->group(function () {
    Route::post('/send', [IRedMailController::class, 'sendTestEmail'])->name('api.email.send');
    Route::post('/custom', [IRedMailController::class, 'sendCustomEmail'])->name('api.email.custom');
});
