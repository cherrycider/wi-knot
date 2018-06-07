<?php
/*
*	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
*/


    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте.
    // Очень важно запустить их в  самом начале странички!!!
    session_start();
	
	    // если имя не установлено, редирект на страницу авторизации  
    //if (!isset($_SESSION['name'])){header("Location: user_login.php");}
	
	//заносим введенный пользователем логин в переменную $email, если он пустой, то уничтожаем переменную
	//if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; if ($userID == '') { unset($userID);} } 
    


$imgUrl = $_POST['imgUrl'];
// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 100;

//$output_filename = "temp/croppedImg_".rand();

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();



// отправляем готовые обрезанные файлы в папку /photos 
// заполняем параметр сессии, пользователь имеет фото




	$photo_file_name = $_SESSION['userID']; 
	$output_filename = "photos/"."{$photo_file_name}";


	    // подключаемся к базе
    include ("../db_connection.php");
    // файл db_connection.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
    // проверка на существование пользователя с таким же email/паролем
    // уникальный userID состоит из комбинации email пароль, его будем проверять
	
	
    //дописываем имя файла в бд пользователя с таким же userID
	
    $query = "UPDATE people SET photo = '$photo_file_name' WHERE userID='$photo_file_name'";
    $result = mysqli_query ($db, $query);

    // проверяем удачно ли соединились с базой 
    if (!$result) {die("sorry, something went wrong with the website, database update failed");}
	    
            
     // изменяем параметры сессии, говорим, что у нас есть фото
     $_SESSION['photo'] = $photo_file_name;
	



$what = getimagesize($imgUrl);

switch(strtolower($what['mime']))
{
    case 'image/png':
        $img_r = imagecreatefrompng($imgUrl);
		$source_image = imagecreatefrompng($imgUrl);
		$type = '.png';
        break;
    case 'image/jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
		$source_image = imagecreatefromjpeg($imgUrl);
		error_log("jpg");
		$type = '.jpeg';
        break;
    case 'image/gif':
        $img_r = imagecreatefromgif($imgUrl);
		$source_image = imagecreatefromgif($imgUrl);
		$type = '.gif';
        break;
    default: die('image type not supported');
}


//Check write Access to Directory

if(!is_writable(dirname($output_filename))){
	$response = Array(
	    "status" => 'error',
	    "message" => 'Can`t write cropped File'
    );	
}else{

    // resize the original image to size of editor
    $resizedImage = imagecreatetruecolor($imgW, $imgH);
	imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
    // rotate the rezized image
    $rotated_image = imagerotate($resizedImage, -$angle, 0);
    // find new width & height of rotated image
    $rotated_width = imagesx($rotated_image);
    $rotated_height = imagesy($rotated_image);
    // diff between rotated & original sizes
    $dx = $rotated_width - $imgW;
    $dy = $rotated_height - $imgH;
    // crop rotated image to fit into original rezized rectangle
	$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
	imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
	imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
	// crop image into selected area
	$final_image = imagecreatetruecolor($cropW, $cropH);
	imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
	imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
	// finally output png image
	//imagepng($final_image, $output_filename.$type, $png_quality);
	imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
	$response = Array(
	    "status" => 'success',
	    "url" => $output_filename.$type
    );
}
print json_encode($response);
