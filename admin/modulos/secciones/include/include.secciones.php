<?php
error_reporting(0);
include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");


function listar_secciones(){
	global $tof_secciones,$tof_seccionesxidioma,$id_padre,$row_per_page,$page,$default_idioma;
	
	$name_tpl="listar_secciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar secciones");
	$t->set_var("categoria_modulo", "Secciones");

	$t->set_var("action", "listar_contactos");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	if(isset($id_padre) and ($id_padre<>0)){
		$result=mysql_query("select si.*,s.publicado,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=".$id_padre." and si.idioma='".$default_idioma."' order by nombre limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=".$id_padre." and si.idioma='".$default_idioma."'");
		}
	else{
		$result=mysql_query("select si.*,s.publicado,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id)  and si.idioma='".$default_idioma."' order by nombre limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$default_idioma."'");
		}
		
	$t->set_block("pl","block_secciones","_block_secciones");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_seccion",$row[nombre]);
      $t->set_var("publicado_seccion",$row[publicado]);
      $t->set_var("id_seccion",$row[id]);
	  if ($row[id_padre]!=0){
		  $result1=mysql_query("select nombre from ".$tof_seccionesxidioma." where id=".$row[id_padre]);
		  $row1=mysql_fetch_array($result1);
	     	$t->set_var("nombre_padre",$row1[nombre]);
		} else
			$t->set_var("nombre_padre","-");
		
      $t->parse("_block_secciones","block_secciones",true);
    }


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
	
	$result=mysql_query("select * from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where idioma='es' order by nombre");
	$t->set_block("pl","block_padre","_block_padre");	
    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_padre",$row[id]);
		$t->set_var("nombre_padre",$row[nombre]);
		if($row[id]==$id_padre)
			$t->set_var("selected_padre","selected");
		else
			$t->set_var("selected_padre","");
		if ($row[id_padre]==0)
				$t->set_var("color", "#000000");
			else
				$t->set_var("color", "#0000FF");
		$t->parse("_block_padre","block_padre",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_secciones(){
	global $tof_secciones,$tof_seccionesxidioma,$tof_tiposeccion,$tof_idioma;	
	
	$name_tpl="insertar_secciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Sección");
	$t->set_var("categoria_modulo", "Secciones");
	
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
		$t->set_var("_block_padre","");
		
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
	
	$t->set_block("pl","block_padre","_block_padre");	
	$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='es' and publicado=1 and id_padre=0");
		 while($row1=mysql_fetch_array($result1)){
			$t->set_var("id", $row1[id]);
			$t->set_var("nombre_padre", $row1[nombre]);
			$t->parse("_block_padre","block_padre",true);
		}
	
	$t->set_block("pl","block_tiposeccion","_block_tiposeccion");	
	$result1=mysql_query("select * from ".$tof_tiposeccion);
		 while($row1=mysql_fetch_array($result1)){
			$t->set_var("id", $row1[id]);
			$t->set_var("nombre_tiposeccion", $row1[nombre]);
			$t->parse("_block_tiposeccion","block_tiposeccion",true);
		}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_secciones_ok(){
	global $tof_secciones, $tof_seccionesxidioma,$tof_idioma,$tof_imagenesxsecciones,$path_images,$path_galeria;
	
	
	global $publicado,$orden, $nombre_padre,$nombre_tiposeccion,$nombre_subseccion,$menu_lateral,$cant_imagenes,$video;
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	if (isset($menu_lateral))
		$menu_lateral=1;
	else
		$menu_lateral=0;	
	
	mysql_query("insert into ".$tof_secciones." values('NULL',".$nombre_padre.",".$nombre_tiposeccion.",".$publicado.",".$menu_lateral.",'".$orden."','now()','".$video."')");
echo "insert into ".$tof_secciones." values('NULL',".$nombre_padre.",".$nombre_tiposeccion.",".$publicado.",".$menu_lateral.",'".$orden."','now()','".$video."')";
	$last_id = mysql_insert_id();
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$contenido ="contenido_".$row[idioma];
		$title ="title_".$row[idioma];
		$description ="description_".$row[idioma];
		$keywords ="keywords_".$row[idioma];
		$padre ="nombre_padre_".$row[idioma];
		
		//preguntar ale
		global $$titulo,$$contenido,$$title,$$description,$$keywords,$$video;

		mysql_query("insert into ".$tof_seccionesxidioma." values(".$last_id.",'".$row[idioma]."','".$$contenido."','".$$titulo."','".$$description."','".$$keywords."','".$$title."')");
		}	

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
				$path=$path_images.$path_galeria.$last_id."_".$_FILES['path_imagen_'.$i]['name'];
				
				copy($_FILES['path_imagen_'.$i]['tmp_name'], "../../..".$path);
				
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
						
				mysql_query("insert into ".$tof_imagenesxsecciones." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$last_id."')");
				
				}
			}
	}	
	
	listar_secciones();
}

