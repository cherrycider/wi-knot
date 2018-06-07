
	

<html>
<head>
<title>saving user credentials</title> 
	
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
  <h2>saving user credentials</h2>
 </center>
 </div>

 <div> <!--   php всей страницы в этом div -->
 
 <center>
 
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
           <a href='user_registration.php'>please go back</a>");
    
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
    include ("db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
    // проверка на существование пользователя с таким же email/паролем
    // уникальный userID состоит из комбинации email пароль, его будем проверять

    // после регистрации с компьютера userID становится таким же как его email
    // проверяем уникальность userID 
    $userID = $email;
    $result = mysqli_query($db, "SELECT id FROM people WHERE userID='$userID'");

    $myrow = mysqli_fetch_array($result);
    if (!empty($myrow['id'])) {
    
    exit ("<br><br>
           this email {$email} is already registered<br><br>
           <a href='user_login.php'>you can sign in to wi.knot</a><br><br><br><br>

           if this is not your email,<br><br>
           <a href='user_registration.php'>please enter new email/password</a>");
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
          <a id=highlight href='croppic/user_photo.php'>photo upload</a>";
//TODO здесь можно автоматически перейти на croppic/user_photo.php ч\з 3 секунды
//TODO также можно переименовать croppic/user_photo.php на более правильное croppic/user_photo_upload.php

    }
    else {
    echo "there is some error on the website, {$name}, you cannot register now.";
    }
    ?>

	
</center> 
 
 </div>
 
 

   <div id="menu"> 
    <table Border=0  CellSpacing=5 CellPadding=5 Width="90%" Align="center" vAlign="">
     <tr height="%">
     <td><a href="index.php" ><img src="../images/arrow_left_wite.png" height="80"><a></td> 
     <td></td> 
     <td></td>
     <td></td>
     <td></td>
     </tr>
     <tr height="%">
     <td><font size=5><a href="index.php" >back<a></font></td> 
     <td><font size=5></font></td>
     <td><font size=5></font></td>
     <td><font size=5></font></td>
     <td><font size=5></font></td>
     </tr>
    </table>
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

