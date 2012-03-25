<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_tipoproducto(){
	global $tof_tipoproducto;
	$name_tpl="listar_tipoproducto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Tipos producto");
	$t->set_var("categoria_modulo", "productos");

	$result=mysql_query("select * from ".$tof_tipoproducto);

	$t->set_block("pl","block_tipoproducto","_block_tipoproducto");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_tipoproducto",$row[nombre]);
	  $t->set_var("id_tipoproducto",$row[id]);
	  $t->set_var("publicado_tipoproducto",$row[publicado]);
      $t->parse("_block_tipoproducto","block_tipoproducto",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_tipoproducto(){
	global $tof_tipoproducto, $id_usuario;
	$name_tpl="insertar_tipoproducto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Tipo producto");
	$t->set_var("categoria_modulo", "productos");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_tipoproducto_ok(){
	global $tof_tipoproducto,$nombre_tipoproducto,$publicado_tipoproducto;

	if (isset($publicado_tipoproducto))
		$publicado_tipoproducto=1;
	else
		$publicado_tipoproducto=0;
		mysql_query("insert into ".$tof_tipoproducto." values('NULL','".$nombre_tipoproducto."',".$publicado_tipoproducto.")");
		
	listar_tipoproducto();
}

function editar_tipoproducto(){
	global $tof_tipoproducto, $id_tipoproducto;
	$name_tpl="editar_tipoproducto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Tipo producto");
	$t->set_var("categoria_modulo", "productos");

	$result=mysql_query("select * from ".$tof_tipoproducto." where id='".$id_tipoproducto."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_tipoproducto",$row[id]);
	$t->set_var("nombre_tipoproducto",$row[nombre]);
	$t->set_var("publicado_tipoproducto",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_tipoproducto_ok(){
	global $tof_tipoproducto,$id_tipoproducto,$nombre_tipoproducto,$publicado_tipoproducto;

	if (isset($publicado_tipoproducto))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_tipoproducto." set nombre='".$nombre_tipoproducto."',publicado=".$publicado." where id='".$id_tipoproducto."'");
			
	listar_tipoproducto();
}

function eliminar_tipoproducto(){
	global $tof_tipoproducto, $id_tipoproducto;
	$name_tpl="eliminar_tipoproducto.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Tipo producto");
	$t->set_var("categoria_modulo", "productos");

	$result=mysql_query("select * from ".$tof_tipoproducto." where id='".$id_tipoproducto."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_tipoproducto",$row[id]);	
	$t->set_var("nombre_tipoproducto",$row[nombre]);
	$t->set_var("publicado_tipoproducto",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_tipoproducto_ok(){
	global $tof_tipoproducto,$id_tipoproducto;

	mysql_query("delete from ".$tof_tipoproducto." where id='".$id_tipoproducto."'");
	mysql_query("update ".$tof_productos." set id_tipoproducto=0 where id_tipoproducto='".$id_tipoproducto."'");
		
	listar_tipoproducto();
}


?>

