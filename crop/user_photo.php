<?php

// чтобы заставить обновляться браузер чистим ему кэш
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если имя не установлено, редирект на страницу авторизации 
    //($_POST['userid'] проходит сразу после регистрации со страницы user_save.php)
    if ((!isset($_SESSION['userid'])) and (!isset($_POST['userid']))){header("Location: ../user/user_login.php");}



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
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, 
    //если это не так, то просто измените путь 

    if (isset($_SESSION['userid'])) {$userid = $_SESSION['userid'];}
    if (isset($_POST['userid'])) {$userid = $_POST['userid']; $_SESSION['userid']= $_POST['userid']; }
    $query = "SELECT * FROM people WHERE userid='$userid'";
    $result = pg_query($db, $query);
    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong on the website, database query failed");}
 
    //извлекаем из базы все данные о пользователе с введенным логином
    $myrow = pg_fetch_array($result);
	
	//используем значения для отображения на сайте, например  в тегах php -  echo $myrow['name'] 
	
	
	
	
		$button_save = "save";
                $save_no_photo = "false";
	
	//после нажатия кнопки save на этой же странице делаем: 
	// ----------------------------------------------------
	if (isset($_POST['button_save'])) { $button_save = $_POST['button_save'];}
        if (isset($_POST['save_no_photo'])) { $save_no_photo = $_POST['save_no_photo'];}
	if ($button_save == 'saved') {
		

		if ($save_no_photo == 'no_photo') 
			{ $photo_file_name = 'defpic';  }
		
		else {$photo_file_name = $myrow['userid'];}


		// если еще фото не записано в базу или не такое же как userid
                //if (!isset($myrow['photo']) or ($myrow['photo']!='') or ($myrow['photo']!=$myrow['userid'])){
         
                // еcли фото существует  
                if (file_exists('user_photos/'. $photo_file_name .'.png')) {
		
			//дописываем имя файла в бд пользователя с таким же userid
	            $query = "UPDATE people SET photo = '$photo_file_name' WHERE userid='$$userid'";
                $result = pg_query ($db, $query);

            // проверяем удачно ли соединились с базой 
                if (!$result) {die("sorry, something went wrong with the website, database update failed");}
	    
            
            // изменяем параметры сессии, говорим, что у нас есть фото
                $_SESSION['photo'] = $photo_file_name;
	    
            //  да и логинимся заодно
           //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
                 $_SESSION['userid']=$myrow['userid'];
                 $_SESSION['email']=$myrow['email'];
                 $_SESSION['name']=$myrow['name'];	
                 $_SESSION['id']=$myrow['id'];
            
            // 

		}
		else {$button_save = 'save';}
		
	}
	
?>


	
	



<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>photo</title>
	

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
	
	 <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
     <link rel="stylesheet" href="css/cropper.min.css">
     <link rel="stylesheet" href="css/main.css">


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
      .content {padding-top: 0;}
	  


    .container {
      max-width: 960px;
    }

    img {
      max-width: 100%;
    }

 
	  
	  
	  
     </style>

  </head>

  
<body>









<div class="knotbackground">
<div class="knotbackgroundsunglass">


<!--левое меню --------------------------------------------------------------------------------- -->
  


  <!-- #vertical menu -->
     <?php
    include ("../user/menu_user_vertical.php");
    ?>
   


<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- контейнер -->
<div> <!-- тело -->





<div class="content">  <!-- CONTENT CONTENT -->
 <!--

  сontent<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
-->

<!-- <div class="container" id="crop-avatar"> -->
  <div  id="crop-avatar">
  
 <?php
 if(!isset($_SESSION['photo']) or ($_SESSION['photo']=='')){
	 
	 echo("<div><h3>you have to upload you photo<br>before using wi.knot<h3></div>");
 }
  
 ?> 
  
<!--//TODO стрелки вниз по бокам надписи -->   
  <br><span class="glyphicon glyphicon-arrow-down"></span> click on photo to change <span class="glyphicon glyphicon-arrow-down"></span><br>
    <!-- Current avatar -->
    <div class="avatar-view">
	  
