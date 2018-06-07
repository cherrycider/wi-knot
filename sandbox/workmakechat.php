<div style="width: 600px; margin: 0 auto;">
  <form action="addMessage.php" method="post">
  Ваше имя:<br />
  <input type="text" name="guestName" placeholder="Ваше имя" style="width: 100%;"><br /><br />
 
  Текст вашей записи в гостевой книге:<br />
  <textarea name="messageText" placeholder="Текст сообщения" style="width: 100%; height: 100px;">
  </textarea><br /><br />
 
  <input type="submit" value="Оставить сообщение в гостевой книге!" style="width: 100%;">
  </form>
 
  <?php
  // подключаемся к нашей базе данных
  $connect = new mysqli('localhost', 'root', '', 'guestbook');
  // получаем список всех сообщений
  $result = $connect->query("select * from guestbook");
  // вычисляем количество полученных записей
  $countMessage = $result->num_rows;
 
  // если количество записей в базе данных больше 0, то выводим их
  if($countMessage > 0)
  {
    // просматриваем весь массив полученных данных
    for($i = 0; $i < $countMessage; $i++)
    {
      echo '<div style="border: 1px solid green;">';
      // извлекаем данные
      $message = $result->fetch_object();
 
      // выводим в нужной нам форме
      echo "<b>".$message->guestbook_user_name.": </b><br />";
      echo $message->guestbook_message_text."<br />";
      echo "Дата: ".$message->guestbook_data."<br />";
      echo '</div><br />';
    }
  }
  ?>
</div>