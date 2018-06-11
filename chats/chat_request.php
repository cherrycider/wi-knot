<?php 
   // этот файл регулярно подключается к базе и передает чаты текущей wifi сети в public_chat.php
	
	session_start();
    // вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!

	if ((isset($_SESSION['ssid'])) and (isset($_SESSION['bssid']))) {
	$ssid = $_SESSION['ssid'];
	$bssid = $_SESSION['bssid'];
	$wifiid = $ssid.$bssid;
	} else {header("Location: ../index.php");}

 	
    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    // если это не так, то просто измените путь 
	

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------	
    
    $query = "SELECT * FROM publicchat WHERE wifiid='$wifiid'";  
	//or select ALL chat:    
	//$query = "SELECT * FROM publicchat";
    $result = pg_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //fetch result
	//$array = pg_fetch_row($result);  

   /* выборка данных и помещение их в массив */
    while ($chat = pg_fetch_row($result)) {
 
         $chats[]=$chat;

    }                       



/*

	public static function getChats($lastID){
		$lastID = (int)$lastID;
	
		$result = DB::query('SELECT * FROM webchat_lines WHERE id > '.$lastID.' ORDER BY id ASC');
	
		$chats = array();
		while($chat = $result->fetch_object()){
			
			// Возвращаем время создания сообщения в формате GMT (UTC):
			
			$chat->time = array(
				'hours'		=> gmdate('H',strtotime($chat->ts)),
				'minutes'	=> gmdate('i',strtotime($chat->ts))
			);
			
			$chat->gravatar = Chat::gravatarFromHash($chat->gravatar);
			
			$chats[] = $chat;
		}  
	
		return array('chats' => $chats);
	}
	


*/
  

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
     echo json_encode($chats);

?>
