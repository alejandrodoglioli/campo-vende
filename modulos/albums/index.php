<?php
/*
	 Atomic Photo Album
	 Copyright (C) 2001 Constantin Charissis

	 This program is free software; you can redistribute it and/or
	 modify it under the terms of the GNU General Public License
	 as published by the Free Software Foundation; either version 2
	 of the License, or (at your option) any later version.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program; if not, write to the Free Software
	 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

 */


function listar_albums(){
	global $tof_albums, $tof_index,$l_albumindex;
	$name_tpl="index.htm";
	$t = new Template("modulos/albums/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	//$t->set_var("login", printlogin("index"));
	$t->set_var("photo_width", $photo_width);
	
	$t->set_var("titulo", "Lista de albums");
	$t->set_var("l_albumindex", $l_albumindex);
	$t->set_var("path_lista_albums", "index.php?action=listar_albums");
	
	$result=mysql_query("select * from ".$tof_albums." where publicado=1 order by time desc");

	if(mysql_num_rows($result))
	{
	  $t->set_block("pl","block_fotos","_block_fotos");	
	  while($row=mysql_fetch_array($result))
		{
		$t->set_var("path", "index.php?action=mostrar_album&album_ID=".$row[ID]."&page=1");
		$t->set_var("creador", $l_created);
		$t->set_var("creacion", timestamp2smalldate($row[time]));
		$t->set_var("album", $row[name]);
		
		
		$result1=mysql_query("select count(*) as fotos, sum(nb_comments) as comentarios, sum(nb_views) as vistas from ".$tof_index." where album_ID=$row[ID] and publicado=1 group by album_ID");
		
		if(mysql_num_rows($result1)){
			$row1=mysql_fetch_array($result1);
			$t->set_var("status", $l_photos.": ".$row1[fotos]." ".$l_comments.": ".$row1[comentarios]." ".$l_views.": ".$row1[vistas]);
			}
			
		$t->parse("_block_fotos","block_fotos",true);
		
		}
	}
	@mysql_close();
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
	}
	
	
	
function mostrar_album(){
	global $tof_albums,$album_path,$tof_index,$album_ID,$page,$photo_per_page,$path_galeria,$album_path,$l_albumindex,$l_pages,$l_photos,$l_infos,$l_comments,$l_views,$photo_width_min;

		$name_tpl="album.htm";
		$t = new Template("modulos/albums/templates", "remove");
		$t->set_file("pl", $name_tpl);
		
		setearMenu(&$t);
		setearVariablesComunes(&$t);
		
		$result=mysql_query("select name,path from ".$tof_albums." where ID='$album_ID'");
		$row=mysql_fetch_array($result);
		$album_path=$row[path];
		
		$t->set_var("title", $row[name]);
		
		$result=mysql_query("select name from ".$tof_albums." where ID='$album_ID'");
		$row1=mysql_fetch_array($result);
		
		$t->set_var("l_albumindex", $l_albumindex);
		$t->set_var("path", "index.php?action=mostrar_album&album_ID=$album_ID&page=1");
		$t->set_var("album", "$row1[name]");
		$t->set_var("path_lista_album", "index.php?action=listar_albums");
		
		$result=mysql_query("select count(*) as num from ".$tof_index." where publicado=1 and album_ID='$album_ID'");
		
		$row2=mysql_fetch_array($result);
		
		$nb=$row2[num];
		$nb_page=$nb/$photo_per_page;
		if($nb%$photo_per_page)
			$nb_page++;
		
		$t->set_var("l_pages", $l_pages);
		
		$t->set_block("pl","block_paginador","_block_pag");
		for($i=1;$i<=$nb_page;$i++)
		{
			if($page!=$i)
				$t->set_var("paginador", "<a href=index.php?action=mostrar_album&album_ID=$album_ID&page=$i>$i</a>&nbsp;");
			else
				$t->set_var("paginador", "$i&nbsp;");
			
			$t->parse("_block_pag","block_paginador",true);
		}
		
		$t->set_var("titulo", $l_photos);
		$t->set_var("l_infos", $l_infos);
		
		
		clearstatcache();
		if(isset($page))
		  $offset=($page-1)*$photo_per_page;
		else
			$offset=0;
		$result=mysql_query("select * from ".$tof_index." where album_ID='$album_ID' and publicado=1 limit $offset,$photo_per_page");
		if(mysql_num_rows($result))
		{
			
		  $t->set_block("pl","block_fotos","_block_fotos");
		  while($row4=mysql_fetch_array($result))
			{
			  if(file_exists($path_galeria.$album_path."/".rawurldecode($row4[filename])))
				{
					$param="?action=mostrar_foto&album_ID=".$album_ID."&photo_ID=".$row4[ID]."&page=1";
					//$decoded_filename=rawurldecode($row4[filename]);
					if(extension_loaded("gd") && $with_gd)
						$foto = "<a href=index.php$param><img src='$path_galeria$album_path/thumb_$row4[filename]' border='0'><img src='$path_galeria$album_path/thumb_$row4[filename]' border='0' class='preview'></a>";
					else
						$foto= "<a href=index.php$param><img src='$path_galeria$row[path]/$decoded_$row4[filename]' height='$photo_width_min' width:'$photo_width_min' border='0' /><img src='$path_galeria$row[path]/$decoded_$row4[filename]' height='$photo_width_min' width:'$photo_width_min' border='0' class='preview'/></a>";
					$t->set_var("foto", $foto);
					
					
				$t->set_var("comentarios", $row4[nb_comments]." ".$l_comments." | ");
				$t->set_var("visitas", $row4[nb_views]." ".$l_views);
				$t->parse("_block_fotos","block_fotos",true);
				}
			}
			
		}
		
		@mysql_close();
		
		$t->parse("MAIN", "pl");
			$t->p("MAIN");
	}
	
function mostrar_foto(){
	global $tof_comments,$tof_index,$tof_albums,$l_albumindex,$album_ID,$photo_ID,$photo_width,$photo_height,$l_postcomment,$comments_per_page,$l_commentpost,$l_commentclear,$path_galeria,$l_pages,$l_comments;
	$name_tpl="photo.htm";
	$t = new Template("modulos/albums/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	if(isset($submit_comment))
	{
		mysql_query("insert into ".$tof_comments." values('$photo_ID','$content',now(),NULL,'$nombre_ID')");
		$result=mysql_query("select time from ".$tof_albums." where ID='$album_ID'");
		$row2=mysql_fetch_array($result);
		mysql_query("update ".$tof_albums." set time=$row2[time],nb_comments=nb_comments+1 where ID='$album_ID'");
		mysql_query("update ".$tof_index." set nb_comments=nb_comments+1 where ID='$photo_ID'");
	}
	else
	{
	  $result=mysql_query("select time from ".$tof_albums." where ID='$album_ID'");
		$row=mysql_fetch_array($result);
		mysql_query("update ".$tof_albums." set time=$row[time],nb_views=nb_views+1 where ID='$album_ID'");
		mysql_query("update ".$tof_index." set nb_views=nb_views+1 where ID='$photo_ID'");
	}
	
	$result=mysql_query("select name,path from ".$tof_albums." where ID='$album_ID'");
	$row=mysql_fetch_array($result);
	
	$t->set_block("pl","block_fotos","_block_fotos");	
	for($i=1;$i<=$nb_page;$i++)
	{
		if($page!=$i)
			$t->set_var("link_photo", "<a href=index.php?action=mostrar_foto&album_ID=$album_ID&photo_ID=$photo_ID&page=$i>$i</a>&nbsp;");
		else
			$t->set_var("link_photo", $i."&nbsp;");
		$t->parse("_block_fotos","block_fotos",true);
	}
	$album_path=$row[path];
	$nombre_album=$row[name];
	
	$t->set_var("title", $row[name]);
	$t->set_var("l_albumindex", $l_albumindex);
	$t->set_var("path", "index.php?action=mostrar_album&album_ID=$album_ID&page=1");
	$t->set_var("nombre_album", "$row[name]");
	$t->set_var("path_lista_album", "index.php?action=listar_albums");
	
	$result=mysql_query("select ID from ".$tof_index." where album_ID='$album_ID'");
	$pfile=false;
	$nfile=false;
	$row=mysql_fetch_array($result);
	
	do
	{
		if($row[ID]==$photo_ID)
		{
		  $row=mysql_fetch_array($result);
			if($row)
				$nfile=$row[ID];
			break;
		}
		else
		  $pfile=$row[ID];
	} while($row=mysql_fetch_array($result));
	
	$result=mysql_query("select * from ".$tof_index." where ID='$photo_ID' and album_ID='$album_ID'");
	$row=mysql_fetch_array($result);
	$result2=mysql_query("select path,name from ".$tof_albums." where ID='$album_ID'");
	$row2=mysql_fetch_array($result2);
	
	$decoded_file=rawurldecode($row[filename]);
	
	
	$t->set_var("l_albumindex", $l_albumindex);
	$t->set_var("album_ID", $album_ID);
	$t->set_var("decoded_file", $decoded_file);
	
	$t->set_var("photo_width", $photo_width);
	
	$t->set_var("prev_next", print_prev_next($pfile,$nfile,$album_ID));
	
	$t->set_var("titulo", $nombre_album." >> ".$row[filename]);
	$t->set_var("album", $path_galeria.$row2[path]);
	$t->set_var("photo", $row[filename]);
	$t->set_var("photo_width", $photo_width);
	$t->set_var("photo_height", $photo_height);
	
	$t->set_var("l_postcomment", $l_postcomment);
	$t->set_var("album_ID", $album_ID);
	$t->set_var("photo_ID", $photo_ID);
	$t->set_var("l_commentpost", $l_commentpost);
	$t->set_var("l_commentclear", $l_commentclear);
	
	
	$result=mysql_query("select count(*) as num from ".$tof_comments." where tof_ID='$photo_ID'");
	$row=mysql_fetch_array($result);
	
	$t->set_var("comentarios", $row[num]." ".$l_comments);
	
	$nb=$row[num];
	$nb_page=$nb/$comments_per_page;
	if($nb%$comments_per_page)
		$nb_page++;
	
	$t->set_var("l_pages", $l_pages);
	
	$t->set_block("pl","block_fotos","_block_fotos");	
	for($i=1;$i<=$nb_page;$i++)
	{
		if($page!=$i)
			$t->set_var("link_photo", "<a href=index.php?action=mostrar_foto&album_ID=$album_ID&photo_ID=$photo_ID&page=$i>$i</a>&nbsp;");
		else
			$t->set_var("link_photo", $i."&nbsp;");
		$t->parse("_block_fotos","block_fotos",true);
	}
	
	
	
	if(isset($page))
		$offset=($page-1)*$comments_per_page;
	else
		$offset=0;
		
	
	$result=mysql_query("select * from ".$tof_comments." where tof_ID='$photo_ID' order by time desc LIMIT $offset,$comments_per_page");
	
	$t->set_block("pl","block_comentarios","_block_comentarios");
	while($row=mysql_fetch_array($result))
	{
		
		$t->set_var("bynickname",$row[nickname]);
		$t->set_var("contenido",$row[content]);
		
		$t->parse("_block_comentarios","block_comentarios",true);
		
		}
		
	@mysql_close();
	
		$t->parse("MAIN", "pl");
		$t->p("MAIN");
	}

?>

