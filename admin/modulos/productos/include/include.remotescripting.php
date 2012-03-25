<?php

include("../../../../include/class.Template.php");
include("../../../../include/config.php");
include("../../../../include/conexion.php");
require("../../../include/jsrsServer.php.inc");

jsrsDispatch( "obtenerSubsecciones,obtenerSubSubsecciones" );

function obtenerSubsecciones($id_seccion){
	global $tof_secciones,$tof_seccionesxidioma;
	
	$name_tpl="selector_subsecciones.htm";
	$t = new Template("../templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$result=mysql_query("select si.*,s.publicado,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='es' and s.id_padre=".$id_seccion);

	$t->set_var("nombre_s", "nombre_subseccion");
	
	if (isset($id_seccion)){
		$t->set_var("onchange", 'onChange="pedir_subsubsecciones(this.value);"');
		$t->set_block("pl","subsecciones","_subsecciones");	
		while($sub=mysql_fetch_array($result)){
			$t->set_var("id_subseccion", $sub['id']);
			$t->set_var("nombre_subseccion", $sub['nombre']);
			/*if ($id_cuenta_bancaria==$cuenta_bancaria['idCuentaBancaria'])
				$t->set_var("selected", "selected");
			else
				$t->set_var("selected", "");*/
			$t->parse("_subsecciones","subsecciones",true);
		}
	}
	return $t->parse("MAIN", "pl");
}

function obtenerSubSubsecciones($id_seccion){
	global $tof_secciones,$tof_seccionesxidioma;
	
	$name_tpl="selector_subsecciones.htm";
	$t = new Template("../templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$result=mysql_query("select si.*,s.publicado,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='es' and s.id_padre=".$id_seccion);
	
	$t->set_var("nombre_s", "nombre_subsubseccion");

	if (isset($id_seccion)){
		$t->set_block("pl","subsecciones","_subsecciones");	
		while($sub=mysql_fetch_array($result)){
			$t->set_var("id_subseccion", $sub['id']);
			$t->set_var("nombre_subseccion", $sub['nombre']);
			/*if ($id_cuenta_bancaria==$cuenta_bancaria['idCuentaBancaria'])
				$t->set_var("selected", "selected");
			else
				$t->set_var("selected", "");*/
			$t->parse("_subsecciones","subsecciones",true);
		}
	}
	return $t->parse("MAIN", "pl");
}
		
?>

