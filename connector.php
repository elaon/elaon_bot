<?php 

require_once "send_simple.php";

$confirmation_token = 'строка которую должен вернуть сервер';

$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) { 
  case 'confirmation':  
    echo $confirmation_token; 
    break;

break; 
} 
?>
