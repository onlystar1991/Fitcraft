<?php

return [

    'multi' => [
        'admin' => [
            'driver' => 'eloquent',
            'model' => 'App\Models\Administrators',
        ],
        'client' => [
            'driver' => 'eloquent',
            'model' => 'App\Models\User',
        ]
    ],

    'password' => [
		'email' => 'emails.password',
		'table' => 'password_resets',
		'expire' => 50,
	],

];
