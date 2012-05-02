<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");



function listar_monedas(){
	global $tof_moneda;
	$name_tpl="listar_monedas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Monedas");
	$t->set_var("categoria_modulo", "Monedas");

	$result=mysql_query("select * from ".$tof_moneda);

	$t->set_block("pl","block_monedas","_block_monedas");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("id_moneda",$row[id]);
      $t->set_var("nombre_moneda",$row[nombre]);
	  $t->set_var("simbolo_moneda",$row[simbolo]);
	  $t->set_var("publicado_moneda",$row[publicado]);
      $t->parse("_block_monedas","block_monedas",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_monedas(){
	global $tof_moneda, $id_usuario;
	$name_tpl="insertar_monedas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Moneda");
	$t->set_var("categoria_modulo", "Monedas");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_monedas_ok(){
	global $tof_moneda,$nombre_moneda,$simbolo_moneda,$publicado_moneda;

	if (isset($publicado_moneda))
		$publicado_moneda=1;
	else
		$publicado_moneda=0;
		mysql_query("insert into ".$tof_moneda." values('NULL','".$nombre_moneda."','".$simbolo_moneda."',".$publicado_moneda.")");
		
	listar_monedas();
}

function editar_monedas(){
	global $tof_moneda, $id_moneda;
	$name_tpl="editar_monedas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar monedas");
	$t->set_var("categoria_modulo", "Monedas");

	$result=mysql_query("select * from ".$tof_moneda." where id=".$id_moneda);
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="checked";

	$t->set_var("id_moneda",$row[id]);
	$t->set_var("nombre_moneda",$row[nombre]);
	$t->set_var("simbolo_moneda",$row[simbolo]);
	$t->set_var("publicado_moneda",$publicado);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_monedas_ok(){
	global $tof_moneda,$id_moneda,$simbolo_moneda,$nombre_moneda,$publicado_moneda;

	if (isset($publicado_moneda))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_moneda." set simbolo='".$simbolo_moneda."',nombre='".$nombre_moneda."',publicado=".$publicado." where id=".$id_moneda);
			
	listar_monedas();
}

function eliminar_monedas(){
	global $tof_moneda, $id_moneda;
	$name_tpl="eliminar_monedas.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Moneda");
	$t->set_var("categoria_modulo", "Monedas");

	$result=mysql_query("select * from ".$tof_moneda." where id=".$id_moneda);
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$$publicado="No";
	
	$t->set_var("id_moneda",$row[id]);	
	$t->set_var("nombre_moneda",$row[nombre]);
	$t->set_var("simbolo_moneda",$row[simbolo]);	
	$t->set_var("publicado_moneda",$publicado);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_monedas_ok(){
	global $tof_moneda,$id_moneda;

	mysql_query("delete from ".$tof_moneda." where id=".$id_moneda);
		
	listar_monedas();
}


?>

