<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: user/user_login.php");}
	
	
	else {
	// если нет фото у пользователя, редирект на страницу /croppic/photo.php  
    if ((!isset($_SESSION['photo'])) or ($_SESSION['photo'] === "")){header("Location: crop/user_photo.php");}
	}

	$userid = $_SESSION['userid'];
	$name = $_SESSION['name'];
	// пока по умолчанию ставим эти значения, дальше посмотрим... (в index.php и в wifi_hotspot.php)
	$ssid = "couchsurf";
	$bssid = "000000000000";
	
	
	// если прилетел из wifi_hotspot.php "exitssid" выходим из wifi сети
	if (isset($_POST['exitssid'])) 
	{if($_POST['exitssid']=="exit")
	 {
		 unset($_SESSION['ssid']);
		 unset($_SESSION['bssid']);
	    

	 } 
	}
	 	
	// если известна wifi сеть устанавливаем значения и добавляем в сессию 
	if ((isset($_SESSION['ssid'])) and (isset($_SESSION['bssid'])))
	{
	$ssid = $_SESSION['ssid'];
	$bssid = $_SESSION['bssid'];		
	}
	
	// если только что вошли в wifi сеть прописываем значения и создаем таблицы wifi сети, если нет
	if ((isset($_POST['ssid'])) and (isset($_POST['bssid'])))
	{
	$ssid = $_POST['ssid'];
	$bssid = $_POST['bssid'];		
    $_SESSION['ssid'] = $ssid;
    $_SESSION['bssid'] = $bssid;

    // заносим сеть в таблицу wifiNetworks, если нет и в таблице people ставим online  пользователю

    // подключаемся к базе
    include ("db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
    // формируем уникальный id  для wifi сети
	$wifiid = $ssid.$bssid;
    // проверяем есть ли такая сеть в базе
	$result = pg_query($db, "SELECT id FROM wifiNetworks WHERE wifiid='$wifiid'");	
    $mywifirow = pg_fetch_array($result);
    if (empty($mywifirow['id'])) {
	// если такой сети нет, то сохраняем данные
    $query = "INSERT INTO wifiNetworks (ssid, bssid, wifiid) VALUES('{$ssid}', '{$bssid}', '{$wifiid}')";
    $result2 = pg_query ($db, $query);
    // проверяем, есть ли ошибки
    if ($result2=='FALSE'){
    echo "there is some error on the website, {$name}, you cannot use this wifi network";		
	}	
	}	
	// добавляем сеть в запись пользователя
    $query = "UPDATE people SET ssid = '$ssid', bssid = '$bssid', wifiid = '$wifiid',  onlineStatus = 'online'  WHERE userid = '$userid'" ;
    $result3 = pg_query ($db, $query);

    // проверяем удачно ли соединились с базой 
    if (!$result3) {exit("sorry, something went wrong with the website, database update failed");}
	
	}	
	

	
    ?>





<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>wi.knot</title>
	

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
	  .content {
		  
		padding-top: 140px;
	  
	  }
	  
	  
      @media screen and (min-aspect-ratio: 13/9) { 
        /* landscape styles here */


       .content {padding-top: 30px;}

       }
	  
     </style>

  </head>

  
<body>









<div class="knotbackground">
<div class="knotbackgroundsunglass">


<!--левое меню --------------------------------------------------------------------------------- -->
    <div>

<!-------Vertical buttons right (left) col ----------------->


<!--<div class= "vertical-menu-padding hidden-xs"> -->
<div class= "vertical-menu-padding">



  <!-- #vertical menu -->
     <?php
    include ("menu_vertical.php");
    ?>
   



</div>
<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- начало ряда разметки bootstrap контейнер -->


<!--   <div class="col-xs-12 col-md-10">   <!-- центральная часть на xs занимает 12 частей на md только 10 -->
       <div> 
<div> <!-- header (шапка с титулом) -->
<div class = "knot-header"> 

<div class="ssid">

  <!-- #ssid header -->
     <?php
    include ("ssid_header.php");
    ?>
   
    
</div>

<div class="logo">
                
<a href = "index.php">
<img src="../images/logo_tilted_wite_text_original.png" height="120" width="360" align="center">
<a>
                
</div>



</div>  
</div> <!-- header (шапка с титулом) -->


<div class="content">

<?php
 if ((!isset($_SESSION['ssid'])) or  (!isset($_SESSION['bssid'])))
{
echo("
  <div><h3>please confirm  that you are now using this wifi hotspot:</h3></div>
    <form action='index.php' method='post'>
     <p>
    <input name='ssid' type='text' hint='{$ssid}' size='30' maxlength='30' value='{$ssid}'>
	</p>
	<p>
    <input name='bssid' type='text' hint='{$bssid}' size='30' maxlength='30' value='{$bssid}'>	
    </p>
	<p>
    
	<input type='submit' name='save' class='btn btn-default  knot-btn-big knot-content-btn' value='confirm'>

    </p>
	
	
  <div><h3>or choose another wifi network from the list to log in remotely:</h3></div>
");
}
?>






</div> 


<div class="blankfootergap">
<?php
  include("footer_gap.php");
?>
</div>



<!--<div class="horizontal-menu-padding visible-xs"> -->
<div class="horizontal-menu-padding">

<div class="horizontal-menu ">


  <!-- #horizontal menu -->
     <?php
    include ("menu_horizontal.php");
    ?>
   
  
</div>



</div> <!-- horizontal-menu-padding -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("footer.php");
    ?>
   

</div>


</div>

</div> <!-- конец центральной части на xs занимает 12 частей на md только 10-->






</div>  <!-- конец правой части на xs пропадает а на md 2 части-->


</div>  <!--конец ряда разметки bootstrap контейнер-->


</div> <!-- ckass="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed 
    <script src="js/bootstrap.min.js"></script>-->
</body>
</html>
