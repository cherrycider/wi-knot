<?php 
   // этот файл регулярно подключается к базе и отображает всех людей online в people.php
	
	session_start();
    // вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!

	if ((isset($_SESSION['SSID'])) and (isset($_SESSION['BSSID']))) {
	$ssid = $_SESSION['SSID'];
	$bssid = $_SESSION['BSSID'];
	$wifiID = $ssid.$bssid;
	} else {header("Location: ../index.php");}

 	
    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    // если это не так, то просто измените путь 
	

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------	
    $query = "SELECT * FROM people WHERE wifiID='$wifiID'";
    $result = mysqli_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //fetch result
	//$array = mysqli_fetch_row($result);  

   /* выборка данных и помещение их в массив */
    while ($person = mysqli_fetch_row($result)) {
 
         $people[]=$person;

    }                       





  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
     echo json_encode($people);

?>
