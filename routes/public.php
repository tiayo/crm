<?php
/**
 * 公共路由，前后台通用的主要功能路由放着里
 *
 */

Route::get('/captcha/{group}', 'CaptchaController@captcha')->name('captcha');