      <h3>
	    <a href = "../user/user_profile.php"><?php
          // выводим имя пользователя внизу в центре, 
          // если имя не установлено, редирект на страницу авторизации  
           if (isset($_SESSION['name'])){echo "".$_SESSION['name']."";}
           else {echo "you are not logged now";}  
         ?>
        <a>
 
      <h3>

