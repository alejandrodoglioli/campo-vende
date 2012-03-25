<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");


function checkforadd($album_ID,$album_path)
{
	global $path_albums,$tof_index,$tof_albums,$with_gd;
	
	$handle=opendir($path_albums.$album_path);
	$file=readdir($handle);
	if (($file=="."))
		$file=readdir($handle);
	if (($file==".."))
		$file=readdir($handle);

	while (($file!=false))
	{
		if($file!="." || $file!=".." )
		{
			if(strcmp(substr($file,0,5),"thumb"))
			{
				$url_encoded_file=rawurlencode($file);
				if(extension_loaded("gd") && $with_gd)
				{ 
					if(!file_exists($path_albums.$album_path."/thumb_".$file))
						CreateThumb($file,$album_path);
				}
				$result=mysql_query("select ID from ".$tof_index." where filename='$url_encoded_file' and album_ID='$album_ID'");
				if(!mysql_num_rows($result)) 
				{
					mysql_query("insert into ".$tof_index." values('$album_ID','$url_encoded_file',0,0,NULL,1,now())");
					$result=mysql_query("select time from ".$tof_albums." where ID='$album_ID'");
					$row=mysql_fetch_array($result);
					mysql_query("update ".$tof_albums." set time=$row[time] where ID='$album_ID'");
				}
			}
		} 
		$file=readdir($handle);
	}     
	closedir($handle);
}

function checkforremove($album_ID)
{
	global $path_albums,$tof_albums,$tof_index,$tof_comments,$with_gd;

	$result=mysql_query("select path from ".$tof_albums." where ID='$album_ID'");
	$row=mysql_fetch_array($result);
	$album_path=$row[path];
	$result=mysql_query("select * from ".$tof_index." where album_ID='$album_ID'");
	if(mysql_num_rows($result))
	{
		while($row=mysql_fetch_array($result))
		{
			$decoded_file_name=rawurldecode($row[filename]);
			if(!strcmp(substr($decoded_file_name,0,5),"thumb"))
			{
				$result2=mysql_query("select time from ".$tof_albums." where ID='$album_ID'");
				$row2=mysql_fetch_array($result2);
				mysql_query("update ".$tof_albums." set time=$row2[time] where ID='$album_ID'");
				mysql_query("delete from ".$tof_index." where ID='$row[ID]'");
				continue;
			}
			if(file_exists($path_albums.$album_path."/".$decoded_file_name))
			{
			}
			else
			{
				$result2=mysql_query("select time from ".$tof_albums." where ID='$album_ID'");
				$row2=mysql_fetch_array($result2);
				mysql_query("update ".$tof_albums." set time=$row2[time] where ID='$album_ID'");
				mysql_query("delete from ".$tof_index." where ID='$row[ID]'");
				mysql_query("delete from ".$tof_comments." where tof_ID='$row[ID]'");
				if(extension_loaded("gd") && $with_gd)
				{
					if(file_exists($path_albums.$album_path."/thumb_".$decoded_file_name))
					unlink($path_albums.$album_path."/thumb_".$decoded_file_name);
				}
			}
		}
	}
}


function listar_albums(){
	global $tof_albums;
	$name_tpl="listar_albums.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	$t->set_var("title", "Listar albums");
	$t->set_var("categoria_modulo", "Albums");

	$result=mysql_query("select * from ".$tof_albums);

	$t->set_block("pl","block_albums","_block_albums");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_album",$row[name]);
	  $t->set_var("fecha_alta_album",$row['time']);
	  $t->set_var("path",$row[path]);
	  $t->set_var("id_album",$row[ID]);
      $t->parse("_block_albums","block_albums",true);
    }

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_albums(){
	global $tof_users, $id_album;
	$name_tpl="insertar_albums.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Album");
	$t->set_var("categoria_modulo", "Albums");

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_albums_ok(){
	global $tof_albums,$nombre_album,$path_album,$time_album,$publicado_album;

	if (isset($publicado_album))
		$publicado_album=1;
	else
		$publicado_album=0;
	mysql_query("insert into ".$tof_albums." values('$nombre_album','$path_album',now(),NULL,$publicado_album)");
	$last_id_album=mysql_insert_id();
	
	if(isset($last_id_album)){
		checkforadd($last_id_album,$path_album);
		checkforremove($last_id_album);
	}	
	
	listar_albums();
}

function editar_albums(){
	global $tof_albums, $id_album;
	$name_tpl="editar_albums.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Album");
	$t->set_var("categoria_modulo", "Albums");

	$result=mysql_query("select * from ".$tof_albums." where ID=".$id_album);
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado_album="checked";
	
	$t->set_var("nombre_album",$row[name]);
	$t->set_var("path_album",$row[path]);
	$t->set_var("publicado_album",$publicado_album);
	$t->set_var("id_album",$row[ID]);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_albums_ok(){
	global $path_albums,$tof_albums,$id_album,$nombre_album,$path_album,$publicado_album;

	if (isset($publicado_album))
		$publicado_album=1;
	else
		$publicado_album=0;
	
	$result=mysql_query("select path from ".$tof_albums." where ID=".$id_album);
	$row=mysql_fetch_array($result);
	$path_antiguo_album=$row[path];
	
	mysql_query("update ".$tof_albums." set name='".$nombre_album."',path='".$path_album."',publicado=".$publicado_album." where ID=".$id_album);
	
	rename($path_albums.$path_antiguo_album, $path_albums.$path_album);
		
	listar_albums();
}

function eliminar_albums(){
	global $tof_albums,$tof_index, $id_album;
	$name_tpl="eliminar_albums.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Album");
	$t->set_var("categoria_modulo", "Albums");

	$result=mysql_query("select * from ".$tof_albums." where ID=".$id_album);
	$row=mysql_fetch_array($result);
	
	$result=mysql_query("select count(*) as fotos, sum(nb_comments) as comentarios, sum(nb_views) as vistas from ".$tof_index." where album_ID=$row[ID] and publicado=1 group by album_ID");
	$row1=mysql_fetch_array($result);
	
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre_album",$row[name]);
	$t->set_var("path_album",$row[path]);
	$t->set_var("fotos_album",$row1[fotos]);
	$t->set_var("comentarios_album",$row1[comentarios]);
	$t->set_var("publicado_album",$publicado);
	$t->set_var("fecha_album",$row['time']);
	$t->set_var("id_album",$row[ID]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_albums_ok(){
	global $tof_albums,$tof_comments, $tof_index,$id_album,$path_albums;
	
	$result=mysql_query("select * from ".$tof_albums." where ID=".$id_album);
	$row1=mysql_fetch_array($result);
	
	mysql_query("delete from ".$tof_albums." where ID=".$id_album);
	
	$result=mysql_query("select * from ".$tof_index." where album_ID=".$id_album);
	if(mysql_num_rows($result)){
	  while($row=mysql_fetch_array($result)){
	  	mysql_query("delete from ".$tof_comments." where tof_ID=".$row[ID]);
	  }
	 }
	mysql_query("delete from ".$tof_index." where album_ID=".$id_album);
	
	$carpeta=$path_albums.$row1[path];
	if (file_exists($carpeta)) {
		foreach(glob($carpeta."/*.*") as $archivos_carpeta)
			{
			unlink($archivos_carpeta); /*Con esto eliminas cada archivo de la carpeta hasta quedar vacia*/
			}
	  	rmdir($carpeta);
	} 
			
	listar_albums();
}


?>

