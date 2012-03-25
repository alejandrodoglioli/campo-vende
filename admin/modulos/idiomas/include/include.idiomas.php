<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_idiomas(){
	global $tof_idioma;
	$name_tpl="listar_idiomas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Idiomas");
	$t->set_var("categoria_modulo", "Idiomas");

	$result=mysql_query("select * from ".$tof_idioma);

	$t->set_block("pl","block_idiomas","_block_idiomas");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_idioma",$row[nombre]);
	  $t->set_var("id_idioma",$row[idioma]);
	  $t->set_var("publicado_idioma",$row[publicado]);
      $t->parse("_block_idiomas","block_idiomas",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_idiomas(){
	global $tof_idioma, $id_usuario;
	$name_tpl="insertar_idiomas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Idioma");
	$t->set_var("categoria_modulo", "Idiomas");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_idiomas_ok(){
	global $tof_idioma,$nombre_idioma,$prefijo_idioma,$nombre_imagen_idioma,$orden_idioma,$publicado_idioma;

	if (isset($publicado_idioma))
		$publicado_idioma=1;
	else
		$publicado_idioma=0;
		mysql_query("insert into ".$tof_idioma." values('".$prefijo_idioma."','".$nombre_idioma."','".$nombre_imagen_idioma."',".$orden_idioma.",".$publicado_idioma.")");
		
	listar_idiomas();
}

function editar_idiomas(){
	global $tof_idioma, $id_idioma;
	$name_tpl="editar_idiomas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar idiomas");
	$t->set_var("categoria_modulo", "Idiomas");

	$result=mysql_query("select * from ".$tof_idioma." where idioma='".$id_idioma."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_idioma",$row[idioma]);
	$t->set_var("nombre_idioma",$row[nombre]);
	$t->set_var("nombre_imagen_idioma",$row[nombre_imagen]);
	$t->set_var("orden_idioma",$row[orden]);
	$t->set_var("publicado_idioma",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_idiomas_ok(){
	global $tof_idioma,$id_idioma,$prefijo_idioma,$nombre_idioma,$nombre_imagen_idioma,$orden_idioma,$publicado_idioma;

	if (isset($publicado_idioma))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_idioma." set idioma='".$prefijo_idioma."',nombre='".$nombre_idioma."',nombre_imagen='".$nombre_imagen_idioma."',orden=".$orden_idioma.",publicado=".$publicado." where idioma='".$id_idioma."'");
			
	listar_idiomas();
}

function eliminar_idiomas(){
	global $tof_idioma, $id_idioma;
	$name_tpl="eliminar_idiomas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Idioma");
	$t->set_var("categoria_modulo", "Idiomas");

	$result=mysql_query("select * from ".$tof_idioma." where idioma='".$id_idioma."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_idioma",$row[idioma]);	
	$t->set_var("nombre_idioma",$row[nombre]);
	$t->set_var("nombre_imagen_idioma",$row[nombre_imagen]);	
	$t->set_var("publicado_idioma",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_idiomas_ok(){
	global $tof_idioma,$id_idioma;

	mysql_query("delete from ".$tof_idioma." where idioma='".$id_idioma."'");
		
	listar_idiomas();
}


?>

