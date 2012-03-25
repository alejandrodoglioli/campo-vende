<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_noticias(){
	global $tof_noticias,$tof_noticiasxidioma,$row_per_page,$page,$default_idioma;
	$name_tpl="listar_noticias.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar Noticias");
	$t->set_var("categoria_modulo", "Noticias");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
		

	$result=mysql_query("select ni.*,n.publicado, DATE_FORMAT(n.fecha_publicacion,'%d/%m/%Y') as fecha_publicacion from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$default_idioma."' order by n.fecha_publicacion desc limit ".$inicio.",".$row_per_page);
	
	$t->set_block("pl","block_noticias","_block_noticias");	
    while($row=mysql_fetch_array($result))
    {
	  $t->set_var("titulo_noticia",$row[titulo]);
	  $t->set_var("fecha_publicacion_noticia",$row[fecha_publicacion]);
      $t->set_var("publicado_noticia",$row[publicado]);
      $t->set_var("id_noticia",$row[id]);
      $t->parse("_block_noticias","block_noticias",true);
    }

	$resultcant=mysql_query("select count(*) as cant from  ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$default_idioma."' order by fecha_publicacion,titulo");
			
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


function insertar_noticias(){
	global $tof_noticias,$tof_idioma;
	$name_tpl="insertar_noticias.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Noticia");
	$t->set_var("categoria_modulo", "noticias");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	
	$t->set_block("pl","block_idiomas","_block_idiomas");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("idioma", $row[nombre]);
		$t->parse("_block_idiomas","block_idiomas",true);
	}
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje1", $row[idioma]);
		$t->parse("_block_idiomas1","block_idiomas1",true);
	}
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas2","_block_idiomas2");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje2", $row[idioma]);
		$t->parse("_block_idiomas2","block_idiomas2",true);
	}
	
	$t->set_block("pl","block_idiomas3","_block_idiomas3");
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje3", $row[idioma]);
		$t->parse("_block_idiomas3","block_idiomas3",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_noticias_ok(){
	global $tof_noticias, $tof_noticiasxidioma,$tof_imagenesxnoticias,$cant_imagenes,$path_images,$path_galeria_noticias,$tof_idioma;
	
	global $publicado,$orden,$fecha_publicacion;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
	
	if (!isset($fecha_publicacion))
		$fecha_publicacion=date(DATE_ATOM);
		
	
	mysql_query("insert into ".$tof_noticias." values('NULL','".$fecha_publicacion. "',".$publicado.",'".$orden."')");
	$last_id = mysql_insert_id();
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$headline ="headline_".$row[idioma];
		$noticia ="noticia_".$row[idioma];
		$description ="description_".$row[idioma];
		$keywords ="keywords_".$row[idioma];
		$title ="title_".$row[idioma];
		
		global $$titulo,$$headline,$$noticia,$$description,$$keywords;
	 
	 	mysql_query("insert into ".$tof_noticiasxidioma." values(".$last_id.",'".$$titulo."','".$$headline."','".$$noticia."','NULL','".$row[idioma]."','".$$description."','".$$keywords."','".$$title."')");
		}	
	
	//insertar imágenes
	for ($i=1;$i<=$cant_imagenes;$i++){
		
		$nombre_imagen ="nombre_imagen_".$i;
		$path_imagen = "path_imagen_".$i;
		$principio_imagen = "principio_imagen_".$i;
		$publicado_imagen ="publicado_imagen_".$i;		

		global $$nombre_imagen,$$path_imagen,$$principio_imagen,$$publicado_imagen;
		if (isset($$path_imagen) and ($$path_imagen!=" ")){
			$filetype = $_FILES['path_imagen_'.$i]['type'];

			$type = substr($filetype, (strpos($filetype,"/"))+1);
			$types=array("jpeg","gif","png","jpg");

			if (in_array($type, $types) ) {

				$nombre_foto=$_FILES['path_imagen_'.$i]['name'];
				$path=$path_images.$path_galeria_noticias.$last_id."_".$_FILES['path_imagen_'.$i]['name'];
				$path = "../../..".$path;
				copy($_FILES['path_imagen_'.$i]['tmp_name'], $path);
				
				$filesize = $_FILES['path_imagen_'.$i]['size']; 

				if ($filesize>67000){
					if ($filesize>1000000)
						$percent = 0.08;
					elseif ($filesize>500000)
						$percent = 0.11;
					elseif ($filesize>200000)
						$percent = 0.3;
					else
						$percent = 0.5;	
					
						$datos = getimagesize($path);
						if($datos[2]==1){$img = imagecreatefromgif($path);}
						if($datos[2]==2){$img = imagecreatefromjpeg($path);}
						if($datos[2]==3){$img = imagecreatefrompng($path);}
						$anchura = ($datos[0] * $percent);
						$altura = ($datos[1] * $percent);
						$thumb = imagecreatetruecolor($anchura,$altura);
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);
						
						if($datos[2]==1){imagegif($thumb, $path); }
						if($datos[2]==2){imagejpeg($thumb, $path); }
						if($datos[2]==3){imagepng($thumb, $path); }
						
						imagedestroy($thumb);
				}
				
				$path=str_replace("../../..","",$path);
				
				if(isset($$publicado_imagen))	
					$publicado_imagen=1;
				else 
					$publicado_imagen=0;	
				
				if(isset($$principio_imagen))	
					$principio_imagen=1;
				else 
					$publicado_imagen=0;
						
				mysql_query("insert into ".$tof_imagenesxnoticias." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$last_id."')");

				}
			}
	}	
		
	listar_noticias();
}

