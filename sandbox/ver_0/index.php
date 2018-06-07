<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){
		header("Location: user_login.php");}
	
	
	else {
	// если нет фото у пользователя, редирект на страницу /croppic/photo.php  
    if ((!isset($_SESSION['photo'])) or ($_SESSION['photo'] === "")){header("Location: croppic/user_photo.php");}
	}

	
    ?>

<html> 
<head> 
<title>wi.knot</title>

<meta name="viewport" content="width=device-width">
 
</head> 

<link rel='stylesheet' href='/css/bootstrap.min.css' type='text/css' media='all'>
<link rel="stylesheet" type="text/css" href="style.css">


<style type="text/css">



</style>


<body>

 <div>
 <center>
 <img src="../images/logo_tilted_wite_text_original.png" height="" width="90%" align="center">
 </center>
 </div>


   <div id="menu"> 
    <table Border=0  CellSpacing=5 CellPadding=5 Width="90%" Align="center" vAlign="">
     <tr height="%">
     <td><a href="chat.php" ><img src="../images/discuss.png" height="80"><a></td> 
     <td></td> 
     <td></td>
     <td></td>
     <td></td>
     </tr>
     <tr height="%">
     <td><font size=5><a href="chat.php" >discuss this place<a></font></td> 
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


</body> 
</html>
