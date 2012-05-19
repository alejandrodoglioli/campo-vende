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
    $t->set_var("id_usuario",$row[id]);	  
	$t->set_var("nombre",$row[nombre]);
	$t->set_var("apellido",$row[apellido]);
	$t->set_var("email",$row[email]);
	$t->set_var("tipo_usuario",$row[id_tipousuario]);
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
    global $tof_usuarios_sistema,$nombre_usuario,$apellido_usuario,$email_usuario,$password_usuario,$ciudad_usuario,$provincia_usuario,$cp_usuario,$direccion_usuario,$carac_usuario,$telefono_usuario,$idioma,$tipo_usuario;
    if (isset($tipo_usuario))
		$tipo_usuario=1;
	else
		$tipo_usuario=0;
	mysql_query("insert into ".$tof_usuarios_sistema." values('NULL','".$nombre_usuario."','".$apellido_usuario."','".$email_usuario."','".$password_usuario."','".$carac_usuario."','".$telefono_usuario."','".$cp_usuario."','".$tipo_usuario."','".$provincia_usuario."','".$ciudad_usuario."','".$direccion_usuario."',1)");		
	listar_usuarios_sistema();
}

function editar_usuarios_sistema(){
	global $tof_usuarios_sistema,$tipo_usuario, $id_usuario,$tof_provincias,$tof_localidades,$tof_tipousuario;
	$name_tpl="editar_usuarios_sistema.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar usuario");
	$t->set_var("categoria_modulo", "usuarios_sistema");

	$result=mysql_query("select * from ".$tof_usuarios_sistema." where id=".$id_usuario);
	$row=mysql_fetch_array($result);
    //if($row[comercio]==1)
		//$es_comercio="checked";
	
	
	$t->set_var("nombre",$row[nombre]);
	$t->set_var("apellido",$row[apellido]);
	$t->set_var("email",$row[email]);
	$t->set_var("password",$row[password]);
	$t->set_var("caracteristica",$row[caracteristica]);
	$t->set_var("telefono",$row[telefono]);
	$t->set_var("cp",$row[cp]);
	$t->set_var("direccion",$row[direccion]);
	$t->set_var("provincia",$row[provincia]);
	$t->set_var("ciudad",$row[ciudad]);
	
	
	$result=mysql_query("select nombre from ".$tof_localidades." where id=".$row[ciudad]);
	$rowc = mysql_fetch_array($result);	
	$t->set_var("nombre_ciudad",$rowc[nombre]);
	
	$result=mysql_query("select nombre from ".$tof_provincias." where id=".$row[provincia]);
	$rowp = mysql_fetch_array($result);	
	$t->set_var("nombre_prov",$rowp[nombre]);
	
	
	$resultTipousuario=mysql_query("select * from ".$tof_tipousuario." tu order by id");
	$t->set_block("pl","block_tipousuario","_block_tipousuario");	
    while($rowTipousuario=mysql_fetch_array($resultTipousuario)){
		$t->set_var("id_tipousuario",$rowTipousuario[id]);
		$t->set_var("tipo_usuario",$rowTipousuario[nombre]);
		if($row[id_tipousuario]==$rowTipousuario[id])
			$t->set_var("selected_tipousuario","selected");
		else
			$t->set_var("selected_tipousuario","");
		$t->parse("_block_tipousuario","block_tipousuario",true);
	}
	//$t->set_var("tipousuario",$es_comercio);

	$t->set_var("id_usuario",$row[id]);	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_usuarios_sistema_ok(){
	global $tof_usuarios_sistema,$nombre_usuario,$apellido_usuario,$email_usuario,$password_usuario,$ciudad_usuario,$provincia_usuario,$cp_usuario,$carac_usuario,$telefono_usuario,$idioma,$tipo_usuario,$direccion_usuario,$id_usuario;
	mysql_query("update ".$tof_usuarios_sistema." set nombre = '".$nombre_usuario."', apellido='" .$apellido_usuario."', email='".$email_usuario."', password='".$password_usuario."', caracteristica='".$carac_usuario."', telefono='".$telefono_usuario."', cp='".$cp_usuario."',id_tipousuario=".$tipo_usuario.",provincia=".$provincia_usuario.",ciudad=".$ciudad_usuario.",direccion='".$direccion_usuario."'  where id = ".$id_usuario);	
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

