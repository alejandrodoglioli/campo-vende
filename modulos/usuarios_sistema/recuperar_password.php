<?php 	


    $name_tpl="gracias-comentario.htm";
	$t = new Template("modulos/productos/templates", "remove");
	$t->set_file("pl", $name_tpl);

	setearMenu(&$t);
	setearVariablesComunes(&$t);

	
	include_once("include/mail.php");
	$From = "vizzito@hotmail.com";
	$FromName = "vizzito@hotmail.com";
	$To= "martinvizzolini@gmail.com";
	$emailto= "martinvizzolini@gmail.com";
	$body = "lallalalalla";
	$subject = "prueva";
	$resultado=enviar_email($From,$FromName,$To,$body,$subject,$emailto);
	if($resultado==0){
		?>
		<script language="JavaScript" type="text/javascript">
			alert("Error: no se pede enviar email.");	
			history.back(1);
		</script>
		<?
	
	}else{
		$t->parse("MAIN", "pl");
		$t->p("MAIN");
	}
?>