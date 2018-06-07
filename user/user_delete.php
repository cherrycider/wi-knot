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

    if (isset($_SESSION['userid'])) {$userid = $_SESSION['userid'];}
	
	// на случай если удаляем не под своим аккаунтом - можем прислать ID пользователя в $_POST
    if (isset($_POST['userid'])) {$userid = $_POST['userid']; $_SESSION['userid']= $_POST['userid']; }

    $query = "SELECT * FROM people WHERE userid='$userid'";
    $result = pg_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = pg_fetch_array($result);
    
    //используем значения для отображения на сайте, например  в тегах php -  echo $myrow['name'] 
	
     $userid = $myrow['userid'];
     $email = $myrow['email'];
     $name = $myrow['name'];
     
     
     $photo_src = "../crop/user_photos/" . $myrow['photo'] . ".png";

?>


<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>delete user account</title>
	

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




<div class="container-fluid content-padding">  <!-- CONTAINER -->

<div class="content">

    <div class="logo-in-content">
	  <a href="../index.php">
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center">
      </a>
    </div>


	<div>
	
 
 
 
 
 <form action="user_delete.php" method="post">
    <h2>deleting user <?php echo $name ?> !!</h2> 
 
    <br><br>
    <label>enter your password:</label><br>
    <input name="password" type="password" size="30" maxlength="30">
	</p>
    <br>
    <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

    <p>
    <input type="submit" class="btn btn-default  knot-content-btn" name="submit" value="DELETE !!!">

    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_login_check.php ***** --> 
    <br><br><br>
 
    </p>

</form>
	
 <?php
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
    // если нажата клавиша DELETE
    if (isset($password)) {

    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    //удаляем лишние пробелы
    $password = trim($password);	
        // если  пароль совпадает с паролем пользователя
		if ($password==$myrow['password'])	{
			
			   // удаляем пользователя
			   $query = "DELETE FROM people WHERE userid='$userid'";
               $result = pg_query($db, $query);
               // проверяем удачно ли соединились с базой 
               if (!$result) {die("sorry, something went wrong on the website, database query failed");}
               // если все хорошо, затираем сессию
			   else {
				   
			   echo ("<div>the account is deleted<br>you are not logged now</div>");
			   
			   
                   //обнуляем сессию !
                    unset($_SESSION['userid']);
                    unset($_SESSION['email']);
                    unset($_SESSION['name']);	
                    unset($_SESSION['photo']);
                    unset($_SESSION['id']);
    // TODO подключиться к базе и поставить статус OFFLINE
	// TODO удалить фото
 
                echo ("<div>

           		  <a href='user_login.php' type='button' class='btn btn-default  knot-content-btn'>log in</a><br>
                  or<br>
                  <a href='user_registration.php' type='button' class='btn btn-default  knot-content-btn'>new registration</a><br>
                  </div>
           ");
			   
		       }
		}
        // если пароль не совпадает с паролем пользователя
		else {
		echo ("<div>password is not correct!</div>");	
		}		
	}
 
 
 ?>
 
 
 
	
	</div>

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
</div> <!-- CONTAINER -->


</div> <!-- class="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
