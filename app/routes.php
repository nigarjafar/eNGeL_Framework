<?php

Route::get("user/where/<name>/<id>","UserController@get_where");
Route::get("user/model","UserController@get_model");
Route::get("user/company/<id>","UserController@get_profile");
Route::get("user/company","UserController@get_company");
Route::get("paginate","UserController@paginate");

Route::get("user/test","UserController@get_test");
Route::put("user/test","UserController@put_test");
Route::delete("user/test","UserController@delete_test");
Route::post("user/test","UserController@post_test");
Route::patch("user/test","UserController@patch_test");
Route::options("user/test","UserController@options_test");
