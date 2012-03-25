<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_grupos_contactos(){
	global $tof_grupos_contactos,$row_per_page,$page;
	$name_tpl="listar_grupos_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Grupos contactos");
	$t->set_var("categoria_modulo", "grupos contactos");

	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
		
	$result=mysql_query("select * from ".$tof_grupos_contactos." order by nombre_grupo limit ".$inicio.",".$row_per_page);

	$t->set_block("pl","block_grupos_contactos","_block_grupos_contactos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_grupo_contacto",$row[nombre_grupo]);
      $t->set_var("id_grupo_contacto",$row[id]);
      $t->parse("_block_grupos_contactos","block_grupos_contactos",true);
    }
	
	$resultcant=mysql_query("select count(*) as cant from  ".$tof_grupos_contactos);
			
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


function insertar_grupos_contactos(){
	global $id_grupo;
	$name_tpl="insertar_grupos_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Grupos Contacto");
	$t->set_var("categoria_modulo", "grupos contactos");

	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_grupos_contactos_ok(){
	global $tof_grupos_contactos,$nombre_grupo_contacto,$idioma;

	mysql_query("insert into ".$tof_grupos_contactos." values('NULL','".$nombre_grupo_contacto."')");
	listar_grupos_contactos();
}

function editar_grupos_contactos(){
	global $tof_grupos_contactos,$id_grupo_contacto;
	$name_tpl="editar_grupos_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Grupos Contactos");
	$t->set_var("categoria_modulo", "grupos contactos");

	$result1=mysql_query("select * from ".$tof_grupos_contactos." where id=".$id_grupo_contacto);
	$row1=mysql_fetch_array($result1);

	$t->set_var("nombre_grupo_contacto",$row1[nombre_grupo]);
	$t->set_var("id_grupo_contacto",$id_grupo_contacto);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_grupos_contactos_ok(){
	global $tof_grupos_contactos,$nombre_grupo_contacto,$id_grupo_contacto,$idioma;

	mysql_query("update ".$tof_grupos_contactos." set nombre_grupo='".$nombre_grupo_contacto."' where id=".$id_grupo_contacto);
			
	listar_grupos_contactos();
}


function eliminar_grupos_contactos(){
	global $tof_grupos_contactos,$id_grupo_contacto;
	$name_tpl="eliminar_grupos_contactos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Grupo Contacto");
	$t->set_var("categoria_modulo", "grupo contactos");

	$result=mysql_query("select * from ".$tof_grupos_contactos." where id=".$id_grupo_contacto);
	$row=mysql_fetch_array($result);
    
	$t->set_var("nombre_grupo_contacto",$row[nombre_grupo]);
	$t->set_var("id_grupo_contacto",$id_grupo_contacto);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_grupos_contactos_ok(){
	global $tof_grupos_contactos,$tof_contactos,$id_grupo_contacto;

	mysql_query("delete from ".$tof_grupos_contactos." where id=".$id_grupo_contacto);
	mysql_query("update ".$tof_contactos." set id_grupo_contacto=0 where id_grupo_contacto=".$id_grupo_contacto);
			
    listar_grupos_contactos();
}


?>

