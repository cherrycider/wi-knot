<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!



   // если пользователь не залогинен, переадресация на user_login.php
   // из базы данных достаем все данные о пользователе и формируем путь к файлу $photo_src


    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: ../user/user_login.php");}

    // если имя wifi не установлено, редирект на страницу index.php
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
    if (isset($_POST['userID'])) {$userID = $_POST['userID']; $_SESSION['userID']= $_POST['userID']; }
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
	 
	 
	 
	 // если имеем присланное сообщение,  вписываем его в базу данных
    if (isset($_POST['message'])){
     // получаем и обрабатываем имя и текст комментария
     $message = addslashes(htmlspecialchars($_POST['message'], ENT_QUOTES));
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




<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>discuss this place</title>
	

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">


    <!-- AJAX PHP chat  -->
    <link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<!--   <link rel="stylesheet" type="text/css" href="css/page.css" />
    <link rel="stylesheet" type="text/css" href="css/chat.css" />
-->
	
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
	
      .knotbackground {
      background-image: url(../../images/restaurant-above-view-1920x756.jpg); /* Путь к фоновому изображению */
	    }
      .knotbackground {
	      position: fixed; /* Фиксированное положение */
	      left: 0; top: 0; bottom:0; right:0; 
       }

       .knotbackgroundsunglass {

       	position: fixed; /* Фиксированное положение 	*/
     	left: 0; top: 0; bottom:0; right:0; 

      }

     </style>
	 


  </head>

  
<body>







<!-- фон и затемнение вынесены и привязаны ко всем углам экрана -->

<div class="knotbackground">
<div class="knotbackgroundsunglass">
</div>
</div>



<!--левое меню --------------------------------------------------------------------------------- -->
  

<!-------Vertical buttons right (left) col ----------------->


<!--<div class= "vertical-menu-padding hidden-xs"> -->
<div class= "vertical-menu-padding">



  <!-- #vertical menu -->
     <?php
    include ("../menu_vertical.php");
    ?>
   



</div>
<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- контейнер -->
<div> <!-- тело -->





<div class = "knot-header"> 

<div class="ssid">

  <!-- #ssid header -->
     <?php
    include ("../ssid_header.php");
    ?>
   
    
</div>  <!-- "ssid" -->


</div>    <!-- "knot-header" -->



<div class="content">  <!-- CONTENT CONTENT -->

<div class="fixed-title"><h2>discuss this place</h2></div>
 <!--  сontent<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><-->




<div id="chatContainer" class="chat-area">

<!--    <div id="chatTopBar" class="rounded"></div> -->
    <div id="chatLineHolder" class="chatLineHolder"></div>
    
<!--    <div id="chatUsers" class="rounded"></div>  -->
    <div id="chatBottomBar" class="rounded send-form-padding">
<!--    	<div class="tip"></div>          -->
        
 <!--       <form id="loginForm" method="post" action="">
            <input id="name" name="name" class="rounded" maxlength="16" />
            <input id="email" name="email" class="rounded" />
            <input type="submit" class="blueButton" value="Login" />
        </form>
 -->       
        <form id="submitFormToMyself" method="post" action="public_chat.php">
 <!--             <input id="chatText" name="chatText" class="rounded" maxlength="255" />   --> 
			
			<input id="chatText" name="message" class="rounded" maxlength="255" />
			
            <input type="submit" class="blueButton" value="Send" />
        </form>
        
    </div>
    
</div>






</div>   <!-- CONTENT CONTENT -->




<!--нижнее  меню --------------------------------------------------------------------------------- -->
<div class="horizontal-menu-padding">  <!--<div class="horizontal-menu-padding visible-xs"> -->

<div class="horizontal-menu ">    <!-- #horizontal menu -->


 
     <?php
    include ("../menu_horizontal.php");
    ?>
   
  
</div>                             <!-- horizontal-menu -->
<!--нижнее  меню -----конец---------------------------------------------------------------------------- -->


</div>                      <!--<div class="horizontal-menu-padding visible-xs"> -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("../footer.php");
    ?>
   


</div> <!--"pagefooter"-->


</div>                                   <!-- тело -->

</div>                                     <!-- контейнер -->








<!--</div>  class="knotbackgroundsunglass" -->
<!--</div> class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed 
    <script src="../crop/js/bootstrap.min.js"></script>-->


    <!--  AJAX PHP chat   -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="js/jScrollPane/jquery.mousewheel.js"></script>
    <script src="js/jScrollPane/jScrollPane.min.js"></script>
    <script src="js/script.js"></script>


</body>
</html>
