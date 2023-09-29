<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('Dashboard_Admin',[\App\Http\Controllers\Dashboard\DashboardController::class,'index']);




Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){


    //User Dashboard
    Route::get('/dashboard/user', function () {
        return view('Dashboard.User.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard.user');


    //Admin Dashboard
    Route::get('/dashboard/admin', function () {
        return view('Dashboard.Admin.dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard.admin');

    //Doctor Dashboard
    Route::get('/dashboard/doctor', function () {
        return view('Dashboard.doctor.dashboard');
    })->middleware(['auth:doctor'])->name('dashboard.admin');

    Route::middleware(['auth:admin'])->group(function () {


        //Section
        Route::resource('Sections', \App\Http\Controllers\Dashboard\SectionController::class);

        //Doctor
        Route::resource('Doctors', \App\Http\Controllers\Dashboard\DoctorController::class);
        Route::post('update_password', [\App\Http\Controllers\Dashboard\DoctorController::class,'update_password'])->name('update_password');
        Route::post('update_status', [\App\Http\Controllers\Dashboard\DoctorController::class, 'update_status'])->name('update_status');

        //Service
        Route::resource('Service', \App\Http\Controllers\Dashboard\SingleServiceController::class);

        //GroupServices
        Route::view('Add_GroupServices','livewire.GroupServices.include_create')->name('Add_GroupServices');


        //Insurance
        Route::resource('insurance', \App\Http\Controllers\Dashboard\InsuranceController::class);

        //Ambulance
        Route::resource('Ambulance', \App\Http\Controllers\Dashboard\AmbulanceController::class);

        //Patients
        Route::resource('Patients', \App\Http\Controllers\Dashboard\PatientController::class);

        Route::view('single_invoices','livewire.single_invoices.index')->name('single_invoices');

        \Livewire\Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });








    });




    require __DIR__.'/auth.php';

});
