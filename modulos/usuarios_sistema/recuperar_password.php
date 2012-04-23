<?php 	
echo "pepe";exit;
	include_once("include/mail.php");
	$From = "vizzito@hotmail.com";
	$FromName = "vizzito@hotmail.com";
	$To= "martinvizzolini@gmail.com";
	$body = "lallalalalla";
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