<!-- проверяем если фото пользователя есть - если нет транслируем defpic.png -->

	  <?php 
	  
	  if (file_exists('user_photos/'. $userid .'.png')) 
                 { $photo_src = $userid;} 
	  
	  else { $photo_src="defpic" ;};
	  
	  
	  ?>
      
	  <img src="user_photos/<?php echo ($photo_src)?>.png" alt="click to upload photo">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
           

<!-- 		удаляем верхнюю строчку с крестиком выключателем  
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
            </div>
-->			
			
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
				  
<!--	передаем имя файла		  $user_filename = $userid   -->
<!--   вручную                  <input type="text" class="avatar-userid" name="avatar_userid">  -->
				  
                  <label for="avatarInput">Local upload</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                </div>

                <!-- Crop and preview -->


                    <div class="avatar-wrapper"></div>

    <!--              
	              <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                   </div>
	-->
 

                <div class="row avatar-btns">
                
    <!--
				<div class="col-md-9">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                    </div>
                  </div>    
				  
	-->
    <!--              <div class="col-md-3">     -->
            <button type="submit" class="btn btn-default btn-in-row knot-btn-big btn-block avatar-save knot-content-btn">Done</button>
		    <button type="button" class="btn btn-default btn-in-row btn-block knot-content-btn" data-dismiss="modal">Close</button>
    <!--              </div>                     -->
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
	
	
 </div>

  
  
  
  
  
  
  
 <!-- ********************************************************************************* --> 
 <div> <!-- save button --> 
 <form action="user_photo.php" method="post">

    <p>    
    <input name="button_save" type="text" size="15" maxlength="15" value="saved" hidden>
    </p>
<!--**** В спрятанном поле отправляем сообщение что клавиша save нажата ***** --> 

    <p>
    <input type="submit" name="save" class='btn btn-default  knot-content-btn' value="<?php echo "$button_save"; ?>">
<!--**** Кнопочка (type="submit") отправляет данные опять на эту же страничку user_photo.php  ***** --> 
    </p>

</form>




 <form action="user_photo.php" method="post">

    <p>    
    <input name="button_save" type="text" size="15" maxlength="15" value="saved" hidden>
    </p>
<!--**** В спрятанном поле отправляем сообщение что клавиша save нажата ***** --> 

    <p>    
    <input name="save_no_photo" type="text" size="15" maxlength="15" value="no_photo" hidden>
    </p>
<!--**** В спрятанном поле отправляем сообщение что save without photo ***** -->


    <p>
    <input type="submit" name="no_photo" class='btn btn-default  knot-content-btn' value="save without photo"; ?>">
<!--**** Кнопочка (type="submit") отправляет данные опять на эту же страничку user_photo.php  ***** --> 
    </p>

</form>





<!-- **** если кнопка save превратилась в saved то появляется кнопка go to wi.knot -->

       <?php   
             if ($button_save == 'saved')
               {
                  echo "<a href='../index.php' type='button' class='btn btn-default  knot-content-btn'>go to wi.knot</a>";
               }
?>

 </div> <!-- save button -->  
<!-- ********************************************************************************* -->


 <!--  сontent<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
-->





</div>   <!-- CONTENT CONTENT -->


<div class="blankfootergap">
<?php
  include("../footer_gap.php");
?>
</div>




<div class="horizontal-menu-padding">  <!--<div class="horizontal-menu-padding visible-xs"> -->

  <!-- #horizontal menu -->
     <?php
    include ("../user/menu_user_horizontal.php");
    ?>
   


</div>                      <!--<div class="horizontal-menu-padding visible-xs"> -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("../footer.php");
    ?>
   


</div>


</div>                                   <!-- тело -->

</div>                                     <!-- контейнер -->








</div> <!-- class="knotbackgroundsunglass" -->
</div> <!--class="knotbackground"-->  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	
	
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/cropper.min.js"></script>
  <script src="js/main.js"></script>
  
  
  <script>
    $(function () {
      $('#image').cropper({
        viewMode: 3,
        dragMode: 'move',
        autoCropArea: 1,
        restore: false,
        modal: false,
        guides: false,
        highlight: false,
        cropBoxMovable: false,
        cropBoxResizable: false
      });
    });
  </script>
  
  
  
	
	
</body>
</html>
