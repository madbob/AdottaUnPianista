<?php

Route::get('/', function () {
        return redirect(url('/home'));
});

Route::get('/home', 'CommonController@home');

Route::get('/register/activate/{token}', 'Auth\RegisterController@activate');
Route::post('/prenotazione/rimuovi-partecipante', 'BookingController@removeAttendee');
Route::post('/prenotazione/aggiungi-partecipante', 'BookingController@addAttendee');
Route::post('/slot/mail', 'SlotController@sendMail');
Route::get('/slot/{id}/print', 'SlotController@printable');
Route::get('/evento/{id}/foto/{name}', 'EventController@getPhoto');
Route::post('/evento/{id}/foto', 'EventController@postPhoto');
Route::delete('/evento/{id}/foto/{name}', 'EventController@deletePhoto');

Route::resource('/user', 'UserController');
Route::resource('/evento', 'EventController');
Route::resource('/slot', 'SlotController');
Route::resource('/prenotazione', 'BookingController');
Route::resource('/adozione', 'AdoptionController');

Auth::routes();
