<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
	
	
	// перенаправляем через 5 секунд на index.php 
//TODO нужно перенести весь php код выше этой записи и выполнять ее только при благоприятном условии
	header("refresh:5; url=../index.php");

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


<!--   <div class="col-xs-12 col-md-10">   <!-- центральная часть на xs занимает 12 частей на md только 10 -->
       <div> 



<div class="logo-in-content">
	  <a href="../index.php">
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center">
      </a>
 </div>

<div>

  checking user credentials...

 </div>

<div>
<?php
    if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 
    //заносим введенный пользователем логин в переменную $email, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
    if (empty($email) or empty($password)) 
    //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
    exit ("<br><br>
           <div><br><br>You did not enter your email or password. </div>
           <br><br>
           <div>Please go back and fill all fields </div>
           <br><br>
           <div><a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>go back</a></div>
           ");
    }      
		
    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    //удаляем лишние пробелы
    $email = trim($email);
    $password = trim($password);
    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    //если это не так, то просто измените путь 
 
    $query = "SELECT * FROM people WHERE email='$email'";
    $result = pg_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = pg_fetch_array($result);
	
	
    
	if (empty($myrow['password']))
    {
    //если поля пароля пользователя с введенным имейлом не существует или самого имейла нет
    echo ("<div><br><br>sorry, email is not valid, please enter correct email or register </div>
           <br><br>

           <div>
           <br><br>
           <a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>login again</a>
           <br> 
           or 
           <br> <a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>register</a> 
           </div>
           ");
    }
	
    else {
    //если существует, то сверяем пароли
    if ($myrow['password']==$password) {
    //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
    $_SESSION['userid']=$myrow['userid'];
    $_SESSION['email']=$myrow['email'];
    $_SESSION['name']=$myrow['name'];	
    $_SESSION['photo']=$myrow['photo'];
    $_SESSION['id']=$myrow['id'];
    $photo_file = $myrow['photo'];
 
 // если файл реально не существует обнуляем $_SESSION['photo']
 
   if (!file_exists('../crop/user_photos/'.$photo_file.'.png')){$_SESSION['photo']='';}
 
   if ((!isset($_SESSION['photo'])) or ($_SESSION['photo']=='')){
   $photo_src = "../crop/user_photos/defpic.png";
   }
   else {
   $photo_src = "../crop/user_photos/".$photo_file.".png";
   }
    //эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь


    echo ("<div><h2>welcome to wi.knot, {$_SESSION['name']}!</h2></div>
          <br>
            <div  id='crop-avatar'>
              <div class='avatar-view'>
	        <a href='../crop/user_photo.php'><img src = {$photo_src} alt='my photo'></a>


             </div>
            </div>
			<div>
              <a href='user_delete.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>delete account</a>
              <a href='../crop/user_photo.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>change photo</a>
              <a href='user_logout.php' type='button' class='btn btn-default btn-in-row knot-content-btn'>log out<br> </a>
			</div>
          <div>
          <br><br>
		  your userid = {$_SESSION['userid']}<br>
		  your email = {$_SESSION['email']} <br>
		  your name = {$_SESSION['name']}<br>
		  your photo = {$_SESSION['photo']}<br>
		  your id = {$_SESSION['id']}<br>
		  <br><br>
          </div>

		  <div>

		  <a href='../index.php' type='button' class='btn btn-default btn-in-row knot-content-btn knot-btn-big'>start wi.knot</a>

          </div>
           ");

//TODO здесь сделать автоматическое перенаправление на index.php через 3 сек
    }
 else {
    //если пароли не сошлись

    echo ("

         <div><br>Sorry, your email or password is not correct</div>
         <div>
         <br><br>
         <a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>login again</a>
         <br> 
         or 
         <br> <a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>register</a> 
         </div>

    ");
    }
    }
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
