<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!



   // если пользователь не залогинен, переадресация на user_login.php
   // из базы данных достаем все данные о пользователе и формируем путь к файлу $photo_src


    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: ../user/user_login.php");}

	
	    // подключаемся к базе
    include ("db_connection.php");
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
     
     $photo_src = "../crop/user_photos/" . $myrow['photo'] . ".png";

	// пока по умолчанию ставим эти значения, дальше посмотрим... (в index.php и в wifi_hotspot.php)
	$ssid = "couchsurf";
	$bssid = "00:00:00:00:00:00";	 

	// если известна wifi сеть устанавливаем значения и добавляем в сессию 
	if ((isset($_SESSION['SSID'])) and (isset($_SESSION['BSSID'])))
	{
	$ssid = $_SESSION['SSID'];
	$bssid = $_SESSION['BSSID'];		
	}
	 
	 

?>




<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>wifi hotspot</title>
	

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
     </style>

  </head>

  
<body>









<div class="knotbackground">
<div class="knotbackgroundsunglass">


<!--левое меню --------------------------------------------------------------------------------- -->
  

<!-------Vertical buttons right (left) col ----------------->


<!--<div class= "vertical-menu-padding hidden-xs"> -->
<div class= "vertical-menu-padding">



  <!-- #vertical menu -->
     <?php
    include ("menu_vertical.php");
    ?>
   



</div>
<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- контейнер -->
<div> <!-- тело -->




<div> <!-- header (шапка с ssid и logo) -->
<div class = "knot-header"> 

<div class="ssid">


  <!-- #ssid header -->
     <?php
    include ("ssid_header.php");
    ?>
   

</div>  <!-- "ssid" -->

<div class="logo">
                
<a href = "index.php">
<img src="../images/logo_tilted_wite_text_original.png" height="120" width="360" align="center">
<a>
                
</div>   <!-- "logo" -->



</div>    <!-- "knot-header" -->
</div> <!-- header (шапка с ssid и logo) -->


<div class="content">  <!-- CONTENT CONTENT -->

<?php if (isset($_SESSION['SSID']))
{  // если в wifi сети, показываем ssid и bssid и кнопку exit wifi network, которая перенаправляет на домашнюю страницу 
echo ("	
<div><h1><img src='../images/logo_tilted_wite_100.png' height='40' width='40'>  {$ssid}</h1></div>
<div><h5>{$bssid}</h5></div>

<form action='index.php' method='post'>

    <p>    
    <input name='exitssid' type='text' size='15' maxlength='15' value='exit' hidden>
    </p> 
<br><br><br><br>
    <p>
    <input type='submit' name='exit wifi network' class='btn btn-default  knot-content-btn' value='exit wifi network'>
    </p>

</form>


");
}

else { // если не в сети, предлагаем войти в возможную wifi сеть
	
echo("
  <div><h3>please confirm  that you are now using this wifi hotspot:</h3></div>
    <form action='index.php' method='post'>
     <p>
    <input name='SSID' type='text' hint='{$ssid}' size='30' maxlength='30' value='{$ssid}'>
	</p>
	<p>
    <input name='BSSID' type='text' hint='{$bssid}' size='30' maxlength='30' value='{$bssid}'>	
    </p>
	<p>
    
	<input type='submit' name='save' class='btn btn-default  knot-btn-big knot-content-btn' value='confirm'>

    </p>
	
	
  <div><h3>or choose another wifi network from the list to log in remotely:</h3></div>
");		
}

?>





</div>   <!-- CONTENT CONTENT -->


<div class="blankfootergap">
<?php
  include("footer_gap.php");
?>
</div>




<div class="horizontal-menu-padding">  <!--<div class="horizontal-menu-padding visible-xs"> -->

<div class="horizontal-menu ">    <!-- #horizontal menu -->


 
     <?php
    include ("menu_horizontal.php");
    ?>
   
  
</div>                             <!-- horizontal-menu -->



</div>                      <!--<div class="horizontal-menu-padding visible-xs"> -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("footer.php");
    ?>
   


</div> <!--"pagefooter"-->


</div>                                   <!-- тело -->

</div>                                     <!-- контейнер -->








</div> <!-- ckass="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
