<?

//creamos la imagen definiendo el tamaño del alto y el ancho (150, 40)
$captcha_imagen = imagecreate(150,30);

//creamos el color negro para el fondo y blanco para los caracteres
$color_negro = imagecolorallocate ($captcha_imagen, 0, 0, 0);
$color_blanco = imagecolorallocate ($captcha_imagen, 255, 255, 255);

//pintamos el fondo con el cplor negro creado anteriormente
imagefill($captcha_imagen, 0, 0, $color_negro);

//iniciamos la session para obtener los caracteres a dibujar
//session_start();
//$captcha_texto = $HTTP_SESSION_VARS["captcha_texto_session"];
global $captcha_texto;

//dibujamos los caracteres de color blanco
imagechar($captcha_imagen, 4, 20, 10, $captcha_texto[0] ,$color_blanco);
imagechar($captcha_imagen, 5, 40, 10, $captcha_texto[1] ,$color_blanco);
imagechar($captcha_imagen, 3, 60, 10, $captcha_texto[2] ,$color_blanco);
imagechar($captcha_imagen, 4, 80, 10, $captcha_texto[3] ,$color_blanco);
imagechar($captcha_imagen, 5, 100, 10, $captcha_texto[4] ,$color_blanco);
imagechar($captcha_imagen, 3, 120, 10, $captcha_texto[5] ,$color_blanco);

//indicamos que lo que vamos a mostrar es una imagen
header("Content-type: image/jpeg");

//mostramos la imagen
imagejpeg($captcha_imagen);

?>