<?PHP


function presentar_aut(){
	global $urlSite,$idioma;

	$name_tpl="login.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->set_var("titulo", "Login usuario");
	$t->set_var("title", "Login usuario");

	$t->set_var("description", "Login usuario");
	$t->set_var("keywords", "Login usuario");
	$t->set_var("idioma", $idioma);
	$t->set_var("action", "login");
	
	$t->set_var("breadcrum", ' >> Login Usuario');
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function comprobar_aut($email,$pass) 
{

	global $tof_usuarios_sistema;

	$sql=mysql_query("select * from ".$tof_usuarios_sistema." where email='".$email."' and password='".$pass."'");
	
	if(mysql_num_rows($sql)){

		$result=mysql_fetch_array($sql);

		if ($result['email'] == $email && $result['password'] == $pass){
			$id = $result['id'];
			$_SESSION['user_sistema']=$id;
			$_SESSION['email_sistema']=$email;
			$_SESSION['pass_sistema']=$pass;
			$_SESSION['nombre_user_sistema']=$result[nombre]." ".$result[apellido];
			//$_SESSION['id_categoria_usuario']=$result[0]['id_categoria'];
			return 1;
		}
	}
	return 0;
}

function mostrar_login(){
	global $idioma;
	$name_tpl="login.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->set_var("titulo", "Login usuario");
	$t->set_var("title", "Login usuario");

	$t->set_var("description", "Login usuario");
	$t->set_var("keywords", "Login usuario");
	$t->set_var("idioma", $idioma);
	
	$t->set_var("breadcrum", ' >> Login Usuario');
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function registrar_usuario_sistema(){
	global $idioma;

	$name_tpl="registrarse.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->set_var("titulo", "Registrar usuario");
	$t->set_var("title", "Registrar usuario");

	$t->set_var("description", "Registrar usuario");
	$t->set_var("keywords", "Registrar usuario");
	$t->set_var("idioma", $idioma);
	
	$t->set_var("breadcrum", ' >> Registrar Usuario');
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_usuarios_sistema_ok(){
	global $tof_usuarios_sistema,$nombre_usuario,$apellido_usuario,$email_usuario,$password_usuario,$domicilio_usuario,$ciudad_usuario,$provincia_usuario,$cp_usuario,$telefono_usuario,$celular_usuario,$es_comercio_usuario,$idioma;

	if (isset($es_comercio_usuario))
		$es_comercio_usuario=1;
	else
		$es_comercio_usuario=0;

	mysql_query("insert into ".$tof_usuarios_sistema." values('NULL','".$nombre_usuario."','".$apellido_usuario."','".$email_usuario."','".$password_usuario."','".$domicilio_usuario."','".$ciudad_usuario."','".$provincia_usuario."','".$cp_usuario."','".$telefono_usuario."','".$celular_usuario."',".$es_comercio_usuario.",'NULL','NULL','NULL')");
	
	$id=mysql_insert_id();
	
	$_SESSION['user_sistema']=$id;
	$_SESSION['email_sistema']=$email_usuario;
	$_SESSION['pass_sistema']=$password_usuario;
	$_SESSION['nombre_user_sistema']=$result[nombre_usuario]." ".$result[apellido_usuario];		
	
	mostrar_usuario_sistema();
}

function mostrar_usuario_sistema($id_usuario=NULL){
	global $tof_usuarios_sistema,$tof_productos,$tof_productosxidioma,$tof_secciones,$tof_seccionesxidioma,$idioma,$row_per_page,$inicio;

	$name_tpl="listar_productosxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	
	if(!isset($id_usuario))
		$id_usuario=$_SESSION['user_sistema'];
	
	$name_tpl="listar_productosxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$t->set_var("title", "Listar productos usuario");
	$t->set_var("categoria_modulo", "usuario");

	$t->set_var("action", "listar_productoxusuario");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}

	global $id_seccion;
	if(isset($id_seccion) && ($id_seccion!="") && ($id_seccion!=0))
		$filtro=" and se.id=".$id_seccion;
	else
		$filtro="";
	
	$result=mysql_query("select si.*,s.publicado,s.id_seccion,se.nombre as nombre_seccion from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) and si.idioma='".$idioma."' and se.idioma='".$idioma."' and s.id_usuario=".$id_usuario.$filtro." order by nombre limit ".$inicio.",".$row_per_page);
	$resultcant=mysql_query("select count(*) as cant from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) join ".$tof_seccionesxidioma." se on (se.id=s.id_seccion) and si.idioma='".$idioma."' and se.idioma='".$idioma."' and s.id_usuario=".$id_usuario.$filtro);
		
	$t->set_block("pl","block_productos","_block_productos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_producto",$row[nombre]);
      $t->set_var("publicado_producto",$row[publicado]);
	  $t->set_var("nombre_padre",$row[nombre_seccion]);
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
	
	$result=mysql_query("select * from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where idioma='es' and s.id in (select distinct(id_seccion) from ".$tof_productos." p where p.id_usuario=".$_SESSION['user_sistema'].") order by nombre");
	$t->set_block("pl","block_padre","_block_padre");	

    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_seccion",$row[id]);
		$t->set_var("nombre_padre",$row[nombre]);
		if($row[id]==$id_seccion)
			$t->set_var("selected_seccion","selected");
		else
			$t->set_var("selected_seccion","");
		if ($row[id_padre]==0)
				$t->set_var("color", "#000000");
			else
				$t->set_var("color", "#0000FF");
		$t->parse("_block_padre","block_padre",true);
	}
	
	
	
	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario_logueado", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Bienvenido");
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
	
}

