<?php 

require_once "send_simple.php";

$confirmation_token = 'd5c51871';

$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) { 
  case 'confirmation':  
    echo $confirmation_token; 
    break;

break; 
} 
?>