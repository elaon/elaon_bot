<?php 

if (!isset($_REQUEST)) { 
  return; 
} 

//Строка для подтверждения адреса сервера из настроек Callback API 
$confirmation_token = 'd5c51871'; 

//Ключ доступа сообщества 
$token = 'ba7b4a4d0264aedb7d68a8544c59b9271fd9e57ac3983efd0d21774ac787a01c1c8caa0ed98200013d740'; 

//Получаем и декодируем уведомление 
$data = json_decode(file_get_contents('php://input')); 

//Проверяем, что находится в поле "type" 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса сервера... 
  case 'confirmation': 
    //...отправляем строку для подтверждения адреса 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case 'message_new': 
    //...получаем id его автора 
    $user_id = $data->object->user_id; 
    //затем с помощью users.get получаем данные об авторе 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 

//и извлекаем из ответа его имя 
    $user_name = $user_info->response[0]->first_name;
	$last_name = $user_info->response[0]->last_name;
	
//Получаем текст сообщения
    $body = $data->object->body;
//Массив с ответами
    $otv = array(
	'Привет' =>'Здравствуйте! Я официальный бот ELTe Team.' ,
	'Помощь' =>'Все доступные команды : О боте - Бот расскажет о себе',
	'О боте' => 'Версия бота 1.8'
	);
//Генерируем ответное сообщение, путем обращения к массиву с ответами
    $message = $otv[$body];

//С помощью messages.send и токена сообщества отправляем ответное сообщение 
    $request_params = array( 
      'message' => $message, 
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.0' 
    ); 

$get_params = http_build_query($request_params); 

file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 

//Возвращаем "ok" серверу Callback API 
    echo('ok'); 

break; 
} 
?> 