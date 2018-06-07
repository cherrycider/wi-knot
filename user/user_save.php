<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>saving user credentials</title>
	

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


<div>

  <h5>saving user credentials..</h5>

 </div>


 
 <?php
    if (isset($_POST['name'])) { $name = $_POST['name']; if ($name == '') { unset($name);} } 
    //заносим введенный пользователем имя в переменную $name, если он пустой, то уничтожаем переменную
	if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 
    //заносим введенный пользователем имаил в переменную $email, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
	if (isset($_POST['repassword'])) { $repassword=$_POST['repassword']; if ($repassword =='') { unset($repassword);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
    if (empty($name) or empty($email) or empty($password)) 
    //если пользователь не ввел имя, логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
		
    exit ("<br><br>name, email and password are mandatory for using wi.knot from computer
           <br><br>
           <a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>please go back</a>");
    
	}
    //если имя, логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $name = stripslashes($name);
    $name = htmlspecialchars($name);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
	//$repassword = stripslashes($repassword);
    //$repassword = htmlspecialchars($repassword);
	
//TODO проверить пароли на одинаковость и email на адекватность

    //удаляем лишние пробелы
    $email = trim($email);
    $password = trim($password);
    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
    // проверка на существование пользователя с таким же email/паролем
    // уникальный userID состоит из комбинации email пароль, его будем проверять

    // после регистрации с компьютера userID становится таким же как его email
    // проверяем уникальность userID 
    $userID = $email;
    $result = mysqli_query($db, "SELECT id FROM people WHERE userID='$userID'");

    $myrow = mysqli_fetch_array($result);
    if (!empty($myrow['id'])) {
    
    exit ("<div><br><br>
           this email {$email} is already registered<br>you can sign in to wi.knot<br>
           </div>
           <div><a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>log in</a><br><br><br></div>

           <div>if this is not your email,<br>please enter new email/password<br></div>
           <div><a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>go back</a></div>
          ");
    }
    // если такого нет, то сохраняем данные
    $query = "INSERT INTO people (userID, email, name, password) VALUES('{$userID}', '{$email}', '{$name}','{$password}')";
    $result2 = mysqli_query ($db, $query);
    
    // Проверяем, есть ли ошибки
    if ($result2=='TRUE')
    {
    echo "<br><br>
          WELCOME !
          <br><br>
          nice to meet you, {$name}! 
          <br><br> 
          now please upload your photo here 
          <br><br>
          
          <form  action='../crop/user_photo.php' method='post'>

           <p>    
             <input name='userID' type='text' size='30' maxlength='30' value= {$userID} hidden >
           </p>
           <!--**** В спрятанном поле отправляем сообщение что userID определен ***** --> 

           <p>
             <input type='submit' name='photo_upload' class='btn btn-default  knot-content-btn' value='photo upload'>
            <!--**** Кнопочка (type='submit') отправляет данные опять на страничку user_photo.php ***** --> 
           </p>

           </form>
           
          ";
          
//TODO здесь можно автоматически перейти на croppic/user_photo.php ч\з 3 секунды
//TODO также можно переименовать croppic/user_photo.php на более правильное croppic/user_photo_upload.php

    }
    else {
    echo "there is some error on the website, {$name}, you cannot register now.";
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
