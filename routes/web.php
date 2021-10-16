<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees',['\App\Http\Controllers\EmployeeController','index'])->name('employee.index');

Route::get('/employees/lazyload',['\App\Http\Controllers\EmployeeController','lazyload'])->name('employee.lazyload');

Route::get('/employees/lazyload2',['\App\Http\Controllers\EmployeeController','lazyload2'])->name('employee.lazyload2');

Route::get('/employees/pagination',['\App\Http\Controllers\EmployeeController','ajaxPagination'])->name('employee.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/send', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('sendMessage');

Route::get('/fetch', [App\Http\Controllers\HomeController::class, 'fetchMessage'])->name('fetchMessage');

Route::get('/realtime-paginate-vue', [App\Http\Controllers\RealTimePaginate::class, 'index'])->name('realtimePaginate');

Route::get('/show-employee', [App\Http\Controllers\RealTimePaginate::class, 'showEmployee'])->name('showEmployee');

Route::get('/show-employee/page/{no}', [App\Http\Controllers\RealTimePaginate::class, 'changeNumber'])->name('changeNumber');

Route::post('/show-employee/search/', [App\Http\Controllers\RealTimePaginate::class, 'searchStudents'])->name('searchStudents');



// Route::get('sendEmail',function() {
//     // Mail::send(new SendEmailMailable());
// });