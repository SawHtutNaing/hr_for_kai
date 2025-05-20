<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DivisionManager;
use App\Livewire\BranchManager;
use App\Livewire\PayscaleManager;
use App\Livewire\OfficeRoleManager;
use App\Livewire\UserManager;
use App\Livewire\LeaveRequestManager;
use App\Livewire\AttendanceManager;
use App\Livewire\PayrollManager;

Route::middleware(['auth'])->group(function () {
    Route::get('/divisions', DivisionManager::class)->name('divisions');
    Route::get('/branches', BranchManager::class)->name('branches');
    Route::get('/payscales', PayscaleManager::class)->name('payscales');
    Route::get('/office-roles', OfficeRoleManager::class)->name('office-roles');
    Route::get('/users', UserManager::class)->name('users');
    Route::get('/leave-requests', LeaveRequestManager::class)->name('leave-requests');
    Route::get('/attendance', AttendanceManager::class)->name('attendance');
    Route::get('/payroll', PayrollManager::class)->name('payroll');
});

require __DIR__.'/auth.php';
