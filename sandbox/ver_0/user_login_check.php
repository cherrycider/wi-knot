<html>
<head>
<title>checking user credentials...</title> 

	
<meta name="viewport" content="width=device-width">
	
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<style type="text/css">


  </style>

<body>

<div>
 <center>
 <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center"> 
 </center>
 </div>

<div>
 <center>
  checking user credentials...
 </center>
 </div>

 <div> <!--   php всей страницы в этом div -->
 
 <center>

<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 
    //заносим введенный пользователем логин в переменную $email, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
    if (empty($email) or empty($password)) 
    //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
    exit ("<br><br>
           <br><br>You did not enter your email or password. 
           <br><br>
           Please go back and fill all fields
           <br><br>
           <a href='user_login.php'>go back</a>");
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
    include ("db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    //если это не так, то просто измените путь 
 
    $query = "SELECT * FROM people WHERE email='$email'";
    $result = mysqli_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = mysqli_fetch_array($result);
	
	
    
	if (empty($myrow['password']))
    {
    //если поля пароля пользователя с введенным имейлом не существует или самого имейла нет
    exit ("<br><br>sorry, email is not valid, please enter correct email or register 
           <br><br>
           <br><br>
           <a href='user_login.php'>login again</a>
           <br><br> 
           or 
           <br><br> <a href='user_registration.php'>register</a> ");
    }
	
    else {
    //если существует, то сверяем пароли
    if ($myrow['password']==$password) {
    //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
    $_SESSION['userID']=$myrow['userID'];
    $_SESSION['email']=$myrow['email'];
    $_SESSION['name']=$myrow['name'];	
    $_SESSION['photo']=$myrow['photo'];
    $_SESSION['id']=$myrow['id'];
    //эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
    echo "<br><br>
          <h2>welcome to wi.knot, {$_SESSION['name']}!</h2>
          <br><br>
		  your userID = {$_SESSION['userID']}<br>
		  your email = {$_SESSION['email']} <br>
		  your name = {$_SESSION['name']}<br>
		  your photo = {$_SESSION['photo']}<br>
		  your id = {$_SESSION['id']}<br>
		  <br><br>
          <a href='index.php'>enter wi.knot</a>";
//TODO здесь сделать автоматическое перенаправление на index.php через 3 сек
    }
 else {
    //если пароли не сошлись

    exit ("Sorry, your email or password is not correct");
    }
    }
    ?>


</center> 
 
 </div>
 
 



 <div id="footer">

   <div>  
      <center><font size=5>
         <?php
          // выводим имя пользователя внизу в центре, 
          // если имя не установлено, редирект на страницу авторизации  
          if (isset($_SESSION['name'])){echo "".$_SESSION['name']."";}
           
         ?>
      </font></center>
   &copy; cherrycider
   </div>
  </div>


</body> 
</html>

