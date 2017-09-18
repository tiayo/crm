<?php
/**
 * 公用路由，前后台通用的主要功能路由放着里.
 */

Route::get('/captcha/{group}', 'CaptchaController@captcha')->name('captcha');

Route::get('/language/{locale}', function ($locale) {
    Request::session()->put('language', $locale);
    return redirect()->back();
})->name('language');

Route::get('/mailable', 'MailController@test');
