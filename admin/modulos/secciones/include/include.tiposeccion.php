<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_tiposeccion(){
	global $tof_tiposeccion;
	$name_tpl="listar_tiposeccion.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Tipos Sección");
	$t->set_var("categoria_modulo", "Secciones");

	$result=mysql_query("select * from ".$tof_tiposeccion);

	$t->set_block("pl","block_tiposeccion","_block_tiposeccion");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_tiposeccion",$row[nombre]);
	  $t->set_var("id_tiposeccion",$row[id]);
	  $t->set_var("publicado_tiposeccion",$row[publicado]);
      $t->parse("_block_tiposeccion","block_tiposeccion",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_tiposeccion(){
	global $tof_tiposeccion, $id_usuario;
	$name_tpl="insertar_tiposeccion.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Tipo Sección");
	$t->set_var("categoria_modulo", "Secciones");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_tiposeccion_ok(){
	global $tof_tiposeccion,$nombre_tiposeccion,$publicado_tiposeccion;

	if (isset($publicado_tiposeccion))
		$publicado_tiposeccion=1;
	else
		$publicado_tiposeccion=0;
		mysql_query("insert into ".$tof_tiposeccion." values('NULL','".$nombre_tiposeccion."',".$publicado_tiposeccion.")");
		
	listar_tiposeccion();
}

function editar_tiposeccion(){
	global $tof_tiposeccion, $id_tiposeccion;
	$name_tpl="editar_tiposeccion.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Tipo Sección");
	$t->set_var("categoria_modulo", "Secciones");

	$result=mysql_query("select * from ".$tof_tiposeccion." where id='".$id_tiposeccion."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_tiposeccion",$row[id]);
	$t->set_var("nombre_tiposeccion",$row[nombre]);
	$t->set_var("publicado_tiposeccion",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_tiposeccion_ok(){
	global $tof_tiposeccion,$id_tiposeccion,$nombre_tiposeccion,$publicado_tiposeccion;

	if (isset($publicado_tiposeccion))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_tiposeccion." set nombre='".$nombre_tiposeccion."',publicado=".$publicado." where id='".$id_tiposeccion."'");
			
	listar_tiposeccion();
}

function eliminar_tiposeccion(){
	global $tof_tiposeccion, $id_tiposeccion;
	$name_tpl="eliminar_tiposeccion.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Tipo Sección");
	$t->set_var("categoria_modulo", "Secciones");

	$result=mysql_query("select * from ".$tof_tiposeccion." where id='".$id_tiposeccion."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_tiposeccion",$row[id]);	
	$t->set_var("nombre_tiposeccion",$row[nombre]);
	$t->set_var("publicado_tiposeccion",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_tiposeccion_ok(){
	global $tof_tiposeccion,$id_tiposeccion;

	mysql_query("delete from ".$tof_tiposeccion." where id='".$id_tiposeccion."'");
	mysql_query("update ".$tof_secciones." set id_tiposeccion=0 where id_tiposeccion='".$id_tiposeccion."'");
		
	listar_tiposeccion();
}


?>

