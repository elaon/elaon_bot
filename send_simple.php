<?php 

if (!isset($_REQUEST)) { 
  return; 
} 

$confirmation_token = 'строка которую должен вернуть сервер'; 

$token = 'ключ доступа сообщества с правами сообщения';

$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) { 
  case 'confirmation': 
    echo $confirmation_token; 
    break; 

  case 'message_new': 
    $user_id = $data->object->user_id; 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 

    $user_name = $user_info->response[0]->first_name; 
    $last_name = $user_info->response[0]->last_name; 

    $body = $data->object->body;
    $otv = array(
	'Привет' =>'Elaon Bot - интеллектуальный FAQ бот команды ELTe Team' , 
	'Помощь' =>'Все доступные команды : О - отобразит всю информацию о боте' , 
	'О' => 'Версия бота - 1.2 Beta'
	);
    $message = $otv[$body];


    $request_params = array( 
      'message' => $message, 
      'user_id' => $user_id, 
      'access_token' => $token 
    ); 
	
    $get_params = http_build_query($request_params); 


file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 

    echo('ok'); 

break; 
} 
?> 
