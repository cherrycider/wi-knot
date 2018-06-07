<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();
?>

<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>please login</title>
	

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
	
   
<form action="user_login_check.php" method="post">
    <h2>please login</h2> 
    <!--****  user_login_check.php - это адрес обработчика. То есть, после нажатия на кнопку  "Войти", данные из полей отправятся на страничку user_login_check.php методом  "post" ***** -->
    <p>
    <label>enter your email:</label><br>
    <input name="email" type="text" size="30" maxlength="30">
    </p>


    <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
 
    <p>

    <label>password:</label><br>
    <input name="password" type="password" size="30" maxlength="30">
	</p>

    <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 

    <p>
    <input type="submit" class="btn btn-default  knot-content-btn" name="submit" value="login">

    <!--**** Кнопочка (type="submit") отправляет данные на страничку user_login_check.php ***** --> 
    <br><br><br>
 
    </p>
	
    <p>
      <h4>if you are first time, please</h4>
    </p>

</form>
	
	
	
	<!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** --> 
    
	

        <a href="user_registration.php" type="button" class="btn btn-default  knot-content-btn">
              register here
        </a>

	
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
    echo "you are logged to wi.knot as ".$_SESSION['name']."
          <br><br>

          <a  href='../index.php' type='button' class='btn btn-default  knot-content-btn'>enter wi.knot</a>
          <br>
          or
          <br>
          <a  href='user_logout.php' type='button' class='btn btn-default  knot-content-btn'>log out</a>
          ";
    }
    ?>
	
	</div>

    <br><br>



    <div id="how_it_works"> <h1>wi.knot - how it works</h1> </div>

    <div>
      <img src="../images/logo_tilted_wite_text_original.png" height="15%" width="" align="center"> 
    </div>

<br><br><br>to be explained little bit later..
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>




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

</div>  <!-- начало ряда разметки bootstrap контейнер -->



</div> <!-- class="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
