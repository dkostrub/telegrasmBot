<?php

const TOKEN = '570281200:AAGF3hdXo3oSJpzHkRIfOUlGkQvVembmZOc';
const BASE_URL = 'https://api.telegram.org/bot'.TOKEN.'/';

$update = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);

function sendRequest($method, $params = [])
{
    if(!empty($params)){
        $url = BASE_URL . $method . '?' . http_build_query($params);
    } else {
        $url = BASE_URL . $method;
    }

    return json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
}

$time = date('H:m:s');
$chat_id = $update['message']['chat']['id'];
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $time]);