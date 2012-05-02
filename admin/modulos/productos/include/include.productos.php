<?php
error_reporting(0);
include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");


function listar_productos(){
	global $tof_productos,$tof_productosxidioma,$tof_seccionesxidioma,$id_padre,$row_per_page,$page,$default_idioma,$tof_usuarios_sistema;
	
	$name_tpl="listar_productos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar productos");
	$t->set_var("categoria_modulo", "productos");

	$t->set_var("action", "listar_contactos");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	/*if (isset($_SESSION['user'])){
		$filtro=" and id_usuario=".$_SESSION['user'];
	}else
		$filtro="";*/
	
	if(isset($id_padre) and ($id_padre<>0)){
		$result=mysql_query("select si.*,s.publicado,s.id_seccion,se.nombre as nombre_seccion,u.nombre as nombre_usuario,u.apellido from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) left join ".$tof_usuarios_sistema." u on (s.id_usuario=u.id) where s.id_seccion=".$id_padre." and si.idioma='".$default_idioma."' ".$filtro." order by nombre limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) where s.id_seccion=".$id_padre." and si.idioma='".$default_idioma."'".$filtro."");
		}
	else{
		$result=mysql_query("select si.*,s.publicado,s.id_seccion,se.nombre as nombre_seccion,u.nombre as nombre_usuario, u.apellido from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) left join ".$tof_usuarios_sistema." u on (s.id_usuario=u.id) where si.idioma='".$default_idioma."' and se.idioma='".$default_idioma."'".$filtro." order by nombre limit ".$inicio.",".$row_per_page);
		
		
		$resultcant=mysql_query("select count(*) as cant from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) where si.idioma='".$default_idioma."' and se.idioma='".$default_idioma."'".$filtro."");
		}
	$t->set_block("pl","block_productos","_block_productos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_producto",$row[nombre]);
      $t->set_var("publicado_producto",$row[publicado]);
	  $t->set_var("nombre_padre",$row[nombre_seccion]);
	  $t->set_var("nombre_usuario",$row[nombre_usuario]." ".$row[apellido]);
      $t->set_var("id_producto",$row[id]);
		
      $t->parse("_block_productos","block_productos",true);
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
	
	$result=mysql_query("select * from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where idioma='es' order by nombre");
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


function insertar_productos(){
	global $tof_secciones,$tof_seccionesxidioma,$tof_productos,$tof_productosxidioma,$tof_tipoproducto,$tof_usuarios_sistema,$tof_idioma,$tof_moneda,$tof_tipoproducto;	
	
	$name_tpl="insertar_productos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar producto");
	$t->set_var("categoria_modulo", "productos");
	
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
	
	$t->set_block("pl","block_usuario","_block_usuario");	
	$result1=mysql_query("select * from ".$tof_usuarios_sistema." order by apellido, nombre");

		 while($row1=mysql_fetch_array($result1)){
			$t->set_var("id_usuario", $row1[id]);
			$t->set_var("nombre_usuario", $row1[nombre]." ".$row1[apellido]);
			$t->parse("_block_usuario","block_usuario",true);
		}
		
	
	$resulttipo=mysql_query("select * from ".$tof_tipoproducto." where publicado=1");
	$t->set_block("pl","block_tproducto","_block_tproducto");	
	while($rowtipo=mysql_fetch_array($resulttipo)){
		$t->set_var("id_tipoproducto", $rowtipo[id]);
		$t->set_var("nombre_tipoproducto", $rowtipo[nombre]);
		$t->parse("_block_tproducto","block_tproducto",true);
	}

	$resultmoneda=mysql_query("select * from ".$tof_moneda." where publicado=1");
	$t->set_block("pl","block_moneda","_block_moneda");	
	while($rowmoneda=mysql_fetch_array($resultmoneda)){
		$t->set_var("id_moneda", $rowmoneda[id]);
		$t->set_var("simbolo_moneda", $rowmoneda[simbolo]);
		$t->parse("_block_moneda","block_moneda",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_productos_ok(){
	global $tof_productos, $tof_productosxidioma,$tof_idioma,$tof_imagenesxproductos,$path_images,$path_galeria_productos,$id_usuario;
	
	
	global $publicado,$orden, $nombre_padre,$nombre_subseccion,$menu_lateral,$cant_imagenes,$video,$precio,$destacado,$id_tipoproducto,$id_moneda;
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	if (isset($destacado))
		$destacado=1;
	else
		$destacado=0;
	
	mysql_query("insert into ".$tof_productos." values('NULL',".$nombre_padre.",".$id_usuario.",".$id_tipoproducto.",".$id_moneda.",".$publicado.",'".$orden."','now()','".$video."','".$precio."',".$destacado.")");
	
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

		mysql_query("insert into ".$tof_productosxidioma." values(".$last_id.",'".$row[idioma]."','".$$contenido."','".$$titulo."','".$$description."','".$$keywords."','".$$title."')");
		
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
				$path=$path_images.$path_galeria_productos.$last_id."_".$_FILES['path_imagen_'.$i]['name'];
				
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
						
				mysql_query("insert into ".$tof_imagenesxproductos." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$last_id."')");
				
				}
			}
	}	
	
	listar_productos();
}

