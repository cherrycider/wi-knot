<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!

?>


<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>checking user credentials...</title>
	

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
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


      .content { padding-top:30px;}

     </style>

  </head>

  
<body>









<div class="knotbackground">
<div class="knotbackgroundsunglass">


<!--левое меню --------------------------------------------------------------------------------- -->
 


  <!-- #vertical menu -->
     <?php
    include ("menu_user_vertical.php");
    ?>
   



<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- начало ряда разметки bootstrap контейнер -->


<!--   <div class="col-xs-12 col-md-10">   <!-- центральная часть на xs занимает 12 частей на md только 10 -->
<div class="content"> 



<div class="logo-in-content">
	  <a href="../index.php">
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center">
      </a>
 </div>



<?php
    
	if(isset($_SESSION['userid'])){$userid = $_SESSION['userid'];}
    
    //обнуляем сессию !
    unset($_SESSION['userid']);
    unset($_SESSION['email']);
    unset($_SESSION['name']);	
    unset($_SESSION['photo']);
    unset($_SESSION['id']);
    unset($_SESSION['ssid']);
    unset($_SESSION['bssid']);	
// TODO подключиться к базе и поставить статус OFFLINE

    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
	// добавляем сеть в запись пользователя
    $query = "UPDATE people SET  onlineStatus = 'offline'  WHERE userid = '$userid'" ;
    $result3 = pg_query ($db, $query);

    // проверяем удачно ли соединились с базой 
    if (!$result3) {exit("sorry, something went wrong with the website, database update failed");}
 
    echo ("<div>
	      <br><br>
          <div><h3> you are not logged now </h3></div>
          <br>
		  <a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>log in</a><br>
          or<br>
          <a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>new registration</a><br>
          </div>
           ");

?>







</div> 


<div class="blankfootergap">
<?php
  include("../footer_gap.php");
?>
</div>



<!--<div class="horizontal-menu-padding visible-xs"> -->
<div class="horizontal-menu-padding">


  <!-- #horizontal menu -->
     <?php
    include ("menu_user_horizontal.php");
    ?>
   


</div> <!-- horizontal-menu-padding -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("../footer.php");
    ?>
   

</div>


</div>

</div> <!-- конец центральной части на xs занимает 12 частей на md только 10-->








</div> <!-- class="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
