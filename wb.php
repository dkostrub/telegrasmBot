<?php

const TOKEN = '570281200:AAGF3hdXo3oSJpzHkRIfOUlGkQvVembmZOc';
$method = 'setWebhook';

$url = 'https://api.telegram.org/bot'.TOKEN.'/'.$method;

$options = ['url' => 'https://dinnerbotnoti.herokuapp.com/index.php'];
$response = file_get_contents($url . '?' . http_build_query($options));

var_dump($response);