<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_tipousuario(){
	global $tof_tipousuario;
	$name_tpl="listar_tipousuario.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Tipos usuario");
	$t->set_var("categoria_modulo", "usuarios");

	$result=mysql_query("select * from ".$tof_tipousuario);

	$t->set_block("pl","block_tipousuario","_block_tipousuario");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_tipousuario",$row[nombre]);
	  $t->set_var("cantidad_productos",$row[cant_productos]);
	  $t->set_var("publicado_tipousuario",$row[publicado]);
  	  $t->set_var("id_tipousuario",$row[id]);
      $t->parse("_block_tipousuario","block_tipousuario",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_tipousuario(){
	global $tof_tipousuario, $id_usuario;
	$name_tpl="insertar_tipousuario.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Tipo Usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_tipousuario_ok(){
	global $tof_tipousuario,$nombre_tipousuario,$publicado_tipousuario,$cantidad_destacados,$cantidad_productos;

	if (isset($publicado_tipousuario))
		$publicado_tipousuario=1;
	else
		$publicado_tipousuario=0;
		mysql_query("insert into ".$tof_tipousuario." values('NULL','".$nombre_tipousuario."',".$cantidad_destacados.",".$cantidad_productos.",".$publicado_tipousuario.")");
		
	listar_tipousuario();
}

function editar_tipousuario(){
	global $tof_tipousuario, $id_tipousuario;
	$name_tpl="editar_tipousuario.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Tipo Usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select * from ".$tof_tipousuario." where id=".$id_tipousuario);
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_tipousuario",$row[id]);
	$t->set_var("nombre_tipousuario",$row[nombre]);
	$t->set_var("cantidad_destacados",$row[cant_destacados]);
	$t->set_var("cantidad_productos",$row[cant_productos]);
	$t->set_var("publicado_tipousuario",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_tipousuario_ok(){
	global $tof_tipousuario,$id_tipousuario,$nombre_tipousuario,$publicado_tipousuario,$cantidad_destacados,$cantidad_productos;

	if (isset($publicado_tipousuario))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_tipousuario." set nombre='".$nombre_tipousuario."',cant_destacados=".$cantidad_destacados.",cant_productos=".$cantidad_productos.",publicado=".$publicado." where id=".$id_tipousuario);
			
	listar_tipousuario();
}

function eliminar_tipousuario(){
	global $tof_tipousuario, $id_tipousuario;
	$name_tpl="eliminar_tipousuario.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Tipo Usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select * from ".$tof_tipousuario." where id=".$id_tipousuario);
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_tipousuario",$row[id]);	
	$t->set_var("nombre_tipousuario",$row[nombre]);

	$t->set_var("publicado_tipousuario",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_tipousuario_ok(){
	global $tof_tipousuario,$id_tipousuario;

	mysql_query("delete from ".$tof_tipousuario." where id='".$id_tipousuario."'");
	mysql_query("update ".$tof_usuarios_sistema." set id_tipousuario=0 where id_tipousuario='".$id_tipousuario."'");
		
	listar_tipousuario();
}


?>

