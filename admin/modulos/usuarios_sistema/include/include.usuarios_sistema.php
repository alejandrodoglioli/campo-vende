<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_usuarios_sistema(){
	global $tof_usuarios_sistema,$tof_tipousuario,$page,$row_per_page;
	$name_tpl="listar_usuarios_sistema.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar usuarios_sistema");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
		
	$result=mysql_query("select u.*,tu.nombre as tipo_usuario from ".$tof_usuarios_sistema." u left join ".$tof_tipousuario." tu on (u.id_tipousuario=tu.id) order by apellido,nombre limit ".$inicio.",".$row_per_page);
	
	$t->set_block("pl","block_usuarios_sistema","_block_usuarios_sistema");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("apellido_usuario",$row[apellido]);
      $t->set_var("nombre_usuario",$row[nombre]);
      $t->set_var("email_usuario",$row[email]);
	   $t->set_var("tipo_usuario",$row[tipo_usuario]);
	  $t->set_var("id_usuario",$row[id]);
      $t->parse("_block_usuarios_sistema","block_usuarios_sistema",true);
    }
	
	$resultcant=mysql_query("select count(*) as cant from ".$tof_usuarios_sistema." order by nickname");
			
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


function insertar_usuarios_sistema(){
	global $tof_usuarios_sistema,$tof_tipousuario, $id_usuario;
	$name_tpl="insertar_usuarios_sistema.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select * from ".$tof_tipousuario." tu order by id");
	
	$t->set_block("pl","block_tipousuario","_block_tipousuario");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("id_tipousuario",$row[id]);
		$t->set_var("tipousuario",$row[nombre]);
		$t->parse("_block_tipousuario","block_tipousuario",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_usuarios_sistema_ok(){
	global $tof_usuarios_sistema,$nombre_usuario,$apellido_usuario,$email_usuario,$password_usuario,$domicilio_usuario,$ciudad_usuario,$provincia_usuario,$cp_usuario,$telefono_usuario,$celular_usuario,$tipousuario;

	mysql_query("insert into ".$tof_usuarios_sistema." values('NULL','".$nombre_usuario."','".$apellido_usuario."','".$email_usuario."','".$password_usuario."','".$domicilio_usuario."','".$ciudad_usuario."','".$provincia_usuario."','".$cp_usuario."','".$telefono_usuario."','".$celular_usuario."',".$tipousuario.")");
		
	listar_usuarios_sistema();
}

function editar_usuarios_sistema(){
	global $tof_usuarios_sistema,$tof_tipousuario, $id_usuario;
	$name_tpl="editar_usuarios_sistema.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select * from ".$tof_usuarios_sistema." where id=".$id_usuario);
	$row=mysql_fetch_array($result);
    if($row[comercio]==1)
		$es_comercio="checked";
	
	$t->set_var("apellido_usuario",$row[apellido]);
	$t->set_var("nombre_usuario",$row[nombre]);
	$t->set_var("email_usuario",$row[email]);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("domicilio_usuario",$row[domicilio]);
	$t->set_var("provincia_usuario",$row[provincia]);
	$t->set_var("ciudad_usuario",$row[ciudad]);	
	$t->set_var("cp_usuario",$row[cp]);	
	$t->set_var("telefono_usuario",$row[telefono]);	
	$t->set_var("celular_usuario",$row[celular]);	
	
	$resultTipousuario=mysql_query("select * from ".$tof_tipousuario." tu order by id");
	$t->set_block("pl","block_tipousuario","_block_tipousuario");	
    while($rowTipousuario=mysql_fetch_array($resultTipousuario)){
		$t->set_var("id_tipousuario",$rowTipousuario[id]);
		$t->set_var("tipousuario",$rowTipousuario[nombre]);
		if($row[id_tipousuario]==$rowTipousuario[id])
			$t->set_var("selected_tipousuario","selected");
		else
			$t->set_var("selected_tipousuario","");
		$t->parse("_block_tipousuario","block_tipousuario",true);
	}
	$t->set_var("tipousuario",$es_comercio);

	$t->set_var("id_usuario",$row[id]);
    
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_usuarios_sistema_ok(){
	global $tof_usuarios_sistema,$id_usuario,$apellido_usuario,$nombre_usuario,$email_usuario,$password_usuario,$domicilio_usuario,$ciudad_usuario,$provincia_usuario,$cp_usuario,$telefono_usuario,$celular_usuario,$tipousuario;
		
	mysql_query("update ".$tof_usuarios_sistema." set apellido='".$apellido_usuario."',nombre='".$nombre_usuario."',email='".$email_usuario."',password='".$password_usuario."',domicilio='".$domicilio_usuario."',ciudad='".$ciudad_usuario."',provincia='".$provincia_usuario."',cp='".$cp_usuario."',telefono='".$telefono_usuario."',celular='".$celular_usuario."',id_tipousuario=".$tipousuario." where id=".$id_usuario);
		
	listar_usuarios_sistema();
}

function eliminar_usuarios_sistema(){
	global $tof_usuarios_sistema,$tof_tipousuario, $id_usuario;
	$name_tpl="eliminar_usuarios_sistema.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select u.*,tu.nombre as tipo_usuario from ".$tof_usuarios_sistema." u left join ".$tof_tipousuario." tu on (u.id_tipousuario=tu.id) where u.id=".$id_usuario);
	
	$row=mysql_fetch_array($result);
			
	$t->set_var("nombre_usuario",$row[nombre]);
	$t->set_var("apellido_usuario",$row[apellido]);
	$t->set_var("tipousuario",$row[tipo_usuario]);
	$t->set_var("id_usuario",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_usuarios_sistema_ok(){
	global $tof_usuarios_sistema,$id_usuario;

	mysql_query("delete from ".$tof_usuarios_sistema." where id=".$id_usuario);
		
	listar_usuarios_sistema();
}


?>

