<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\UploadController;

Route::get('/', [FormationController::class, 'index'])->name('formations.index');

Route::prefix('formations')->group(function () {
    Route::get('/', [FormationController::class, 'index'])->name('formations.index');
    Route::get('create', [FormationController::class, 'create'])->name('formations.create');
    Route::post('store', [FormationController::class, 'store'])->name('formations.store');
    Route::get('{formation}/edit', [FormationController::class, 'edit'])->name('formations.edit');
    Route::post('{formation}/update', [FormationController::class, 'update'])->name('formations.update');
    Route::post('{formation}/destroy', [FormationController::class, 'destroy'])->name('formations.destroy');
    Route::post('{formation}/toggle-status', [FormationController::class, 'toggleStatus'])->name('formations.toggleStatus');
    
    Route::prefix('{formation}/participants')->group(function () {
        Route::get('/', [ParticipantController::class, 'index'])->name('formations.participants.index');
        Route::get('create', [ParticipantController::class, 'create'])->name('formations.participants.create');
        Route::post('store', [ParticipantController::class, 'store'])->name('formations.participants.store');
        Route::post('{participant}/destroy', [ParticipantController::class, 'destroy'])->name('formations.participants.destroy');
        Route::get('upload', [UploadController::class, 'index'])->name('formations.participants.upload');
        Route::post('upload', [UploadController::class, 'store'])->name('formations.participants.upload.store');
    });
});

Route::get('presence/scan/{formation}', [PresenceController::class, 'scan'])->name('presence.scan');
Route::post('presence/store/{formation}', [PresenceController::class, 'store'])->name('presence.store');
Route::get('attestations', [PresenceController::class, 'attestation'])->name('attestations.index');
Route::post('attestations/generate', [PresenceController::class, 'generateAttestation'])->name('attestations.generate');
