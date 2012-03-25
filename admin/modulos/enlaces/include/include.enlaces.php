<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_enlaces(){
	global $tof_enlaces;
	$name_tpl="listar_enlaces.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar enlaces");
	$t->set_var("categoria_modulo", "enlaces");

	$result=mysql_query("select * from ".$tof_enlaces);

	$t->set_block("pl","block_enlaces","_block_enlaces");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("titulo_enlace",$row[titulo]);
	  $t->set_var("url_enlace",$row[url]);
	  $t->set_var("publicado_enlace",$row[publicado]);
	  $t->set_var("id_enlace",$row[id]);
      $t->parse("_block_enlaces","block_enlaces",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_enlaces(){
	global $tof_enlaces, $id_usuario;
	$name_tpl="insertar_enlaces.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Enlace");
	$t->set_var("categoria_modulo", "enlaces");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_enlaces_ok(){
	global $tof_enlaces,$titulo_enlace,$url_enlace,$descripcion_enlace,$orden_enlace,$publicado_enlace;

	if (isset($publicado_enlace))
		$publicado_enlace=1;
	else
		$publicado_enlace=0;
		mysql_query("insert into ".$tof_enlaces." values(NULL,'".$titulo_enlace."','".$url_enlace."','".$descripcion_enlace."','".$publicado_enlace."',".$orden_enlace.")");

	listar_enlaces();
}

function editar_enlaces(){
	global $tof_enlaces, $id_enlace;
	$name_tpl="editar_enlaces.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar enlaces");
	$t->set_var("categoria_modulo", "enlaces");

	$result=mysql_query("select * from ".$tof_enlaces." where id='".$id_enlace."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_enlace",$row[id]);
	$t->set_var("titulo_enlace",$row[titulo]);
	$t->set_var("url_enlace",$row[url]);
	$t->set_var("descripcion_enlace",$row[descripcion]);	
	$t->set_var("orden_enlace",$row[orden]);
	$t->set_var("publicado_enlace",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_enlaces_ok(){
	global $tof_enlaces,$id_enlace,$titulo_enlace,$url_enlace,$descripcion_enlace,$orden_enlace,$publicado_enlace;

	if (isset($publicado_enlace))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_enlaces." set titulo='".$titulo_enlace."',url='".$url_enlace."',descripcion='".$descripcion_enlace."',orden=".$orden_enlace.",publicado=".$publicado." where id='".$id_enlace."'");
		
	listar_enlaces();
}

function eliminar_enlaces(){
	global $tof_enlaces, $id_enlace;
	$name_tpl="eliminar_enlaces.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Enlace");
	$t->set_var("categoria_modulo", "enlaces");

	$result=mysql_query("select * from ".$tof_enlaces." where id='".$id_enlace."'");
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_enlace",$row[id]);	
	$t->set_var("titulo_enlace",$row[titulo]);
	$t->set_var("url_enlace",$row[url]);	
	$t->set_var("publicado_enlace",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_enlaces_ok(){
	global $tof_enlaces,$id_enlace;

	mysql_query("delete from ".$tof_enlaces." where id='".$id_enlace."'");
		
	listar_enlaces();
}


?>

