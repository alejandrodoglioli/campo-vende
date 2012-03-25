<?PHP
function mostrar_enlaces(){
	global $tof_enlaces,$idioma,$tof_modulos,$tof_modulosxidioma,$idioma;
	$name_tpl="enlaces.htm";
	$t = new Template("modulos/enlaces/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$resultm=mysql_query("select m.path,mi.nombre from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."' and path='enlaces'");
	$row1=mysql_fetch_array($resultm);
	 
	
	$t->set_var("titulo", $row1[nombre]);
	$t->set_var("title", $row1[nombre]);

	$t->set_var("description", $row1[nombre]);
	$t->set_var("keywords", $row1[nombre]);
	$t->set_var("idioma", $idioma);
	
	$result=mysql_query("select ni.titulo,ni.url,ni.descripcion from ".$tof_enlaces." ni where ni.publicado=1 order by orden");

	$t->set_block("pl","block_websamigas","_block_websamigas");	
	while($row=mysql_fetch_array($result)){
		$t->set_var("titulo_webamigas", $row[titulo]);
		$t->set_var("url_webamigas", $row[url]);
		$t->set_var("descripcion_webamigas", $row[descripcion]);
		$t->parse("_block_websamigas","block_websamigas",true);
	}
	
	$t->set_var("breadcrum", ' >> '.$row1[nombre]);
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

?>
