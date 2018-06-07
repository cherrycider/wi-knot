<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();
    ?>
    <html>
    <head>
    <title>please login</title>
	
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
    <h2>please login</h2>
    <form action="user_login_check.php" method="post">

    <!--****  user_login_check.php - это адрес обработчика. То есть, после нажатия на кнопку  "Войти", данные из полей отправятся на страничку user_login_check.php методом  "post" ***** -->
    <p>
    <label>enter your email:<br></label>
    <input name="email" type="text" size="30" maxlength="30">
    </p>


    <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
 
    <p>

    <label>password:<br></label>
    <input name="password" type="password" size="30" maxlength="30">
	</p>

    <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

    <p>
    <input type="submit" name="submit" value="sign in">

    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_login_check.php ***** --> 
    <br><br><br>
 
    </p>
	</form>
	
	if you are first time, please<br>
	
	<!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** --> 
    
	<a href="user_registration.php">register here</a>

        
	
    <br><br><br>
    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['name']) or empty($_SESSION['id']))
    {
    // Если пусты, то мы не выводим ссылку
    echo "you are not logged now <br> ";
    }
    else
    {

    // Если не пусты, то мы выводим ссылку
    echo "login to wi.knot as ".$_SESSION['name']."<br><br><a  href='index.php'>login here</a><br>";
    }
    ?>
	</center>
	</div>
    </body>
    </html>
