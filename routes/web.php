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
use App\Livewire\EmployeeDashboard;
use App\Livewire\HrDashboard;
use App\Livewire\ReportManager;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\LeaveRequestExportController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});


Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role->name === 'HR') {
            return redirect()->route('hr-dashboard');
        }
        return redirect()->route('employee-dashboard');
    })->name('dashboard');

    Route::get('/hr-dashboard', HrDashboard::class)->name('hr-dashboard');
    Route::get('/employee-dashboard', EmployeeDashboard::class)->name('employee-dashboard');
    Route::get('/divisions', DivisionManager::class)->name('divisions');
    Route::get('/branches', BranchManager::class)->name('branches');
    Route::get('/payscales', PayscaleManager::class)->name('payscales');
    Route::get('/office-roles', OfficeRoleManager::class)->name('office-roles');
    Route::get('/users', UserManager::class)->name('users');
    Route::get('/leave-requests', LeaveRequestManager::class)->name('leave-requests');
    Route::get('/attendance', AttendanceManager::class)->name('attendance');
    Route::get('/payroll', PayrollManager::class)->name('payroll');
    Route::get('/reports', ReportManager::class)->name('reports')->middleware('can:manage-hr');
    // Route::get('/reports/export', [ReportExportController::class, 'exportCsv'])->name('reports.export')->middleware('can:manage-hr');
      Route::get('/reports', ReportManager::class)->name('reports')->middleware('can:manage-hr');
// Optional: Keep this if you want to maintain the controller-based export as a fallback
Route::get('/reports/export', [ReportExportController::class, 'exportCsv'])->name('reports.export')->middleware('can:manage-hr');
    Route::get('/leave-requests/export', [LeaveRequestExportController::class, 'exportCsv'])->name('leave-requests.export')->middleware('can:manage-hr');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
require __DIR__.'/auth.php';
