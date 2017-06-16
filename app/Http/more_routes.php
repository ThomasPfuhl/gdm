<?php

Route::get('proposals', 'ProposalsController@index');
Route::get('proposal/{slug}', 'ProposalsController@show');
Route::get('proposals/data', 'ProposalsController@data');
