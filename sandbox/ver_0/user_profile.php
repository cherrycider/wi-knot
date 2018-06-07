<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['userID'])){header("Location: user_login.php");}
    else 
    {
    if (!isset($_SESSION['photo'])){header("Location: croppic/user_photo.php");}
    }

	// Function to get the client IP address
    function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    }
	$ip = get_client_ip();
	
	
	    // подключаемся к базе
    include ("db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    //если это не так, то просто измените путь 
    $userID = $_SESSION['userID'];
    $query = "SELECT * FROM people WHERE userID='$userID'";
    $result = mysqli_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = mysqli_fetch_array($result);
	
	//используем значения для отображения на сайте, например  в тегах php -  echo $myrow['name'] 
	
	
	$button_save = "save";
	
	//после нажатия кнопки save на этой же странице делаем: 
	// ----------------------------------------------------
	
	
	if (isset($_POST['button_save'])) { $button_save = $_POST['button_save'];}
	
	if ($button_save == 'saved') { 



	  
	
        if (isset($_POST['name'])) { $name = $_POST['name'];} 
    //заносим введенный пользователем имя в переменную $name, если он пустой, то уничтожаем переменную
	if (isset($_POST['phone1'])) { $phone1 = $_POST['phone1'];} 
    //заносим введенный пользователем имаил в переменную $phone1, если он пустой, то уничтожаем переменную    
	if (isset($_POST['phone2'])) { $phone2 = $_POST['phone2'];} 
    //заносим введенный пользователем имаил в переменную $phone2, если он пустой, то уничтожаем переменную	
	if (isset($_POST['phone3'])) { $phone3 = $_POST['phone3'];} 
    //заносим введенный пользователем имаил в переменную $phone3, если он пустой, то уничтожаем переменную	
	
	
	
    //если поля введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    if (isset($_POST['name'])) {$name = stripslashes($name);}
    if (isset($_POST['name'])) {$name = htmlspecialchars($name);}
    if (isset($_POST['phone1'])) {$phone1 = stripslashes($phone1);}
    if (isset($_POST['phone1'])) {$phone1 = htmlspecialchars($phone1);}
    if (isset($_POST['phone2'])) {$phone2 = stripslashes($phone2);}
    if (isset($_POST['phone2'])) {$phone2 = htmlspecialchars($phone2);}
    if (isset($_POST['phone3'])) {$phone3 = stripslashes($phone3);}
    if (isset($_POST['phone3'])) {$phone3 = htmlspecialchars($phone3);}

	
	
	
	if (isset($_POST['password'])) { $password_to_check=$_POST['password'];}
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную

    //если поля введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $password_to_check = stripslashes($password_to_check);
    $password_to_check = htmlspecialchars($password_to_check);
	
	// проверяем пароль, введенный перед нажатием SAVE
	if (isset($_POST['password']) and ($password_to_check == $myrow['password'])) 
	
	{
    // если совпадает пароль вносим все в базу  userID
	 
    $query = "UPDATE people SET name = '$name' WHERE userID = '$userID'" ;
    $result = mysqli_query ($db, $query);

    // проверяем удачно ли соединились с базой 
    if (!$result) {exit("sorry, something went wrong with the website, database update failed");}
	
	// изменяем параметры сессии 
	$_SESSION['name']=$name; 

//TODO если появятся phone2 и phone3 if (isset($_POST['phone2/3'])) - вводим их в базу тоже


    // и опять достаем все из базы
	$query = "SELECT * FROM people WHERE userID='$userID'";
    $result = mysqli_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = mysqli_fetch_array($result);
	
	//используем значения для отображения на сайте, например  в тегах php -  echo $myrow['name'] 
	
	
    }	
    
	else {$button_save = 'enter correct password and save!';}

    }
	// Здесь закончена часть обработки после нажатия кнопки save
	// ----------------------------------------------------------
	
	
	

    ?>


<html>
<head>
<title>user profile</title> 

	
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
  <h2>my profile</h2>

 </center>
</div>

<div> <!-- Здесь информация о подключении пользователя -->

<p>
    <label>last attended wifi hotspot </label>
    <input name="ssid" type="text" size="30" maxlength="30" value="couchsurf"  disabled><br>
	<label> status </label>
    <input name="ssid" type="text" size="8" maxlength="30" value="online"  disabled><br>
	<label>last login IP</label>
    <input name="ssid" type="text" size="30" maxlength="30" value="<?php echo $ip ?>"  disabled><br>


</div>


<!--TODO проверить на exist и перебрать расширения .jpeg,... -->
<div> <!-- фото здесь-->
 <center>
  <img src="../croppic/photos/<?php echo ($_SESSION['photo'])?>.jpeg" height="" width="35%" align="center"> 
 </center>
</div>

<div> <!-- ******************* поля для изменения здесь ************************************-->
<center>


    <form action="user_profile.php" method="post">
   
<p>
    
    <input name="name" type="text" size="30" maxlength="30" value="<?php echo $myrow['name'] ?>">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь выбирает себе имя ***** -->


<p>
    
    <input name="phone1" type="text" hint="phone 1" size="30" maxlength="30" 
	value="
	<?php if (isset($myrow['phone1'])or($myrow['phone1']!=="")) {echo $myrow['phone1'];} else {echo "";} ?>
	"
	>
<!--TODO найти как использовать hint-->    
     </p>
<!--**** В текстовое поле (name="login" type="text") пользователь выбирает себе имя ***** -->

<!--TODO is phone1 is not empty - show phone2 field -->

<p>
    <label>more info<br></label>
	<textarea name="moreinfo" class="form-control" cols="28" rows="3" font="arial" 
	placeholder="<?php if (!isset($myrow['moreinfo'])or($myrow['moreinfo']=="")) {echo "more info";} else {echo $myrow['moreinfo'];} ?>"
	>
	</textarea>
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->

<p>
    <label>your login id<br></label>
    <input name="email" type="text" size="30" maxlength="30" value="<?php echo $myrow['email'] ?>" disabled>
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->

<p>
    <label>please enter you password<br>to save changes<br></label>
    <input name="password" type="password" size="30" maxlength="30" value="">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

<p>    
    <input name="button_save" type="text" size="30" maxlength="30" value="saved" hidden>
    </p>
<!--**** В спрятанном поле отправляем сообщение что клавиша save нажата ***** --> 

<p>
    
	<input type="submit" name="save" value="<?php echo $button_save; ?>">
<!--**** Кнопочка (type="submit") отправляет данные на страничку user_save.php ***** --> 

<!-- ********************************************************************************* -->
</p></form>


<!-- ********************************************************************************* -->
<!-- *********кнопки home, delete profile, change password и logout******************************** -->

    <form action="index.php" method="post">
    <!--**** index.php - это адрес обработчика.  То есть, после нажатия на кнопку "home", данные из полей  отправятся на страничку index.php методом "post" ***** -->
    <input type="submit" name="home" value="home">
    <!--**** Кнопочка (type="submit") отправляет данные на страничку index.php ***** --> 
    </form>

    <form action="user_delete_profile.php" method="post">
    <!--**** user_password_change.php - это адрес обработчика.  То есть, после нажатия на кнопку "delete profile", данные из полей  отправятся на страничку index.php методом "post" ***** -->
    <input type="submit" name="user_delete_profile" value="delete profile">
    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_delete_profile.php ***** --> 
	</form>
	
    <form action="user_password_change.php" method="post">
    <!--**** user_password_change.php - это адрес обработчика.  То есть, после нажатия на кнопку "password change", данные из полей  отправятся на страничку index.php методом "post" ***** -->
    <input type="submit" name="user_password_change" value="password change">
    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_password_change.php ***** --> 
	</form>
	
	<form action="user_logout.php" method="post">
    <!--**** user_password_change.php - это адрес обработчика.  То есть, после нажатия на кнопку "user logout", данные из полей  отправятся на страничку index.php методом "post" ***** -->
    <input type="submit" name="user_logout" value="user_logout">
    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_password_change.php ***** --> 
	</form>

	
</center>
</div>
<!-- TODO сделать кнопки home, delete profile, change password и logout -->



<div height="20%" width="" align="center"> <!-- пустое место -->
<center>
<br><br>
</center>
</div>





 <div id="footer">

   <div>  
      <center><font size=5>
	    <a href = "user_profile.php">
         <?php
          // выводим имя пользователя внизу в центре, 
          // если имя не установлено, редирект на страницу авторизации  
           if (isset($_SESSION['name'])){echo "".$_SESSION['name']."";}  
         ?>
		 <a>
      </font></center>
   &copy; cherrycider
   </div>
  </div>
