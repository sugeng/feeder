<?php
/**
 * Created By: Sugeng
 * Date: 2019-07-15
 * Time: 23:37
 */

Route::group(['prefix' => 'feeder'], function() {
    Route::get('tables', "FeederController@tables");
    Route::get('dictionary/{table}', "FeederController@dictionary");
    Route::get('records/{table}/{limit?}', "FeederController@records");
    Route::get('save', "FeederController@saveRecords");
});

Route::get('testi', function() {
    return "test";
});
