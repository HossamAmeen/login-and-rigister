<?php


// Auth::routes();

        
Route::any('login', 'AuthController@login')->name('login');
Route::any('register', 'AuthController@register')->name('register');
Route::any('verify/{user_id}', 'AuthController@verify')->name('verify');
Route::get('home' , "AuthController@home")->name('home');
        
       
  