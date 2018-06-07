

<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>user registration</title>
	

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



<div class="container-fluid content-padding">  <!-- начало ряда разметки bootstrap контейнер -->


<!--   <div class="col-xs-12 col-md-10">   <!-- центральная часть на xs занимает 12 частей на md только 10 -->
       <div> 



<div class="content">


    <div class="logo-in-content">
	  <a href="../index.php">
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center">
      </a>	  
    </div>




<div>
 

    <h2>registration</h2>
    <form action="user_save.php" method="post">
    <!--**** user_save.php - это адрес обработчика.  То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей  отправятся на страничку user_save.php методом "post" ***** -->
<p>
    <label>please enter your full name</label><br>
    <input name="name" type="text" size="30" maxlength="30">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь выбирает себе имя ***** -->
<p>
    <label>please enter your email</label><br>
    <input name="email" type="text" size="30" maxlength="30">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
<p>
    <label>select password</label><br>
    <input name="password" type="password" size="30" maxlength="30">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

<p>
    <label>re-enter password</label><br>
    <input name="repassword" type="password" size="30" maxlength="30">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь еще раз вводит свой пароль ***** --> 
<p>
    <input type="submit" class="btn btn-default  knot-content-btn" name="register" value="register">
<!--**** Кнопочка (type="submit") отправляет данные на страничку user_save.php ***** --> 
</p></form>

 
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
