<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function editar_configuracion(){
	global $tof_configuracion, $id_idioma;
	$name_tpl="editar_configuracion.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar configuracion");
	$t->set_var("categoria_modulo", "configuracion");

	$result=mysql_query("select * from ".$tof_configuracion." where id=0");
	$row=mysql_fetch_array($result);
   
	$t->set_var("nombre_empresa",$row[nombre_empresa]);
	$t->set_var("slogan_empresa",$row[slogan]);
	$t->set_var("dueno_empresa",$row[dueno_empresa]);
	$t->set_var("direccion_empresa",$row[direccion_empresa]);
	$t->set_var("telefono_empresa",$row[telefono_empresa]);
	$t->set_var("fax_empresa",$row[fax_empresa]);
	$t->set_var("mail_empresa",$row[mail_empresa]);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_configuracion_ok(){
	global $tof_configuracion,$nombre_empresa,$slogan_empresa,$dueno_empresa,$direccion_empresa,$telefono_empresa,$fax_empresa,$mail_empresa;

	mysql_query("update ".$tof_configuracion." set nombre_empresa='".$nombre_empresa."',dueno_empresa='".$dueno_empresa."',direccion_empresa='".$direccion_empresa."',telefono_empresa='".$telefono_empresa."',fax_empresa='".$fax_empresa."',mail_empresa='".$mail_empresa."',slogan='".$slogan_empresa."' where id=0");
	
	editar_configuracion();
}



?>

