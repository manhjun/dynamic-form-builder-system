<?php

use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('forms/active', [SubmissionController::class, 'activeForms']);

// Form Management
Route::apiResource('forms', FormController::class);

// Field Management
Route::post('forms/{form}/fields', [FieldController::class, 'store']);
Route::put('forms/{form}/fields/{field}', [FieldController::class, 'update']);
Route::delete('forms/{form}/fields/{field}', [FieldController::class, 'destroy']);

// Submission
Route::post('forms/{form}/submit', [SubmissionController::class, 'submit']);
Route::get('submissions', [SubmissionController::class, 'index']);
