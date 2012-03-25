<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");


function listar_feeds(){
	global $tof_feeds,$tof_feedsxidioma,$row_per_page,$page,$default_idioma;
	
	$name_tpl="listar_feeds.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar feeds");
	$t->set_var("categoria_modulo", "Feeds");

	$t->set_var("action", "listar_feeds");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	$result=mysql_query("select si.*,s.publicado from ".$tof_feeds." s join ".$tof_feedsxidioma." si on (s.id=si.id) order by nombre limit ".$inicio.",".$row_per_page);

	$resultcant=mysql_query("select count(*) as cant from ".$tof_feeds." s join ".$tof_feedsxidioma." si on (s.id=si.id)");
	$t->set_block("pl","block_feeds","_block_feeds");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("url_feed",$row[url]);
	  $t->set_var("idioma_feed",$row[idioma]);
      $t->set_var("publicado_feed",$row[publicado]);
      $t->set_var("id_feed",$row[id]);
	  $t->parse("_block_feeds","block_feeds",true);
    }


	$rowcant=mysql_fetch_array($resultcant);
	$nb=$rowcant[cant];
	$nb_page=intval(ceil($nb/$row_per_page));
	
	$t->set_var("page",$page);
	$t->set_var("cant_pages",$nb_page);
	$t->set_block("pl","block_paginas","_block_paginas");	
    for($i=1;$i <= $nb_page; $i++){
		$t->set_var("nro_pag",$i);
		if($i==$page)
			$t->set_var("selected_pag","selected");
		else
			$t->set_var("selected_pag","");
		$t->parse("_block_paginas","block_paginas",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_feeds(){
	global $tof_feeds,$tof_feedsxidioma,$tof_idioma;	
	
	$name_tpl="insertar_feeds.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Feeds");
	$t->set_var("categoria_modulo", "Feeds");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	

	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_feed", $row[idioma]);

		$t->parse("_block_idiomas1","block_idiomas1",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_feeds_ok(){
	global $tof_feeds, $tof_feedsxidioma,$idioma_feed,$nombre_feed,$url_feed,$fuente_feed,$tof_idioma;
	
	
	global $publicado;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	if (isset($menu_lateral))
		$menu_lateral=1;
	else
		$menu_lateral=0;	
	
	mysql_query("insert into ".$tof_feeds." values('NULL',".$publicado.")");
	$last_id = mysql_insert_id();
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	
 	mysql_query("insert into ".$tof_feedsxidioma." values(".$last_id.",'".$idioma_feed."','".$nombre_feed."','".$url_feed."','".$fuente_feed."')");

	listar_feeds();
}

function editar_feeds(){
	global $tof_feeds, $tof_feedsxidioma,$tof_idioma,$id_feed;
	$name_tpl="editar_feeds.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Feeds");
	$t->set_var("categoria_modulo", "Feeds");
	
	$result1=mysql_query("select si.*,s.publicado from ".$tof_feeds." s join ".$tof_feedsxidioma." si on (s.id=si.id) where s.id=".$id_feed);
	$row1=mysql_fetch_array($result1);
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");
	while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_feed", $row[idioma]);
		$t->set_var("idioma_feed", $row[idioma]);
		if ($row[idioma]==$row1[idioma])
			$t->set_var("selected", "selected");
		else
			$t->set_var("selected", "");
		$t->parse("_block_idiomas1","block_idiomas1",true);
	}
	$t->set_var("nombre_feed",$row1[nombre]);
	$t->set_var("url_feed",$row1[url]);
	$t->set_var("fuente_feed", $row1[fuente]);

	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';
		
	$t->set_var("publicado", $publicado);
	$t->set_var("id_feed", $id_feed);
	
					
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_feeds_ok(){
	global $tof_feeds, $tof_feedsxidioma,$tof_idioma,$id_feeds,$publicado,$nombre_feed,$url_feed,$fuente_feed,$id_feed,$idioma_feed;
	
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_feeds." set publicado=".$publicado." where id=".$id_feed);

 	mysql_query("update ".$tof_feedsxidioma." set idioma='".$idioma_feed."',nombre='".$nombre_feed."', url='".$url_feed."', fuente='".$fuente_feed."' where id=".$id_feed);
	
	
	listar_feeds();
}

function eliminar_feeds(){
	global $tof_feeds, $tof_feedsxidioma, $id_feed;
	$name_tpl="eliminar_feeds.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Feeds");
	$t->set_var("categoria_modulo", "Feeds");

	$result=mysql_query("select si.*,s.publicado from ".$tof_feeds." s join ".$tof_feedsxidioma." si on (s.id=si.id) where s.id=".$id_feed);
	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre_feed",$row[nombre]);
	$t->set_var("url_feed",$row[url]);
	$t->set_var("publicado_feed",$publicado);
	$t->set_var("id_feed",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_feeds_ok(){
	global $tof_feeds,$tof_feedsxidioma,$id_feed;

	mysql_query("delete from ".$tof_feeds." where id=".$id_feed);
	mysql_query("delete from ".$tof_feedsxidioma." where id=".$id_feed);

	listar_feeds();
}


?>

