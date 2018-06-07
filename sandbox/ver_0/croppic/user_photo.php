<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если пользователя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['userID'])){header("Location: ../user_login.php");}
	
    ?>


<html>

<head>
 <!--   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png">
 -->
    <title>wi.knot user photo</title>
	
		
	<meta name="viewport" content="width=device-width">
	

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="assets/css/croppic.css" rel="stylesheet"> 
</head>


<link rel="stylesheet" type="text/css" href="../style.css">



<style type="text/css">


</style>

<body>

<div>
 <center>
 <img src="../images/logo_tilted_wite_text_original.png" height="10%" width="" align="center"> 
 </center>
</div>

<div>
 <center>
  <h2>upload your photo</h2>
 </center>
</div> <!-- место размещения конткйнера для кропа фото -->
	<center>
			<div>
				
				<center><div id="cropContainerMinimal"></div></center>
				
			</div>		
				
	</center>


	
<div>  <!--  кнопка save photo должна убедиться что есть файл в папке, создать меньший файл и прописать в photo в $_SESSION -->

<center>

    <form action="../user_profile.php" method="post">
         <p>
         <?php
            // поле фото уже должно быть сохранено в базу еще в img_crop_to_file.php при кропе            
            // подключаемся к базе
            include ("../db_connection.php");
            // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

            //достаем имя файла фото из базы
            $userID = $_SESSION['userID'];
	    $query = "SELECT photo FROM people WHERE userID='$userID'";
            $result = mysqli_query($db, $query);
	    // проверяем удачно ли соединились с базой 
            if (!$result) {die("sorry, something went wrong, database query failed");}
	    
            
            $myrow = mysqli_fetch_array($result);
            $photo = $myrow['photo'];
            
            //$_SESSION['photo'] = $myrow['photo'];
            //echo "photo filename is "."{$photo}"

            //$_POST['photo'] = $photo;


         ?>
         <input type="hidden" name="photo" value=$photo>
         </p>

        <p>  
	    <br> 
            <input type="submit" name="submit" value="save photo">   
            <br>
 
        </p>
	</form>


</center>



	<?php
	
	
	     // поле фото уже должно быть сохранено еще в img_crop_to_file.php 
//  TODO  здесь по кнопке Save  необходимо сохранить фото и установить в сессии, что пользователь имеет фото и перенаправить в index.php

    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

	$userID = $_SESSION['userID'];
	$query = "SELECT id FROM people WHERE userID='$userID'";
    $result = mysqli_query($db, $query);
	    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong, database query failed");}
	
	
    //$myrow = mysqli_fetch_array($result);
    //echo $myrow['password']; 
	//echo "{$_SESSION['photo']}"; 
    //$_SESSION['photo']=$myrow['photo'];
	

    //$myrow['id']
	
	?>

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


  
  
  
  
  
  
  
  
  
  
  
  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> -->
	<script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
   
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.mousewheel.min.js"></script>
   	<script src="croppic.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
		var croppicHeaderOptions = {
				//uploadUrl:'img_save_to_file.php',
				cropData:{
					"dummyData":1,
					"dummyData2":"asdas"
				},
				cropUrl:'img_crop_to_file.php',
				customUploadButtonId:'cropContainerHeaderButton',
				modal:false,
				processInline:true,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}	
		var croppic = new Croppic('croppic', croppicHeaderOptions);
		
		
		var croppicContainerModalOptions = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php',
				modal:true,
				imgEyecandyOpacity:0.4,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);
		
		
		var croppicContaineroutputOptions = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php', 
				outputUrlId:'cropOutput',
				modal:false,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		
		var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);
		
		var croppicContainerEyecandyOptions = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php',
				imgEyecandy:false,				
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		
		var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);
		
		var croppicContaineroutputMinimal = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php', 
				modal:true,
				doubleZoomControls:false,
			    rotateControls: true,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);
		
		var croppicContainerPreloadOptions = {
				uploadUrl:'img_save_to_file.php',
				cropUrl:'img_crop_to_file.php',
				loadPicture:'assets/img/night.jpg',
				enableMousescroll:true,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		}
		var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);
		
		
	</script>
</body> 
</html>
