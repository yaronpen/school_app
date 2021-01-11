<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\User;


Route::namespace('user')->group(function() {
  Route::prefix('create')->group(function() {
    Route::post('/teacher', 'TeacherController@create');
    Route::post('/student', 'StudentController@create');
  });

  Route::post('/login', 'LoginController@login');

  Route::prefix('update')->middleware('auth')->group(function() {
    Route::post('/teacher', 'TeacherController@update');
    Route::post('/student', 'StudentController@update');
  });

  Route::prefix('delete')->middleware('auth')->group(function() {
    Route::delete('/teacher', 'TeacherController@delete');
    Route::delete('/student', 'StudentController@delete');
  });

});

Route::namespace('Periods')->group(function() {
  Route::prefix('period')->middleware('auth')->group(function() {
    Route::post('/add', 'PeriodController@create');
    Route::post('/update/{id}', 'PeriodController@update');
    Route::delete('/delete/{id}', 'PeriodController@delete');

    Route::post('/assign', 'PeriodController@assignStudent');
    Route::post('/remove', 'PeriodController@removeStudent');
  });
});

//data requests
Route::middleware('auth')->group(function() {
  Route::get('/GetStudentPeriods/{id}', 'GetDataController@getStudentsPeriod');
  Route::get('/GetTeacherPeriods/{id}', 'GetDataController@getTeachersPeriod');
  Route::get('/GetStudentsByTeacher/{id}', 'GetDataController@GetStudentsByTeacher');
});
