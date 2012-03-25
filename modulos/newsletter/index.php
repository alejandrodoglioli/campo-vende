<?PHP
function subscribirse_newsletter($nombre_contacto,$apellido_contacto,$email_contacto){
	global $tof_contactos,$idioma;
	$name_tpl="gracias-newsletter.htm";
	$t = new Template("modulos/newsletter/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	mysql_query("insert into ".$tof_contactos." values('NULL','".$nombre_contacto."','".$apellido_contacto."','".$email_contacto."','".$idioma."',0)");
	
	$t->set_var("titulo","Subscripción Newsletter");
	$t->set_var("nombre_contacto", $nombre_contacto);
	$t->set_var("apellido_contacto", $apellido_contacto);
	$t->set_var("email_contacto", $email_contacto);

	$t->set_var("breadcrum", ' >> Gracias Newsletter');
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

?>
