<?php

Route::get('/', function () {
        return redirect(url('/home'));
});

Route::get('/home', 'CommonController@home');

Route::post('/prenotazione/rimuovi-partecipante', 'BookingController@removeAttendee');
Route::post('/prenotazione/aggiungi-partecipante', 'BookingController@addAttendee');
Route::get('/register/activate/{token}', 'Auth\RegisterController@activate');

Route::resource('/user', 'UserController');
Route::resource('/evento', 'EventController');
Route::resource('/slot', 'SlotController');
Route::resource('/prenotazione', 'BookingController');
Route::resource('/adozione', 'AdoptionController');

Auth::routes();
