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
     
     $photo_src = "../crop/user_photos/" . $myrow['photo'] . ".png";

	    // если фото не установлено, редирект на страницу авторизации  
//    if (!file_exists($photo_src)){
//	  header("Location: ../crop/user_photo.php");}

	 
?>


<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>my profile</title>
	

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">


	 <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
     <link rel="stylesheet" href="../crop/css/cropper.min.css">
     <link rel="stylesheet" href="../crop/css/main.css">


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
 


  <!-- #vertical menu -->
     <?php
    include ("menu_user_vertical.php");
    ?>
   



<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- начало ряда разметки bootstrap контейнер -->

<div class="logo-in-content">
	  <a href="../index.php">
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center">
      </a>
 </div>

<div>

<div> <!-- PROFILE-->



  <div  id="crop-avatar">
    <div class="avatar-view">
	
 <!--    <?php if(!file_exists($photo_src)){$photo_src = "../crop/user_photos/defpic.png";} ?> -->
	
	 <a href='../crop/user_photo.php'><img src = "<?php echo $photo_src ; ?>" alt="my photo"></a>
    </div>
  </div>
<div>
<a href='user_delete.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>delete account</a>
<a href='../crop/user_photo.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>change photo</a>
<a href='user_logout.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>log out<br> </a>
</div>
<div>
     <br>
     name     <?php echo ($name); ?><br>
     email    <?php echo ($email); ?><br>

     password <?php echo ($password); ?><br>

</div>

<!--//TODO  кнопки change photo, logout, delete account, go to wi.knot также статус ssid, online, ip -->



<div>
<div> 

         <a href='../index.php' type='button' class='btn btn-default btn-in-row knot-content-btn knot-btn-big'>start wi.knot</a>       

</div> 
</div> 





</div> <!-- /PROFILE-->


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






</div>  <!-- конец правой части на xs пропадает а на md 2 части-->


</div>  <!--конец ряда разметки bootstrap контейнер-->


</div> <!-- class="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
