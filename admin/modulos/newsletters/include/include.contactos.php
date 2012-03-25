<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_contactos(){
	global $tof_contactos,$tof_grupos_contactos,$tof_contactosxidioma,$id_grupo,$row_per_page,$page;
	$name_tpl="listar_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar contactos");
	$t->set_var("categoria_modulo", "contactos");
	
	$t->set_var("action", "listar_contactos");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	if(isset($id_grupo) and ($id_grupo<>0)){
		$result=mysql_query("select c.*,gc.nombre_grupo from ".$tof_contactos." c left join ".$tof_grupos_contactos." gc on (c.id_grupo_contacto=gc.id) where gc.id=".$id_grupo." order by nombre limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_contactos." c left join ".$tof_grupos_contactos." gc on (c.id_grupo_contacto=gc.id) where gc.id=".$id_grupo);
		}
	else{
		$result=mysql_query("select c.*,gc.nombre_grupo from ".$tof_contactos." c left join ".$tof_grupos_contactos." gc on (c.id_grupo_contacto=gc.id) order by nombre limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_contactos." c left join ".$tof_grupos_contactos." gc on (c.id_grupo_contacto=gc.id)");
		}
	
	$t->set_block("pl","block_contactos","_block_contactos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_contacto",$row[nombre]);
      $t->set_var("email_contacto",$row[email]);
	   $t->set_var("grupo_contacto",$row[nombre_grupo]);
      $t->set_var("id_contacto",$row[id]);
      $t->parse("_block_contactos","block_contactos",true);
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
	
	$result=mysql_query("select * from ".$tof_grupos_contactos);
	$t->set_block("pl","block_grupos","_block_grupos");	
    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_grupo",$row[id]);
		$t->set_var("nombre_grupo",$row[nombre_grupo]);
		if($row[id]==$id_grupo)
			$t->set_var("selected_grupos","selected");
		else
			$t->set_var("selected_grupos","");
		$t->parse("_block_grupos","block_grupos",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_contactos(){
	global $tof_idioma, $tof_grupos_contactos,$id_usuario;
	$name_tpl="insertar_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Contacto");
	$t->set_var("categoria_modulo", "contactos");
	
	$result=mysql_query("select id,nombre_grupo from ".$tof_grupos_contactos);
	$t->set_block("pl","block_grupo_contacto","_block_grupo_contacto");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("nombre_grupo_contacto", $row[nombre_grupo]);
		$t->set_var("id_grupo_contacto", $row[id]);
		$t->parse("_block_grupo_contacto","block_grupo_contacto",true);
	}
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	
	$t->set_block("pl","block_idiomas","_block_idiomas");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_contacto", $row[idioma]);
		$t->parse("_block_idiomas","block_idiomas",true);
	}

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_contactos_ok(){
	global $tof_contactos,$nombre_contacto,$idioma,$apellido_contacto,$email_contacto,$grupo_contacto;

	mysql_query("insert into ".$tof_contactos." values('NULL','".$nombre_contacto."','".$apellido_contacto."','".$email_contacto."','".$idioma."',".$grupo_contacto.")");
	listar_contactos();
}

function editar_contactos(){
	global $tof_idioma, $tof_contactos,$tof_grupos_contactos,$id_contacto;
	$name_tpl="editar_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar contactos");
	$t->set_var("categoria_modulo", "contactos");

	$result1=mysql_query("select * from ".$tof_contactos." where id=".$id_contacto);
	$row1=mysql_fetch_array($result1);
	
	$result2=mysql_query("select id,nombre_grupo from ".$tof_grupos_contactos);
	$t->set_block("pl","block_grupo_contacto","_block_grupo_contacto");	
    while($row2=mysql_fetch_array($result2)){
		$t->set_var("nombre_grupo_contacto", $row2[nombre_grupo]);
		$t->set_var("id_grupo_contacto", $row2[id]);
		if ($row1[id_grupo_contacto]==$row2[id]){
			$t->set_var("selected", "selected");
		}else{
			$t->set_var("selected", "");
		}
		
		$t->parse("_block_grupo_contacto","block_grupo_contacto",true);
	}
	
	$result=mysql_query("select * from ".$tof_idioma." where publicado=1");
	
	$t->set_block("pl","block_idiomas","_block_idiomas");	
	 while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_contacto", $row[idioma]);
		if ($row[idioma]=$row1[idioma]){
			$t->set_var("selected", "selected");
		}
		$t->parse("_block_idiomas","block_idiomas",true);
	}

	$t->set_var("nombre_contacto",$row1[nombre]);
	$t->set_var("apellido_contacto",$row1[apellido]);
	$t->set_var("email_contacto",$row1[email]);
	$t->set_var("id_contacto",$id_contacto);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_contactos_ok(){
	global $tof_contactos,$id_contacto,$nombre_contacto,$apellido_contacto,$email_contacto,$grupo_contacto,$idioma;

	mysql_query("update ".$tof_contactos." set nombre='".$nombre_contacto."',apellido='".$apellido_contacto."',email='".$email_contacto."',idioma='".$idioma."' ,id_grupo_contacto='".$grupo_contacto."' where id=".$id_contacto);
			
	listar_contactos();
}


function eliminar_contactos(){
	global $tof_contactos,$tof_grupos_contactos,$id_contacto;
	$name_tpl="eliminar_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Contacto");
	$t->set_var("categoria_modulo", "contactos");

	$result=mysql_query("select c.*,gc.nombre_grupo from ".$tof_contactos." c left join ".$tof_grupos_contactos." gc on (c.id_grupo_contacto=gc.id) where c.id=".$id_contacto);
	$row=mysql_fetch_array($result);
    
	$t->set_var("nombre_contacto",$row[nombre]);
	$t->set_var("apellido_contacto",$row[apellido]);
	$t->set_var("email_contacto",$row[email]);
	$t->set_var("nombre_grupo_contacto",$row[nombre_grupo]);
	$t->set_var("id_contacto",$id_contacto);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_contactos_ok(){
	global $tof_contactos,$id_contacto;

	mysql_query("delete from ".$tof_contactos." where id=".$id_contacto);
			
	listar_contactos();
}


?>

