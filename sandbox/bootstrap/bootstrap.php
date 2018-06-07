<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>
	

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

    <a href = "wifi_hotspot.php">
  
      <h3><img src="../images/logo_tilted_wite_100.png" height="20" width="20">  wifi hotspot</h3> 
    
    <a>
    
</div>

<div class="logo">
                
<a href = "user_profile.php">
<img src="../images/logo_tilted_wite_text_original.png" height="120" width="360" align="center">
<a>
                
</div>



</div>  
</div> <!-- header (шапка с титулом) -->


<div class="content">

<br> content <br>
 <!--  сontent<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
-->

<button type="button" class="btn btn-default navbar-btn">my button</button>







</div> 


<div class="blankfootergap">

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


      <h3>
	    <a href = "user_profile.php">user name<?php
          // выводим имя пользователя внизу в центре, 
          // если имя не установлено, редирект на страницу авторизации  
           if (isset($_SESSION['name'])){echo "".$_SESSION['name']."";}  
         ?>
        <a>
 
      <h3>

</div>


</div>

</div> <!-- конец центральной части на xs занимает 12 частей на md только 10-->






</div>  <!-- конец правой части на xs пропадает а на md 2 части-->


</div>  <!--конец ряда разметки bootstrap контейнер-->


</div> <!-- ckass="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
