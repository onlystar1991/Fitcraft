<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Mail Driver
	|--------------------------------------------------------------------------
	|
	| Laravel supports both SMTP and PHP's "mail" function as drivers for the
	| sending of e-mail. You may specify which one you're using throughout
	| your application here. By default, Laravel is setup for SMTP mail.
	|
	| Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "log"
	|
	*/

	'driver' => env('MAIL_DRIVER', 'mandrill'),
	'host' => env('MAIL_HOST', 'smtp.mandrillapp.com'),
	'port' => env('MAIL_PORT', 587),
	'from' => ['address' => 'info@fitcraft.io', 'name' => 'Fitcraft'],
	'to' => ['production'=>'hunami@fitcraft.io','development'=>'bukashk0zzz@gmail.com'],
	'encryption' => 'tls',
	'username' => env('MAIL_USERNAME', 'hunami@fitcraft.io'),
	'password' => env('MAIL_PASSWORD', 'zyQTlhgHdMKrhEmEdy4O1Q'),
	'sendmail' => '/usr/sbin/sendmail -bs',

	/*
	|--------------------------------------------------------------------------
	| Mail "Pretend"
	|--------------------------------------------------------------------------
	|
	| When this option is enabled, e-mail will not actually be sent over the
	| web and will instead be written to your application's logs files so
	| you may inspect the message. This is great for local development.
	|
	*/

	'pretend' => false,

];
