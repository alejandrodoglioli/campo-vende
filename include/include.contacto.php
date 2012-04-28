<?PHP

function caracter_aleatorio() {
	mt_srand((double)microtime()*1000000);
	$valor_aleatorio = mt_rand(1,2);
	switch ($valor_aleatorio) {
		case 1:
			$valor_aleatorio = mt_rand(97, 122);
			break;
		case 2:
			$valor_aleatorio = mt_rand(48, 57);
			break;
	/*	case 3:
			$valor_aleatorio = mt_rand(65, 90);
			break;*/
	}
	return chr($valor_aleatorio);
}

function mostrar_contacto(){
	global $tof_configuracion;
	
	$name_tpl="contacto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$t->set_var("title", "Contacto");
	$t->set_var("titulo", "Contacto");
	
	$t->set_var("breadcrumb", ' >> Contacto');
	
	$result=mysql_query("select nombre_empresa,mail_empresa from ".$tof_configuracion." where id=0");
	$row=mysql_fetch_array($result);
	
	$t->set_var("empresa", $row[nombre_empresa]);
	$t->set_var("mail_empresa", $row[mail_empresa]);
			
	$captcha_texto = "";
	for ($i = 1; $i <= 6; $i++) {
		$captcha_texto .= caracter_aleatorio();
	}

	$t->set_var("SID",$SID);
	$t->set_var("captcha_texto_session",$captcha_texto);
			
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function enviar_contacto(){
		global $tof_configuracion,$nombre, $email, $comentario,$idioma;

		$comentario=nl2br(htmlentities($comentario));
		$body=  "Nombre y Apellido: ". $nombre."<br>";
		$body.="Email: ". $email."<br>";

		$body.="Comentario: ". $comentario."<br>";		
		
		$subject="Ferries A - Formulario de Contacto";
		
		$result=mysql_query("select nombre_empresa,mail_empresa from ".$tof_configuracion." where id=0");
		$row=mysql_fetch_array($result);
		
		$From=$row[mail_empresa];
		$FromName=$row[nombre_empresa];
		$To=$row[mail_empresa];
		
		include_once("mail.php");
		$resultado=enviar_email($From,$FromName,$To,$body,$subject,$email);
		if($resultado==0){
			?>
			<script language="JavaScript" type="text/javascript">
				alert("Error: no puede dejar campos vacios.");	
				history.back(1);
			</script>
			<?
		
		}else{
			header('location:/'.$idioma.'/gracias-contacto.htm');
		}
	}
	
function gracias_contacto(){
	global $tof_configuracion;
	
	$name_tpl="gracias_contacto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$t->set_var("title", "Gracias Contacto");
	$t->set_var("titulo", "Gracias Contacto");
	$t->set_var("breadcrumb", ' >> <a href="/'.$idioma.'/contacto.htm" title="Contacto">Contacto</a> >> Gracias Contacto');
	
	$result=mysql_query("select nombre_empresa from ".$tof_configuracion." where id=0");
	$row=mysql_fetch_array($result);
	
	$t->set_var("empresa", $row[nombre_empresa]);
			
	setearMenu(&$t);
	setearVariablesComunes(&$t);

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}
?>