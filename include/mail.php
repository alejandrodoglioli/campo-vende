<?php


function enviar_email($From,$FromName,$To,$body,$subject,$email){
	
	$recipiente= $To;
	$asunto= strip_tags($subject);
	$error = 0;
	//los campos mandados por el formulario
	$email = $email;
	$comentario = $body;
	
	//verificación si los campos requeridos estan llenos
	if($nombre == "" || $email == "" || $comentario == ""){
	   $error=0;
	}
		
	//mensajes de error
	if($error==1){
	   return 0;
	}
		
	//envio del email con los datos
	else{  
	   $message =$comentario."<br>";
	   
	   $message = stripslashes($message);
	   
	   $headers = "MIME-Version: 1.0\r\n";
	   $headers .= "Content-type:text/html; charset=iso-8859-1\r\n";
	   $headers .= "From: $From\r\n";
	   $headers .= "Reply-to: $From\r\n";
	   $headers .= "Cc: $email\r\n";
	   
	   mail($recipiente,$asunto,$message,$headers);
	
	   
	   //aqui puedes modificar los mensajes
	  // header("location:gracias-contacto.htm"); 
	
	   return 1;	
	}
}
?>
