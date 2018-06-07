<html>
    <head>
    <title>Registration</title>
		
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

    <h2>registration</h2>
    <form action="user_save.php" method="post">
    <!--**** user_save.php - это адрес обработчика.  То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей  отправятся на страничку user_save.php методом "post" ***** -->
<p>
    <label>please enter your full name<br></label>
    <input name="name" type="text" size="30" maxlength="30">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь выбирает себе имя ***** -->
<p>
    <label>please enter your email<br></label>
    <input name="email" type="text" size="30" maxlength="30">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
<p>
    <label>select password<br></label>
    <input name="password" type="password" size="30" maxlength="30">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

<p>
    <label>re-enter password<br></label>
    <input name="repassword" type="password" size="30" maxlength="30">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь еще раз вводит свой пароль ***** --> 
<p>
    <input type="submit" name="register" value="register">
<!--**** Кнопочка (type="submit") отправляет данные на страничку user_save.php ***** --> 
</p></form>

 </center> 
</div>

    </body>
    </html>
