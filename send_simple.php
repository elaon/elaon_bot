<?php 

if (!isset($_REQUEST)) { 
  return; 
} 

$confirmation_token = 'd5c51871'; 

$token = 'd54cf8f36e3e58907d282255db61dc9e62349e69f9d68516c1fbebea44a4d607be0534ecdf71ab3d65123'; 

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