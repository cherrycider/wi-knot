<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();

    // если имя не установлено, редирект на страницу авторизации  
    if (!isset($_SESSION['name'])){header("Location: user_login.php");}

    ?>


<html>
<head>
<title>wi.knot chat</title> 
	
<meta name="viewport" content="width=device-width">
	
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel='stylesheet' href='/css/bootstrap.min.css' type='text/css' media='all'>

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
  <h2>discuss this place</h2>
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
