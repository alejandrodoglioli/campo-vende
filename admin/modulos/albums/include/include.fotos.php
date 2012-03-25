<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");




function listar_fotos(){
	global $path_albums,$tof_albums,$tof_index, $id_album,$page,$row_per_page;
	$name_tpl="listar_fotos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar fotos");
	$t->set_var("categoria_modulo", "Fotos");

	$result=mysql_query("select * from ".$tof_albums);
	$t->set_block("pl","block_albums","_block_albums");	
    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_album",$row[ID]);
		$t->set_var("nombre_album",$row[name]);
		if($row[ID]==$id_album)
			$t->set_var("selected_album","selected");
		else
			$t->set_var("selected_album","");
		$t->parse("_block_albums","block_albums",true);
	}
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	if(isset($id_album)){
		$result=mysql_query("select f.*,a.path from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where album_ID=".$id_album." order by filename limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where f.album_ID=".$id_album);
		}
	else{
		$result=mysql_query("select f.*,a.path from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) order by filename limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID)");
		}
		
	$rowcant=mysql_fetch_array($resultcant);
	$nb=$rowcant[cant];
		
	$nb_page=intval($nb/$row_per_page)+1;
	
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


	$t->set_block("pl","block_fotos","_block_fotos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_foto",$row[filename]);
	  if($row[publicado]==1)
	  	$publicado = 'Si';
	   else
		 	$publicado = 'No';
	  $t->set_var("publicado_foto",$publicado);
	  $t->set_var("path_foto",$path_albums.$row[path]."/".$row[filename]);
	  $t->set_var("id_foto",$row[ID]);
      $t->parse("_block_fotos","block_fotos",true);
    }
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_fotos(){
	global $tof_albums;
	$name_tpl="insertar_fotos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Foto");
	$t->set_var("categoria_modulo", "Fotos");
	
	$result=mysql_query("select * from ".$tof_albums);
	$t->set_block("pl","block_albums","_block_albums");	
    while($row1=mysql_fetch_array($result))
    {
		$t->set_var("id_album",$row1[ID]);
		$t->set_var("nombre_album",$row1[name]);
		$t->parse("_block_albums","block_albums",true);
	}

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_fotos_ok(){
	global $tof_albums,$tof_index,$nombre_foto,$id_album,$publicado_foto,$path_albums;
	
	$nombre_foto=$_FILES['nombre_foto']['name'];

	$result=mysql_query("select path from ".$tof_albums." where ID=".$id_album);
	$row=mysql_fetch_array($result);
	
	copy($_FILES['nombre_foto']['tmp_name'], $path_albums.$row[path]."/".$_FILES['nombre_foto']['name']);
	
	if(isset($publicado_foto))	
		$publicado_foto=1;
	else 
		$publicado_foto=0;	
			
	mysql_query("insert into ".$tof_index." values('$id_album','$nombre_foto',0,0,NULL,$publicado_foto,now())");
	$result=mysql_query("select time from ".$tof_albums." where ID='$id_album'");
	$row=mysql_fetch_array($result);
	mysql_query("update ".$tof_albums." set time=$row[time],nb_photos=nb_photos+1 where ID='$id_album");
	
	listar_fotos();
}

function editar_fotos(){
	global $tof_index,$tof_albums, $id_foto,$path_albums;
	$name_tpl="editar_fotos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Foto");
	$t->set_var("categoria_modulo", "Fotos");
		

	$result=mysql_query("select f.*,a.path from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where f.ID=".$id_foto);
	$row=mysql_fetch_array($result);
    
	$t->set_var("nombre_foto",$row[filename]);
	$t->set_var("path_imagen", $path_albums.$row[path]."/".$row[filename]);
	
	$result=mysql_query("select * from ".$tof_albums);
	$t->set_block("pl","block_albums","_block_albums");	
    while($row1=mysql_fetch_array($result))
    {
		$t->set_var("id_album",$row1[ID]);
		$t->set_var("nombre_album",$row1[name]);
		if($row1[ID]==$row[album_ID])
			$t->set_var("selected_album","selected");
		else
			$t->set_var("selected_album","");
		$t->parse("_block_albums","block_albums",true);
	}
	$t->set_var("album_foto",$row[path]);
	$t->set_var("comentarios_foto",$row[nb_comments]);
	$t->set_var("vistas_foto",$row[nb_views]);
	if($row[publicado]==1)
		$publicado_foto="checked";
	else
		$publicado_foto="";
	$t->set_var("publicado_foto",$publicado_foto);
	
	$t->set_var("id_foto",$row[ID]);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_fotos_ok(){
	global $tof_index,$tof_albums,$id_foto,$id_album,$nombre_foto,$publicado_foto,$path_albums;
	
	$result=mysql_query("select f.*,a.path from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where f.ID=".$id_foto);
	$row=mysql_fetch_array($result);
	$path_antiguo_foto=$row[path];
	
	if (isset($publicado_foto))
		$publicado_foto=1;
	else
		$publicado_foto=0;
		
	if($row[filename]!=$nombre_foto){
		rename($path_albums.$path_antiguo_foto."/".$row[filename], $path_albums.$path_antiguo_foto."/".$nombre_foto);
	}
	
	if($row[album_ID]!=$id_album){
		
		$result=mysql_query("select path from ".$tof_albums." where ID=".$id_album);
		$row2=mysql_fetch_array($result);
		$path_nuevo_foto=$row2[path];
		
		copy($path_albums.$path_antiguo_foto."/".$nombre_foto,$path_albums.$path_nuevo_foto."/".$nombre_foto);
		unlink($path_albums.$path_antiguo_foto."/".$nombre_foto);
		}
	
	mysql_query("update ".$tof_index." set filename='".$nombre_foto."',album_ID='".$id_album."',publicado=".$publicado_foto." where ID=".$id_foto);
	
	listar_fotos();
}

function eliminar_fotos(){
	global $tof_index,$tof_albums, $id_foto,$path_albums;
	$name_tpl="eliminar_fotos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Foto");
	$t->set_var("categoria_modulo", "Fotos");

	$result=mysql_query("select f.*,a.path,a.name from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where f.ID=".$id_foto);
	$row=mysql_fetch_array($result);
	
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre_foto",$row[filename]);
	$t->set_var("album_foto",$row[name]);
	$t->set_var("imagen_foto",$path_albums.$row[path]."/".$row[filename]);
	$t->set_var("comentarios_foto",$row[nb_comments]);
	$t->set_var("vistas_foto",$row[nb_views]);
	$t->set_var("publicado_foto",$publicado);
	$t->set_var("id_foto",$row[ID]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_fotos_ok(){
	global $tof_comments, $tof_index,$tof_albums,$id_foto,$path_albums;
	
	$result=mysql_query("select f.*,a.path from ".$tof_index." f join ".$tof_albums." a on (f.album_ID=a.ID) where f.ID=".$id_foto);
	$row=mysql_fetch_array($result);

	unlink($path_albums.$row[path]."/".$row[filename]);
			
	mysql_query("delete from ".$tof_comments." where tof_ID=".$id_foto);
	mysql_query("delete from ".$tof_index." where ID=".$id_foto);
	
	listar_fotos();
}


?>

