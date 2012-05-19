<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_usuarios(){
	global $tof_users,$page,$row_per_page;
	$name_tpl="listar_usuarios.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar usuarios");
	$t->set_var("categoria_modulo", "Usuarios");

	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
		
	$result=mysql_query("select * from ".$tof_users." order by nickname limit ".$inicio.",".$row_per_page);
	
	$t->set_block("pl","block_usuarios","_block_usuarios");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_usuario",$row[nickname]);
	  $t->set_var("id_usuario",$row[ID]);
      $t->parse("_block_usuarios","block_usuarios",true);
    }
	
	$resultcant=mysql_query("select count(*) as cant from ".$tof_users." order by nickname");
			
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


function insertar_usuarios(){
	global $tof_users, $id_usuario;
	$name_tpl="insertar_usuarios.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar usuario");
	$t->set_var("categoria_modulo", "Usuarios");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_usuarios_ok(){
	global $tof_users,$nombre_usuario,$password_usuario,$es_administrador_usuario;

	if (isset($es_administrador_usuario))
		$es_administrador_usuario=1;
	else
		$es_administrador_usuario=0;
		mysql_query("insert into ".$tof_users." values('".$nombre_usuario."','".$password_usuario."',".$es_administrador_usuario.",Null)");
		
	listar_usuarios();
}

function editar_usuarios(){
	global $tof_users, $id_usuario;
	$name_tpl="editar_usuarios.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar usuario");
	$t->set_var("categoria_modulo", "Usuarios");

	$result=mysql_query("select * from ".$tof_users." where ID=".$id_usuario);
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_usuarios_ok(){
	global $tof_users,$id_usuario,$nombre_usuario,$password_usuario,$es_administrador_usuario;

	if (isset($es_administrador_usuario))
		$es_administrador_usuario=1;
	else
		$es_administrador_usuario=0;
		mysql_query("update ".$tof_users." set nickname='".$nombre_usuario."',password='".$password_usuario."',is_admin=".$es_administrador_usuario." where ID=".$id_usuario);
		
	listar_usuarios();
}

function eliminar_usuarios(){
	global $tof_users, $id_usuario;
	$name_tpl="eliminar_usuarios.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar usuario");
	$t->set_var("categoria_modulo", "Usuarios");

	$result=mysql_query("select * from ".$tof_users." where ID=".$id_usuario);
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="Si";
	else
		$es_administrador="No";
		
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("id_usuario",$row[ID]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_usuarios_ok(){
	global $tof_users,$id_usuario;

	mysql_query("delete from ".$tof_users." where ID=".$id_usuario);
		
	listar_usuarios();
}


?>

