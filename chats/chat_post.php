<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!


   // если пользователь не залогинен, переадресация на user_login.php
   // из базы данных достаем все данные о пользователе и формируем путь к файлу $photo_src


    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: ../user/user_login.php");}

	if ((isset($_SESSION['SSID'])) and (isset($_SESSION['BSSID']))) {
	$ssid = $_SESSION['SSID'];
	$bssid = $_SESSION['BSSID'];
	$wifiID = $ssid.$bssid;
	} else {header("Location: ../index.php");}
		
	
    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    //если это не так, то просто измените путь 

    if (isset($_SESSION['userID'])) {$userID = $_SESSION['userID'];}
    //if (isset($_POST['userID'])) {$userID = $_POST['userID']; $_SESSION['userID']= $_POST['userID']; }
    $query = "SELECT * FROM people WHERE userID='$userID'";
    $result = mysqli_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = mysqli_fetch_array($result);
    
    //используем значения для отображения на сайте, например  в тегах php -  echo $myrow['name'] 
	
     $userID = $myrow['userID'];
     $email = $myrow['email'];
     $name = $myrow['name'];
     $password = $myrow['password'];
     $photo = $myrow['photo'];
     
     $photo_src = "../crop/user_photos/" . $photo . ".png";
	 
	 
	 
     // если сообщение отослано вписываем его в базу данных
     if (isset($_POST['text'])){
     // получаем и обрабатываем имя и текст cсообщения
     $message = addslashes(htmlspecialchars($_POST['text'], ENT_QUOTES));
     // генерируем сегодняшную дату
     $time = date("d.m.y H:i");

     // если пользователь ввел текст сообщения, то добавляем все это в базу данных
     if($message != "")
     {
     // если запрос выполнен удачно, то выводим собщение "Сообщение отправлено." 
     $result = mysqli_query($db, "INSERT INTO publicChat 
	(userID, name, photo, message, time, SSID, BSSID, wifiID ) 
	VALUES ('{$userID}', '{$name}', '{$photo}', '{$message}', '{$time}', '{$ssid}', '{$bssid}', '{$wifiID}')");  
	
     if (!$result){
        echo "<center><a href='../chat.php'>error, please send the message later</a></center>";
          }
     }
     }


?>






