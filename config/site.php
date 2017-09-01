<?php

return [
    'manage' => env('SITE_MANAGE', 'manage'),
    'except_route' => [
        'manage',
        'manage_plugin_example',
        'manage_plugin_search',
        'user_plugin_testuser',
    ],
    'language' => 'zh-ch',
];