function editar_productos(){
	global $tof_productos, $tof_productosxidioma,$tof_secciones, $tof_seccionesxidioma,$tof_imagenesxproductos,$tof_tipoproducto,$tof_idioma,$id_producto,$id_usuario,$tof_usuarios_sistema,$tof_moneda,$tof_tipoproducto;
	$name_tpl="editar_productos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar productos");
	$t->set_var("categoria_modulo", "productos");
	
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
	
		$resultProducto=mysql_query("select si.*,s.publicado,s.video,s.precio,s.destacado,s.id_usuario,s.id_moneda,s.id_tipoproducto from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$id_producto." and si.idioma='".$row[idioma]."'");
		
		if (mysql_num_rows($resultProducto)){

			while($rowProducto=mysql_fetch_array($resultProducto)){
				$id_usuario=$rowProducto[id_usuario];
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("titulo", $rowProducto[nombre]);
				$t->set_var("contenido", $rowProducto[contenido]);
				$t->set_var("title", $rowProducto[title]);
				$t->set_var("description", $rowProducto[description]);
				$t->set_var("video", $rowProducto[video]);
				$t->set_var("keywords", $rowProducto[keywords]);
				
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
	
	$result1=mysql_query("select se.id,se.id_padre,p.id_seccion,p.video,p.orden,p.publicado,p.precio,p.destacado,p.id_moneda,p.id_tipoproducto from ".$tof_secciones." se join ".$tof_productos." p on (p.id_seccion=se.id) where p.id=".$id_producto);
	$row1=mysql_fetch_array($result1);
		
	$result4=mysql_query("select se.* from ".$tof_secciones." se where se.id=".$row1[id_padre]);
	$row4=mysql_fetch_array($result4);
	
	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';

	if($row1[destacado]==1)
		$destacado='checked';
	else
		$destacado='';
		
	$t->set_var("publicado", $publicado);
	$t->set_var("destacado", $destacado);
	$t->set_var("orden", $row1[orden]);
	$t->set_var("video", $row1[video]);
	$t->set_var("precio", $row1[precio]);
	$t->set_var("id_producto", $id_producto);

	$t->set_block("pl","block_padre","_block_padre");	
	$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where id_padre=0 and si.idioma='es' and publicado=1");
	 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id_padre", $row2[id]);
			$t->set_var("nombre_padre", $row2[nombre]);
			if ($row2[id]==$row4[id]){
				$id_padre=$row2[id];
				$t->set_var("selected", "selected");

			}elseif ($row2[id]==$row1[id]){
				$id_padre=$row2[id];
				$t->set_var("selected", "selected");
			}else{
				$t->set_var("selected", "");
				}
			$t->parse("_block_padre","block_padre",true);
		}

	$t->set_block("pl","block_spadre","_block_spadre");	
	$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=".$id_padre." and si.idioma='es' and publicado=1");
	if (($result2!='') and mysql_num_rows($result2)){
		 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id_sub_padre", $row2[id]);
			$t->set_var("nombre_sub_padre", $row2[nombre]);
			if ($row2[id]==$row1[id_seccion]){
				$id_padre=$row2[id_padre];
				$t->set_var("selected_sub", "selected");
				}else{
				$t->set_var("selected_sub", "");
				}
			$t->parse("_block_spadre","block_spadre",true);
		}
	}
	
	$t->set_block("pl","block_usuario","_block_usuario");	
	$resultUsuario=mysql_query("select * from ".$tof_usuarios_sistema." order by apellido, nombre");
	 while($rowUsuario=mysql_fetch_array($resultUsuario)){
			$t->set_var("id_usuario", $rowUsuario[id]);
			$t->set_var("nombre_usuario", $rowUsuario[nombre]." ".$rowUsuario[apellido]);
			if ($rowUsuario[id]==$id_usuario){
				$id_usuario=$id_usuario;
				$t->set_var("selected_usuario", 'selected="selected"');

			}else{
				$t->set_var("selected_usuario", "");
				}
			$t->parse("_block_usuario","block_usuario",true);
		}
		
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$result=mysql_query("select * from ".$tof_imagenesxproductos." where id_producto=".$id_producto);
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
	
	
	$resulttipo=mysql_query("select * from ".$tof_tipoproducto." where publicado=1");
	$t->set_block("pl","block_tproducto","_block_tproducto");	
	while($rowtipo=mysql_fetch_array($resulttipo)){
		$t->set_var("id_tipoproducto", $rowtipo[id]);
		$t->set_var("nombre_tipoproducto", $rowtipo[nombre]);
		if($rowtipo[id]==$row1[id_tipoproducto])
			$t->set_var("selected_tipoproducto", "selected");
		else
			$t->set_var("selected_tipoproducto", "");
		 
		$t->parse("_block_tproducto","block_tproducto",true);
	}

	$resultmoneda=mysql_query("select * from ".$tof_moneda." where publicado=1");
	$t->set_block("pl","block_moneda","_block_moneda");	
	while($rowmoneda=mysql_fetch_array($resultmoneda)){
		$t->set_var("id_moneda", $rowmoneda[id]);
		$t->set_var("simbolo_moneda", $rowmoneda[simbolo]);
		if($rowmoneda[id]==$row1[id_moneda])
			$t->set_var("selected_moneda", "selected");
		else
			$t->set_var("selected_moneda", "");
		$t->parse("_block_moneda","block_moneda",true);
	}
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    

	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_productos_ok(){
	global $tof_productos, $tof_productosxidioma,$tof_secciones, $tof_seccionesxidioma,$tof_tipoproducto,$tof_idioma,$id_producto,$publicado,$orden,$destacado,$precio,$nombre_padre,$nombre_subseccion,$tof_imagenesxproductos,$path_images,$path_galeria_productos,$cant_imagenes,$video,$tof_usuarios_sistema,$id_usuario,$id_moneda,$id_tipoproducto;
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
		
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	if (isset($destacado))
		$destacado=1;
	else
		$destacado=0;
		
	if (isset($orden))
		mysql_query("update ".$tof_productos." set publicado=".$publicado.", id_seccion=".$nombre_padre.",id_usuario=".$id_usuario.",orden='".$orden."',video='".$video."',precio='".$precio."',destacado=".$destacado.",id_moneda=".$id_moneda.",id_tipoproducto=".$id_tipoproducto." where id=".$id_producto);
		
	else
		mysql_query("update ".$tof_productos." set publicado=".$publicado.",id_seccion=".$nombre_padre.",id_usuario=".$id_usuario.",video='".$video."',precio='".$precio."',destacado=".$destacado.",id_moneda=".$id_moneda.",id_tipoproducto=".$id_tipoproducto." where id=".$id_producto);
		
		echo "update ".$tof_productos." set publicado=".$publicado.",id_seccion=".$nombre_padre.",id_usuario=".$id_usuario.",video='".$video."',precio='".$precio."',destacado=".$destacado.",id_moneda=".$id_moneda.",id_tipoproducto=".$id_tipoproducto." where id=".$id_producto;
		

	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$contenido ="contenido_".$row[idioma];
		$title ="title_".$row[idioma];
		$description ="description_".$row[idioma];
		$keywords ="keywords_".$row[idioma];
		global $$titulo,$$contenido,$$title,$$description,$$keywords,$$video;
	 
	 	mysql_query("replace ".$tof_productosxidioma." set id=".$id_producto.",idioma='".$row[idioma]."',contenido='".$$contenido."', nombre='".$$titulo."', description='".$$description."',keywords='".$$keywords."',title='".$$title."'");

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

		$path=$path_images.$path_galeria_productos.$id_producto."_".$_FILES['path_imagen_'.$i]['name'];		
		if (isset($$id_imagen) and ($$id_imagen!=0)) { //la imagen existia	
				if (isset($$path_imagen) and ($$path_imagen!="")) {
					mysql_query("replace ".$tof_imagenesxproductos." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$path."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_producto='".$id_producto."'");
				}else{
					mysql_query("replace ".$tof_imagenesxproductos." set id=".$$id_imagen.",nombre='".$$nombre_imagen."',path='".$$path_imagen_existente."',principio='".$principio_imagen."',publicado='".$publicado_imagen."',id_producto='".$id_producto."'");
				}			
				$array_imagenes[$i-1]=$$id_imagen;
			}else{
				 mysql_query("insert into ".$tof_imagenesxproductos." values(NULL,'".$$nombre_imagen."','".$path."','".$principio_imagen."','".$publicado_imagen."','".$id_producto."')");
				$array_imagenes[$i-1]=mysql_insert_id();
			}
			
		$path_rel="../../..".$path;
		$filetype = $_FILES['path_imagen_'.$i]['type'];
		$type = substr($filetype, (strpos($filetype,"/"))+1);

		if(!isset($filetype) or ($filetype!="") or ($filetype!=" ")){
			$type =strtolower(substr($_FILES['path_imagen_'.$i]['name'],strpos($_FILES['path_imagen_'.$i]['name'],".")+1));
		}
		$types=array("jpeg","gif","png","jpg");

		if (in_array($type, $types) ) {

		$result=mysql_query("select id,path from ".$tof_imagenesxproductos." where id_producto=".$id_producto." and id='".$$id_imagen."'");
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
	$result=mysql_query("select id,path from ".$tof_imagenesxproductos." where (id_producto=".$id_producto." or  id_producto=".$nombre_padre.")");
	while($row=mysql_fetch_array($result)){
		if (!in_array($row[id],$array_imagenes)){
			unlink("../../..".$row[path]);
			mysql_query("delete from ".$tof_imagenesxproductos." where id='".$row[id]."'");
			}
		}
	
	listar_productos();
}

function eliminar_productos(){
	global $tof_productos, $tof_productosxidioma, $id_producto;
	$name_tpl="eliminar_productos.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar producto");
	$t->set_var("categoria_modulo", "productos");

	$result=mysql_query("select si.*,s.publicado,s.destacado,s.precio,s.fecha_publicacion from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$id_producto);
	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	if($row[destacado]==1)
		$destacado="Si";
	else
		$destacado="No";
		
	$t->set_var("nombre_producto",$row[nombre]);
	$t->set_var("fecha_publicacion_producto",$row[fecha_publicacion]);
	$t->set_var("publicado_producto",$publicado);
	$t->set_var("destacado_producto",$destacado);
	$t->set_var("precio_producto",$row[precio]);
	$t->set_var("id_producto",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_productos_ok(){
	global $tof_productos,$tof_productosxidioma,$tof_imagenesxproductos,$id_producto;

	mysql_query("delete from ".$tof_productos." where id=".$id_producto);
	mysql_query("delete from ".$tof_productosxidioma." where id=".$id_producto);

	$result=mysql_query("select path from ".$tof_imagenesxproductos." where id_producto=".$id_producto);
	if (mysql_num_rows($result)){
		while($row=mysql_fetch_array($result)){
			unlink("../../..".$row[path]);
		}
	}
	mysql_query("delete from ".$tof_imagenesxproductos." where id_producto=".$id_producto);
	
	listar_productos();
}


?>