function editar_noticias(){
	global $tof_noticias, $tof_noticiasxidioma,$tof_idioma,$tof_imagenesxnoticias,$id_noticia;
	$name_tpl="editar_noticias.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Noticias");
	$t->set_var("categoria_modulo", "Noticias");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas","_block_idiomas");
	while($row=mysql_fetch_array($result)){
		$t->set_var("idioma", $row[nombre]);
		$t->parse("_block_idiomas","block_idiomas",true);
		}
		
	$t->set_block("pl","block_idiomas2","_block_idiomas2");
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje2", $row[idioma]);
		$t->parse("_block_idiomas2","block_idiomas2",true);
	}
	
	$t->set_block("pl","block_idiomas3","_block_idiomas3");
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje3", $row[idioma]);
		$t->parse("_block_idiomas3","block_idiomas3",true);
	}
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");	
	while($row=mysql_fetch_array($result)){
	
		$result1=mysql_query("select si.*,s.publicado,s.orden,s.fecha_publicacion from ".$tof_noticias." s join ".$tof_noticiasxidioma." si on (s.id=si.id) where s.id=".$id_noticia." and si.idioma='".$row[idioma]."'");
		
		if (mysql_num_rows($result1)){
			while($row1=mysql_fetch_array($result1)){
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("titulo", $row1[titulo]);
				$t->set_var("headline", $row1[headline]);
				$t->set_var("noticia", $row1[noticia]);	
				$t->set_var("title_noticia", $row1[title]);
				$t->set_var("description", $row1[description]);
				$t->set_var("keywords", $row1[keywords]);		
				
				$t->parse("_block_idiomas1","block_idiomas1",true);
			}
		}else{
			$t->set_var("lenguaje1",$row[idioma]);
				$t->set_var("titulo", "");
				$t->set_var("headline", "");
				$t->set_var("noticia", "");	
				$t->set_var("title_noticia", "");
				$t->set_var("description","");
				$t->set_var("keywords", "");		
				
				$t->parse("_block_idiomas1","block_idiomas1",true);
		}
	}

	$result1=mysql_query("select publicado,orden,fecha_publicacion from ".$tof_noticias." where id=".$id_noticia);
	$row1=mysql_fetch_array($result1);
	
	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';

	$t->set_var("publicado", $publicado);
	$t->set_var("orden", $row1[orden]);
	$t->set_var("fecha_publicacion_noticia", $row1[fecha_publicacion]);
	$t->set_var("id_noticia", $id_noticia);
			
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    
	//agregar imágenes
	$result=mysql_query("select * from ".$tof_imagenesxnoticias." where id_noticia=".$id_noticia);
	$nro=1;
	$t->set_block("pl","block_imagenes","_block_imagenes");	
	if (mysql_num_rows($result)){
		while($row=mysql_fetch_array($result)){
			$t->set_var("nro", $nro);
			$t->set_var("nombre_imagen", $row[nombre]);
			$t->set_var("path_imagen", $row[path]);
			$t->set_var("id_imagen", $row[id]);
						
			if ($row[principio]==1)
				$principio="checked";
			else
				$principio="";
	    		$t->set_var("checked_principio_imagen", $principio);				
							
			if ($row[publicado]==1)
				$publicado="checked";
			else
				$publicado="";
			$t->set_var("checked_publicado_imagen", $publicado);				
			
			$nro++;
			
			$t->parse("_block_imagenes","block_imagenes",true);
			}
		}else{
			$t->set_var("nro", $nro);
			$t->parse("_block_imagenes","block_imagenes",true);
		}
	
	if ($nro>1)
		$t->set_var("cant_imagenes", $nro-1);
	else
		$t->set_var("cant_imagenes", 1);
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_noticias_ok(){
	global $tof_noticias, $tof_noticiasxidioma,$tof_idioma,$id_noticia,$publicado,$orden,$fecha_publicacion,$tof_imagenesxnoticias,$path_images,$path_galeria_noticias,$cant_imagenes;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
	
	if (isset($orden))
		mysql_query("update ".$tof_noticias." set publicado=".$publicado.", orden=".$orden.", fecha_publicacion='".$fecha_publicacion."' where id=".$id_noticia);
	else
		mysql_query("update ".$tof_noticias." set publicado=".$publicado.", fecha_publicacion='".$fecha_publicacion."' where id=".$id_noticia);

	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$headline ="headline_".$row[idioma];
		$noticia ="noticia_".$row[idioma];
		$description ="description_".$row[idioma];
		$keywords ="keywords_".$row[idioma];
		$title ="title_".$row[idioma];	
		
		global $$titulo,$$headline,$$noticia,$$description,$$keywords,$$title,$$noticia_temp;
	 	mysql_query("replace ".$tof_noticiasxidioma." set  id=".$id_noticia.",idioma='".$row[idioma]."',titulo='".$$titulo."',  headline='".$$headline."', noticia='".$$noticia."', keywords='".$$keywords."', description='".$$description."', title='".$$title."'");

		}	
	
	//editar noticias
	$array_imagenes;	
	for ($i=1;$i<=$cant_imagenes;$i++){
		$id_imagen ="id_imagen_".$i;
		$nombre_imagen ="nombre_imagen_".$i;
		$path_imagen = "path_imagen_".$i;
		$path_imagen_existente = "path_imagen_existente_".$i;
		$principio_imagen = "principio_imagen_".$i;
		$publicado_imagen ="publicado_imagen_".$i;		

			
		global $$id_imagen,$$nombre_imagen,$$path_imagen,$$path_imagen_existente,$$principio_imagen,$$publicado_imagen;
		if(isset($$publicado_imagen))	
				$publicado_imagen=1;
			else 
				$publicado_imagen=0;	
			
			if(isset($$principio_imagen))	
				$principio_imagen=1;
			else 
				$principio_imagen=0;
		$path=$path_images.$path_galeria_noticias.$id_noticia."_".$_FILES['path_imagen_'.$i]['name'];	
				
		if (isset($$id_imagen) and ($$id_imagen!=0)) { //la imagen existia	
				if (isset($$path_imagen) and ($$path_imagen!="")) {
					mysql_query("replace ".$tof_imagenesxnoticias." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$path."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_noticia='".$id_noticia."'");
				$array_imagenes[$i-1]=$$path_imagen_existente;
				}else{
					mysql_query("replace ".$tof_imagenesxnoticias." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$$path_imagen_existente."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_noticia='".$id_noticia."'");
					//$array_imagenes[$i-1]=$$path_imagen_existente;
				}			
				
			}else{
				 mysql_query("insert into ".$tof_imagenesxnoticias." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$id_noticia."')");
				//$array_imagenes[$i-1]=$path;
			}
			
		$path_rel="../../..".$path;
		$filetype = $_FILES['path_imagen_'.$i]['type'];
		$type = substr($filetype, (strpos($filetype,"/"))+1);
		$types=array("jpeg","gif","png","jpg");
		if (in_array($type, $types) ) {
						
		$result=mysql_query("select id,path from ".$tof_imagenesxnoticias." where id_noticia=".$id_noticia." and id='".$$id_imagen."'");
		if (mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
		}

		if (!file_exists($path_rel)){ //la imagen es nueva
			$nombre_foto=$_FILES['path_imagen_'.$i]['name'];
			copy($_FILES['path_imagen_'.$i]['tmp_name'], $path_rel);
			
			$filesize = $_FILES['path_imagen_'.$i]['size']; 

			if ($filesize>67000){
				if ($filesize>1000000)
					$percent = 0.08;
				elseif ($filesize>500000)
					$percent = 0.11;
				elseif ($filesize>200000)
					$percent = 0.3;
				else
					$percent = 0.5;	
				
					$datos = getimagesize($path_rel);
					if($datos[2]==1){$img = imagecreatefromgif($path_rel);}
					if($datos[2]==2){$img = imagecreatefromjpeg($path_rel);}
					if($datos[2]==3){$img = imagecreatefrompng($path_rel);}
					$anchura = ($datos[0] * $percent);
					$altura = ($datos[1] * $percent);
					$thumb = imagecreatetruecolor($anchura,$altura);
					imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);
					
					if($datos[2]==1){imagegif($thumb, $path_rel); }
					if($datos[2]==2){imagejpeg($thumb, $path_rel); }
					if($datos[2]==3){imagepng($thumb, $path_rel); }
					
					imagedestroy($thumb);
				}
				
				//if ($row[id]!=0) // tengo que borrar la imagen antigua
					//unlink($path_rel);
					
			}
		}
	}

	//elimino imagenes que no deben ir
	for($i=0;$i<count($array_imagenes);$i++){
			unlink("../../..".$array_imagenes[$i]);
			mysql_query("delete from ".$tof_imagenesxnoticias." where id='".$row[id]."'");
		}
			
	listar_noticias();
}

function eliminar_noticias(){
	global $tof_noticias, $tof_noticiasxidioma, $id_noticia;
	$name_tpl="eliminar_noticias.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Noticia");
	$t->set_var("categoria_modulo", "noticias");

	$result=mysql_query("select ni.*,n.publicado,n.fecha_publicacion from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where n.id=".$id_noticia);
	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("titulo_noticia",$row[titulo]);
	$t->set_var("fecha_publicacion_noticia",$row[fecha_publicacion]);
	$t->set_var("publicado_noticia",$publicado);
	$t->set_var("id_noticia",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_noticias_ok(){
	global $tof_noticias,$tof_noticiasxidioma,$tof_imagenesxnoticias,$id_noticia;

	mysql_query("delete from ".$tof_noticias." where id=".$id_noticia);
	mysql_query("delete from ".$tof_noticiasxidioma." where id=".$id_noticia);
	
	$result=mysql_query("select path from ".$tof_imagenesxnoticias." where id_notica=".$id_noticia);
	if (mysql_num_rows($result)){
		while($row=mysql_fetch_array($result)){
			unlink("../../..".$row[path]);
		}
	}
	mysql_query("delete from ".$tof_imagenesxnoticias." where id_noticia=".$id_noticia);
		
	listar_noticias();
}


?>

