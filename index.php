<?php

header('Content-Type: text/html; charset=utf-8');

require_once("vendor/autoload.php");

// дебаг
if(true){
    error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED));
    ini_set('display_errors', 1);
}

const TOKEN = '570281200:AAGF3hdXo3oSJpzHkRIfOUlGkQvVembmZOc';
$bot = new \TelegramBot\Api\Client(TOKEN);
const BASE_URL = 'https://api.telegram.org/bot'.TOKEN.'/';

if($_GET["bname"] == "revcombot"){
    $bot->sendMessage("@DinnernotiBot", "Тест");
}

// если бот еще не зарегистрирован - регистируем
if(!file_exists("registered.trigger")){
    /**
     * файл registered.trigger будет создаваться после регистрации бота.
     * если этого файла нет значит бот не зарегистрирован
     */

    // URl текущей страницы
    $page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    $result = $bot->setWebhook($page_url);
    if($result){
        file_put_contents("registered.trigger",time()); // создаем файл дабы прекратить повторные регистрации
    } else die("ошибка регистрации");
}

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// Команды бота
// пинг. Тестовая
$bot->command('ping', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(), 'pong!');
});

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - помощ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// Кнопки у сообщений
$bot->command("ibutton", function ($message) use ($bot) {
    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
        [
            [
                ['callback_data' => 'data_test', 'text' => 'Answer'],
                ['callback_data' => 'data_test2', 'text' => 'ОтветЪ']
            ]
        ]
    );

    $bot->sendMessage($message->getChat()->getId(), "тест", false, null,null,$keyboard);
});

$bot->on(function($Update) use ($bot){
    $message = $Update->getMessage();
    $mtext = $message->getText();
    $cid = $message->getChat()->getId();

    if(mb_stripos($mtext,"власть советам") !== false){
        $bot->sendMessage($message->getChat()->getId(), "Смерть богатым!");
    }
}, function($message) use ($name){
    return true; // когда тут true - команда проходит
});

// запускаем обработку
$bot->run();






//$update = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);
//
//function sendRequest($method, $params = [])
//{
//    if(!empty($params)){
//        $url = BASE_URL . $method . '?' . http_build_query($params);
//    } else {
//        $url = BASE_URL . $method;
//    }
//
//    return json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
//}
//
//$time = date('H:m:s');
//$chat_id = $update['message']['chat']['id'];
//sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $time]);