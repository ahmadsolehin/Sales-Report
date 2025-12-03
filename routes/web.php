<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('report.index');
});

Route::get('/report',        [ReportController::class, 'index'])->name('report.index');
Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
Route::get('/report/data',   [ReportController::class, 'data'])->name('report.data');