function insertar_productoxusuario(){
	global $tof_secciones,$tof_seccionesxidioma,$tof_productos,$tof_productosxidioma,$tof_tipoproducto,$tof_usuarios_sistema,$tof_idioma,$idioma;	

	$id_usuario=$_SESSION['user_sistema'];
	
	$name_tpl="insertar_productoxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
    setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar producto");
	$t->set_var("categoria_modulo", "productos");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	
	$t->set_var("idioma", $idioma);
	
	$t->set_block("pl","block_idioma","_block_idioma");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("nombre_idioma", $row[nombre]);
		$t->parse("_block_idioma","block_idioma",true);
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
	

	$t->set_block("pl","block_tipoproducto","_block_tipoproducto");	
	$result1=mysql_query("select * from ".$tof_tipoproducto);
		 while($row1=mysql_fetch_array($result1)){
			$t->set_var("id", $row1[id]);
			$t->set_var("nombre_tipoproducto", $row1[nombre]);
			$t->parse("_block_tipoproducto","block_tipoproducto",true);
		}

	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Usuario");
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_productoxusuario_ok(){
	global $tof_productos, $tof_productosxidioma,$tof_idioma,$tof_imagenesxproductos,$path_images,$path_galeria_productos,$idioma;
	global $publicado,$orden, $nombre_padre,$nombre_subseccion,$menu_lateral,$cant_imagenes,$video;
	
	$id_usuario=$_SESSION['user_sistema'];
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
	
	/*if (isset($publicado))
		$publicado=1;
	else*/
		$publicado=0;
	
	mysql_query("insert into ".$tof_productos." values('NULL',".$nombre_padre.",".$id_usuario.",".$publicado.",'".$orden."','now()','".$video."')");

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
	
	mostrar_usuario_sistema();
	}

function editar_productoxusuario(){
	global $tof_productos, $tof_productosxidioma,$tof_secciones, $tof_seccionesxidioma,$tof_imagenesxproductos,$tof_tipoproducto,$tof_idioma,$id_producto,$tof_usuarios_sistema,$idioma;

	$id_usuario=$_SESSION['user_sistema'];
	
	$name_tpl="editar_productoxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);

	$t->set_var("idioma", $idioma);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar productos");
	$t->set_var("categoria_modulo", "Editar producto");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idioma","_block_idioma");
	while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_nombre", $row[nombre]);
		$t->parse("_block_idioma","block_idioma",true);
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
	
		$resultProducto=mysql_query("select si.*,s.publicado,s.video,s.id_usuario from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$id_producto." and si.idioma='".$row[idioma]."'");
		
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
	
	$result1=mysql_query("select se.id,se.id_padre,p.id_seccion,p.video,p.orden,p.publicado from ".$tof_secciones." se join ".$tof_productos." p on (p.id_seccion=se.id) where p.id=".$id_producto);
	$row1=mysql_fetch_array($result1);
		
	$result4=mysql_query("select se.* from ".$tof_secciones." se where se.id=".$row1[id_padre]);
	$row4=mysql_fetch_array($result4);
	
	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';
		
	$t->set_var("publicado", $publicado);
	$t->set_var("orden", $row1[orden]);
	$t->set_var("video", $row1[video]);
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
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    
	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Usuario");
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_productoxusuario_ok(){
	global $tof_productos, $tof_productosxidioma,$tof_secciones, $tof_seccionesxidioma,$tof_tipoproducto,$tof_idioma,$id_producto,$publicado,$orden,$nombre_padre,$nombre_subseccion,$tof_imagenesxproductos,$path_images,$path_galeria_productos,$cant_imagenes,$video,$tof_usuarios_sistema;
	
	$id_usuario=$_SESSION['user_sistema'];
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
		
	$resultProducto=mysql_query("select si.*,s.publicado,s.video,s.id_usuario from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$id_producto." and si.idioma='".$row[idioma]."'");
	$rowProducto=mysql_fetch_array($resultProducto);

	/*if (isset($publicado))
		$publicado=1;
	else*/
		$publicado=$rowProducto[publicado];
		
	if (isset($orden))
		mysql_query("update ".$tof_productos." set publicado=".$publicado.", id_seccion=".$nombre_padre.",id_usuario=".$id_usuario.",orden='".$orden."',video='".$video."' where id=".$id_producto);
		
	else
		mysql_query("update ".$tof_productos." set publicado=".$publicado.",id_seccion=".$nombre_padre.",id_usuario=".$id_usuario.",video='".$video."' where id=".$id_producto);
		

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
	
	mostrar_usuario_sistema();
}

function eliminar_productoxusuario(){
	global $tof_usuarios_sistema,$tof_productos, $tof_productosxidioma, $id_producto;
	$id_usuario=$_SESSION['user_sistema'];


	$name_tpl="eliminar_productoxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar producto");
	$t->set_var("categoria_modulo", "Eliminar producto");

	$result=mysql_query("select si.*,s.publicado,s.fecha_publicacion from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$id_producto);
	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre_producto",$row[nombre]);
	$t->set_var("fecha_publicacion_producto",$row[fecha_publicacion]);
	$t->set_var("publicado_producto",$publicado);
	$t->set_var("id_producto",$row[id]);

	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Usuario");
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_productoxusuario_ok(){
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
	
	mostrar_usuario_sistema();
}

function mostrarpregunta_productoxusuario($id_producto=NULL){
	global $tof_usuarios_sistema,$tof_productos,$tof_productosxidioma,$tof_secciones,$tof_seccionesxidioma,$idioma,$row_per_page,$inicio,$id_producto,$tof_comentariosxproductosxidioma,$tof_comentariosxproductos,$id_producto;

	$name_tpl="listarpregunta_productosxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	if(!isset($id_usuario))
		$id_usuario=$_SESSION['user_sistema'];
	
	$t->set_var("title", "Listar preguntas productos x usuario");
	$t->set_var("categoria_modulo", "usuario");

	$t->set_var("action", "listarpregunta_productoxusuario");
	$t->set_var("id_producto", $id_producto);
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}

	global $id_seccion;
	if(isset($id_seccion) && ($id_seccion!="") && ($id_seccion!=0))
		$filtro=" and se.id=".$id_seccion;
	else
		$filtro="";
	
	$result=mysql_query("select pi.nombre as nombre_producto,si.*,s.publicado from ".$tof_comentariosxproductos." s join ".$tof_comentariosxproductosxidioma." si on (s.id=si.id) join ".$tof_productosxidioma." pi on (s.id_producto=pi.id) where si.idioma='".$idioma."' and s.id_producto=".$id_producto."  order by fecha_publicacion desc limit ".$inicio.",".$row_per_page);
;
	$resultcant=mysql_query("select count(*) as cant from ".$tof_comentariosxproductos." s join ".$tof_comentariosxproductosxidioma." si where si.idioma='".$idioma."' and s.id_producto=".$id_producto." order by fecha_publicacion");
		
	$t->set_block("pl","block_comentariosproductos","_block_comentariosproductos");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_cliente",$row[nombre]);
      $t->set_var("publicado_comentario",$row[publicado]);
	  $t->set_var("comentario",$row[comentario]);
	  $t->set_var("respuesta",$row[respuesta]);
      $t->set_var("id_comentario",$row[id]);
	$t->set_var("nombre_producto","Preguntas acerca de producto:".$row[nombre_producto]);	
      $t->parse("_block_comentariosproductos","block_comentariosproductos",true);
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
	
	$result=mysql_query("select * from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where idioma='es' and s.id_usuario =".$_SESSION['user_sistema']." order by nombre");
	$t->set_block("pl","block_padre","_block_padre");	

    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_padre",$row[id]);
		$t->set_var("nombre_padre",$row[nombre]);
		if($row[id]==$id_seccion)
			$t->set_var("selected_producto","selected");
		else
			$t->set_var("selected_producto","");
		if ($row[id_padre]==0)
				$t->set_var("color", "#000000");
			else
				$t->set_var("color", "#0000FF");
		$t->parse("_block_padre","block_padre",true);
	}
	
	
	
	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario_logueado", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Preguntas");
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editarpregunta_productoxusuario(){
	global $tof_productos, $tof_productosxidioma,$tof_comentariosxproductos, $tof_comentariosxproductosxidioma,$tof_idioma,$id_comentario,$tof_usuarios_sistema,$idioma,$id_comentario;

	$id_usuario=$_SESSION['user_sistema'];
	
	$name_tpl="editarpregunta_productoxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);

	$t->set_var("idioma", $idioma);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar comentario productos");
	$t->set_var("categoria_modulo", "Editar comentario");
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idioma","_block_idioma");
	while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_nombre", $row[nombre]);
		$t->parse("_block_idioma","block_idioma",true);
		}
		
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");	

	while($row=mysql_fetch_array($result)){
	
		$resultComentario=mysql_query("select si.*,s.* from ".$tof_comentariosxproductos." s join ".$tof_comentariosxproductosxidioma." si on (s.id=si.id) where s.id=".$id_comentario." and si.idioma='".$row[idioma]."'");
		
	
		if (mysql_num_rows($resultComentario)){

			while($rowComentario=mysql_fetch_array($resultComentario)){
				$id_usuario=$rowProducto[id_usuario];
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("nombre_cliente", $rowComentario[nombre]);
				$t->set_var("email_cliente", $rowComentario[email]);
				$t->set_var("comentario", $rowComentario[comentario]);
				$t->set_var("fecha_publicacion", $rowComentario[fecha_publicacion]);
				$t->set_var("publicado", $rowComentario[publicado]);
				$t->set_var("respuesta", $rowComentario[respuesta]);
								
				$t->parse("_block_idiomas1","block_idiomas1",true);
			}
		}else{
			$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("nombre_cliente", "");
				$t->set_var("email_cliente", "");
				$t->set_var("comentario", "");
				$t->set_var("fecha_publicacion", "");
				$t->set_var("publicado", "");
				$t->set_var("respuesta", "");
								
				$t->parse("_block_idiomas1","block_idiomas1",true);
		}
	}
	
	$result1=mysql_query("select se.id,p.id_producto,p.publicado from ".$tof_productos." se join ".$tof_comentariosxproductos." p on (p.id_producto=se.id) where p.id=".$id_comentario);
	$row1=mysql_fetch_array($result1);
	if($row1[publicado]==1)
		$publicado='checked';
	else
		$publicado='';
		
	$t->set_var("publicado", $publicado);
	$t->set_var("id_comentario", $id_comentario);
	$t->set_var("id_producto", $row1[id_producto]);


	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    
	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Usuario");
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editarpregunta_productoxusuario_ok(){
	global $tof_productos, $tof_productosxidioma,$tof_comentariosxproductos, $tof_comentariosxproductosxidioma,$tof_idioma,$id_comentario,$tof_usuarios_sistema,$id_producto,$id_producto;
	
	$id_usuario=$_SESSION['user_sistema'];
	
	if (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_padre=$nombre_subseccion;
		
	global $respuesta;
	 
	 	mysql_query("update ".$tof_comentariosxproductosxidioma." set respuesta='".$respuesta."' where id=".$id_comentario);

	mostrarpregunta_productoxusuario($id_producto);
}

function eliminarpregunta_productoxusuario(){
	global $tof_usuarios_sistema,$tof_productos, $tof_productosxidioma,$tof_comentariosxproductos, $tof_comentariosxproductosxidioma, $id_comentario;
	$id_usuario=$_SESSION['user_sistema'];


	$name_tpl="eliminarpregunta_productoxusuario.htm";
	$t = new Template("./modulos/usuarios_sistema/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar pregunta producto");
	$t->set_var("categoria_modulo", "Eliminar pregunta");

	$result=mysql_query("select si.*,s.id_producto,s.publicado,s.fecha_publicacion from ".$tof_comentariosxproductos." s join ".$tof_comentariosxproductosxidioma." si on (s.id=si.id) where s.id=".$id_comentario);

	
	$row=mysql_fetch_array($result);
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("id_producto",$row[id_producto]);
	$t->set_var("nombre_cliente",$row[nombre]);
	$t->set_var("email_cliente",$row[email]);
	$t->set_var("fecha_publicacion",$row[fecha_publicacion]);
	$t->set_var("comentario",$row[comentario]);
	$t->set_var("respuesta",$row[respuesta]);
	$t->set_var("publicado",$publicado);
	$t->set_var("id_comentario",$row[id]);

	$result=mysql_query("select * from ".$tof_usuarios_sistema." u where u.id=".$id_usuario);
	$row=mysql_fetch_array($result);
	$t->set_var("usuario", $row[nombre]." ".$row[apellido]);
	$t->set_var("titulo", "Usuario");
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminarpregunta_productoxusuario_ok(){
	global $tof_comentariosxproductos,$tof_comentariosxproductosxidioma,$tof_imagenesxproductos,$id_comentario,$id_producto;

	mysql_query("delete from ".$tof_comentariosxproductos." where id=".$id_comentario);
	mysql_query("delete from ".$tof_comentariosxproductosxidioma." where id=".$id_comentario);

	mostrarpregunta_productoxusuario($id_producto);
}

function recuperar_password(){
    $name_tpl="gracias-comentario.htm";
	$t = new Template("modulos/productos/templates", "remove");
	$t->set_file("pl", $name_tpl);

	setearMenu(&$t);
	setearVariablesComunes(&$t);

	
	include_once("include/mail.php");
	$From = "vizzito@hotmail.com";
	$FromName = "vizzito@hotmail.com";
	$To= "martinvizzolini@gmail.com";
	$emailto= "martinvizzolini@gmail.com";
	$body = "lallalalalla";
	$subject = "prueva";
	$resultado=enviar_email($From,$FromName,$To,$body,$subject,$emailto);
	if($resultado==0){
		?>
		<script language="JavaScript" type="text/javascript">
			alert("Error: no se pede enviar email.");	
			history.back(1);
		</script>
		<?
	
	}else{
		$t->parse("MAIN", "pl");
		$t->p("MAIN");
	}
}
?>
