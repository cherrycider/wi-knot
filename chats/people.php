<?php
    session_start();
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!



   // если пользователь не залогинен, переадресация на user_login.php
   // из базы данных достаем все данные о пользователе и формируем путь к файлу $photo_src


    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: ../user/user_login.php");}

	if ((isset($_SESSION['ssid'])) and (isset($_SESSION['bssid']))) {
	$ssid = $_SESSION['ssid'];
	$bssid = $_SESSION['bssid'];
	$wifiid = $ssid.$bssid;
	} else {header("Location: ../index.php");}
		
	
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
	
     $userid = $myrow['userid'];
     $email = $myrow['email'];
     $name = $myrow['name'];
     $password = $myrow['password'];
     $photo = $myrow['photo'];
     
     $photo_src = "../crop/user_photos/" . $photo . ".png";
	 
	 


?>




<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>people</title>
	
    <!--
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
     -->

	
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
 

    <link href="../css/style.css" rel="stylesheet">
	
	<!-- chat styles 
	<link type="text/css" rel="stylesheet" href="style.css" />
    -->
	
	
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
      .knotbackground {
	      position: fixed; /* Фиксированное положение */
	      left: 0; top: 0; bottom:0; right:0; 
       }

       .knotbackgroundsunglass {

       	position: fixed; /* Фиксированное положение 	*/
     	left: 0; top: 0; bottom:0; right:0; 

      }

     </style>
	 


  </head>

  
<body>







<!-- фон и затемнение вынесены и привязаны ко всем углам экрана -->

<div class="knotbackground">
<div class="knotbackgroundsunglass">
</div>
</div>



<!--левое меню --------------------------------------------------------------------------------- -->
  

<!-------Vertical buttons right (left) col ----------------->


<!--<div class= "vertical-menu-padding hidden-xs"> -->
<div class= "vertical-menu-padding">



  <!-- #vertical menu -->
     <?php
    include ("../menu_vertical.php");
    ?>
   



</div>
<!--левое меню -----конец---------------------------------------------------------------------------- -->




<div class="container-fluid content-padding">  <!-- контейнер -->
<div> <!-- тело -->





<div class = "knot-header"> 

<div class="ssid">

  <!-- #ssid header -->
     <?php
    include ("../ssid_header.php");
    ?>
   
    
</div>  <!-- /"ssid" -->


</div>    <!-- /"knot-header" --> 



<div class="content">  <!-- CONTENT CONTENT -->

<div class="fixed-title"><h2>people around</h2></div>
 <!--  сontent<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><-->


<div class = "chat-area" id="wrapper">

     
    <div  class="chatLineHolder" id="peoplebox">

    </div>

</div>







</div>   <!-- CONTENT CONTENT -->




<!--нижнее  меню --------------------------------------------------------------------------------- -->
<div class="horizontal-menu-padding">  <!--<div class="horizontal-menu-padding visible-xs"> -->

<div class="horizontal-menu ">    <!-- #horizontal menu -->


 
     <?php
    include ("../menu_horizontal.php");
    ?>
   
  
</div>                             <!-- horizontal-menu -->
<!--нижнее  меню -----конец---------------------------------------------------------------------------- -->


</div>                      <!--<div class="horizontal-menu-padding visible-xs"> -->



<div class="pagefooter">



  <!-- footer -->
     <?php
    include ("../footer.php");
    ?>
   


</div> <!--"pagefooter"-->


</div>                                   <!-- тело -->

</div>                                     <!-- контейнер -->



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">

// этот скрипт запрашивает чат из базы данных и создает html в div #chatbox


// mesure the height for scrolling down messages
var scrollHeight = $("#peoplebox").attr("scrollHeight") - 20;


// jQuery Document
$(document).ready(function(){




// scroll down all the messages after first load
$("#peoplebox").animate({ scrollTop: scrollHeight }, 'normal');

/*

the db table columns MUST be in order:

                               Table "public.people"
    Column    |  Type   | Collation | Nullable |              Default               
--------------+---------+-----------+----------+------------------------------------
 id           | integer |           | not null | nextval('people_id_seq'::regclass)
 userid       | text    |           |          | 
 email        | text    |           |          | 
 name         | text    |           |          | 
 password     | text    |           |          | 
 photo        | text    |           |          | 
 ssid         | text    |           |          | 
 bssid        | text    |           |          | 
 wifiid       | text    |           |          | 
 onlinestatus | text    |           |          | 
Indexes:
    "people_pkey" PRIMARY KEY, btree (id)



*/	
	
//declare method loadLog() that loads the file containing the chat log and scroll down if there are new messages
	function loadLog(){
		// mesure Scroll height before the request
		var oldscrollHeight = $("#peoplebox").attr("scrollHeight") - 20;
	
    //-----------------------------------------------------------------------
    // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
    //-----------------------------------------------------------------------
    $.ajax({                                      
      url: "people_request.php",         //the script to call to get data          
      data: "",                        //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
      dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {

       // по приходу разбираем весь массив на строчки и колонки и создаем html
       var i, len;
       var allPeople = "";
       for (i = 0, len = data.length; i < len; ++i)
        {
        //все сообщение одной строкой
        var personRow = data[i];
        
        //отдельные колонки 
        var personID = data[i][1];		
        var personName = data[i][3];
        var personOnlineStatus = data[i][9];
        var personPhoto = data[i][5];
 
     //--------------------------------------------------------------------
     // 3) Update html content добавляем сообщения в html одно за другим
     //--------------------------------------------------------------------
        allPeople+=


"<div><a href = '../user/person.php?id="+personID+"'><img src='../crop/user_photos/"+personPhoto+".png' width='128' height='96'></div><div>"+personName+"</div><div>"+personOnlineStatus+"<a></div>"



        }
        
      $("#peoplebox").html(allPeople); 
      //Set output element html
      //recommend reading up on jquery selectors they are awesome 
      // http://api.jquery.com/category/selectors/
        
      //Auto-scroll
      //mesure Scroll height after the request
      var newscrollHeight = $("#peoplebox").attr("scrollHeight") - 20; 
      if(newscrollHeight > oldscrollHeight){
      //Autoscroll to bottom of div
      $("#peoplebox").animate({ scrollTop: newscrollHeight }, 'normal'); 
      } 

      } 
    });
	
	
	



	
	}
	
//Reload file every 2500 ms or x ms if you wish	
setInterval (loadLog, 5000);	
	
});




</script>



</body>
</html>