function editar_secciones(){
	global $tof_secciones, $tof_seccionesxidioma,$tof_imagenesxsecciones,$tof_tiposeccion,$tof_idioma,$id_seccion;
	$name_tpl="editar_secciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar Secciones");
	$t->set_var("categoria_modulo", "Secciones");
	
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
	
		$result1=mysql_query("select si.*,s.publicado,s.menu_lateral,s.video from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$id_seccion." and si.idioma='".$row[idioma]."'");
		
		if (mysql_num_rows($result1)){
			while($row1=mysql_fetch_array($result1)){
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("titulo", $row1[nombre]);
				$t->set_var("contenido", $row1[contenido]);
				$t->set_var("title", $row1[title]);
				$t->set_var("description", $row1[description]);
				$t->set_var("video", $row1[video]);
				$t->set_var("keywords", $row1[keywords]);
				
				$t->parse("_block_idiomas1","block_idiomas1",true);
			}
		}else{
			$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("titulo","");
				$t->set_var("contenido","");
				$t->set_var("title", "");
				$t->set_var("description", "");
				$t->set_var("video","");
				$t->set_var("keywords", "");
				
				$t->parse("_block_idiomas1","block_idiomas1",true);
		}
	}
	
	$result1=mysql_query("select id,publicado,menu_lateral,orden,id_padre,id_tiposeccion,video from ".$tof_secciones." where id=".$id_seccion);
	$row1=mysql_fetch_array($result1);
	$result4=mysql_query("select id,publicado,orden,menu_lateral,id_padre from ".$tof_secciones." where id=".$row1[id_padre]);
	$row4=mysql_fetch_array($result4);
	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';
		
	if($row1[menu_lateral]==1)
		$menu_lateral='checked';
	else
		$menu_lateral='';
		
	$t->set_var("menu_lateral", $menu_lateral);
	$t->set_var("publicado", $publicado);
	$t->set_var("orden", $row1[orden]);
	$t->set_var("video", $row1[video]);
	$t->set_var("id_seccion", $id_seccion);
	$t->set_block("pl","block_padre","_block_padre");	
	$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where id_padre=0 and si.idioma='es' and publicado=1");
		 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id_padre", $row2[id]);
			$t->set_var("nombre_padre", $row2[nombre]);
			if ($row2[id]==$row1[id_padre]){
				$id_padre=$row2[id];
				$t->set_var("selected", "selected");

			}elseif ($row2[id]==$row4[id_padre]){
				$id_padre=$row2[id];
				$t->set_var("selected", "selected");
			}else{
				$t->set_var("selected", "");
				}
			$t->parse("_block_padre","block_padre",true);
		}

	$t->set_block("pl","block_spadre","_block_spadre");	
	$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where id_padre=".$id_padre." and si.idioma='es' and publicado=1 and s.id<>".$id_seccion);
	if (($result2!='') and mysql_num_rows($result2)){
		 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id_sub_padre", $row2[id]);
			$t->set_var("nombre_sub_padre", $row2[nombre]);
			if ($row2[id]==$row1[id_padre]){
				$id_padre=$row2[id_padre];
				$t->set_var("selected_sub", "selected");
				}else{
				$t->set_var("selected_sub", "");
				}
			$t->parse("_block_spadre","block_spadre",true);
		}
	}
	
	$t->set_block("pl","block_tiposeccion","_block_tiposeccion");	
	$result2=mysql_query("select * from ".$tof_tiposeccion);
	if (mysql_num_rows($result2)){
		 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id", $row2[id]);
			$t->set_var("nombre_tiposeccion", $row2[nombre]);
			if ($row2[id]==$row1[id_tiposeccion]){
				$t->set_var("selected_tiposeccion", "selected");
				}else{
				$t->set_var("selected_tiposeccion", "");
				}
			$t->parse("_block_tiposeccion","block_tiposeccion",true);
		}
	}
					
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$result=mysql_query("select * from ".$tof_imagenesxsecciones." where id_seccion=".$id_seccion);
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
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_secciones_ok(){
	global $tof_secciones, $tof_seccionesxidioma,$tof_tiposeccion,$tof_idioma,$id_seccion,$publicado,$orden,$nombre_padre,$nombre_tiposeccion,$nombre_subseccion,$menu_lateral,$tof_imagenesxsecciones,$path_images,$path_galeria,$cant_imagenes,$video;
	
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
		
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	if (isset($menu_lateral))
		$menu_lateral=1;
	else
		$menu_lateral=0;
	
	if (isset($orden))
		mysql_query("update ".$tof_secciones." set publicado=".$publicado.",menu_lateral=".$menu_lateral.", id_padre=".$nombre_padre.",id_tiposeccion=".$nombre_tiposeccion.",orden='".$orden."',video='".$video."' where id=".$id_seccion);
	else
		mysql_query("update ".$tof_secciones." set publicado=".$publicado.",menu_lateral=".$menu_lateral.",id_padre=".$nombre_padre.",id_tiposeccion=".$nombre_tiposeccion.",video=".$video." where id=".$id_seccion);
		
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$contenido ="contenido_".$row[idioma];
		$title ="title_".$row[idioma];
		$description ="description_".$row[idioma];
		$keywords ="keywords_".$row[idioma];
		global $$titulo,$$contenido,$$title,$$description,$$keywords,$$video;
	 
	 	mysql_query("replace ".$tof_seccionesxidioma." set id=".$id_seccion.",idioma='".$row[idioma]."',contenido='".$$contenido."', nombre='".$$titulo."', description='".$$description."',keywords='".$$keywords."',title='".$$title."'");

		}	
	
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
		$path=$path_images.$path_galeria.$id_seccion."_".$_FILES['path_imagen_'.$i]['name'];		
		if (isset($$id_imagen) and ($$id_imagen!=0)) { //la imagen existia	
				if (isset($$path_imagen) and ($$path_imagen!="")) {
					mysql_query("replace ".$tof_imagenesxsecciones." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$path."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_seccion='".$id_seccion."'");
				}else{
					mysql_query("replace ".$tof_imagenesxsecciones." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$$path_imagen_existente."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_seccion='".$id_seccion."'");
				}			
				$array_imagenes[$i-1]=$$id_imagen;
			}else{
				 mysql_query("insert into ".$tof_imagenesxsecciones." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$id_seccion."')");
				$array_imagenes[$i-1]=mysql_insert_id();
			}
			
		$path_rel="../../..".$path;
		$filetype = $_FILES['path_imagen_'.$i]['type'];
		$type = substr($filetype, (strpos($filetype,"/"))+1);
		$types=array("jpeg","gif","png","jpg");
		if (in_array($type, $types) ) {
						
		$result=mysql_query("select id,path from ".$tof_imagenesxsecciones." where id_seccion=".$id_seccion." and id='".$$id_imagen."'");
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
				
					$datos = getimagesize($path);
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
				
				if ($row[id]!=0) // tengo que borrar la imagen antigua
					unlink($path_re);
					
			}
		}
	}

	//elimino imagenes que no deben ir
	$result=mysql_query("select id,path from ".$tof_imagenesxsecciones." where (id_seccion=".$id_seccion." or  id_seccion=".$nombre_padre.")");
	while($row=mysql_fetch_array($result)){
		if (!in_array($row[id],$array_imagenes)){
			unlink("../../..".$row[path]);
			mysql_query("delete from ".$tof_imagenesxsecciones." where id='".$row[id]."'");
			}
		}
	
	listar_secciones();
}

function eliminar_secciones(){
	global $tof_secciones, $tof_seccionesxidioma, $id_seccion;
	$name_tpl="eliminar_secciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Sección");
	$t->set_var("categoria_modulo", "Secciones");

	$result=mysql_query("select si.*,s.publicado,s.fecha_publicacion from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$id_seccion);
	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre_seccion",$row[nombre]);
	$t->set_var("fecha_publicacion_seccion",$row[fecha_publicacion]);
	$t->set_var("publicado_seccion",$publicado);
	$t->set_var("id_seccion",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_secciones_ok(){
	global $tof_secciones,$tof_seccionesxidioma,$tof_imagenesxsecciones,$id_seccion;

	mysql_query("delete from ".$tof_secciones." where id=".$id_seccion);
	mysql_query("delete from ".$tof_seccionesxidioma." where id=".$id_seccion);

	$result=mysql_query("select path from ".$tof_imagenesxsecciones." where id_seccion=".$id_seccion);
	if (mysql_num_rows($result)){
		while($row=mysql_fetch_array($result)){
			unlink("../../..".$row[path]);
		}
	}
	mysql_query("delete from ".$tof_imagenesxsecciones." where id_seccion=".$id_seccion);
	
	listar_secciones();
}


?>

