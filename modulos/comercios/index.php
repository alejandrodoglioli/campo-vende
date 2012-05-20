<?PHP

function caracter_aleatorio() {
mt_srand((double)microtime()*1000000);
$valor_aleatorio = mt_rand(1,3);
switch ($valor_aleatorio) {
case 1:
$valor_aleatorio = mt_rand(97, 122);
break;
case 2:
$valor_aleatorio = mt_rand(48, 57);
break;
case 3:
$valor_aleatorio = mt_rand(65, 90);
break;
}
return chr($valor_aleatorio);
}

function mostrar_comercios(){
	
	global $tof_usuarios_sistema,$tof_productos,$tof_imagenesxusuarios,$id_comercio,$id_subcomercio,$idioma,$pagina,$comercios_per_page;

	$captcha_texto = "";

	for ($i = 1; $i <= 6; $i++) {
	$captcha_texto .= caracter_aleatorio();
	}

	$name_tpl="comercios.htm";
	$t = new Template("modulos/comercios/templates", "remove");
	$t->set_file("pl", $name_tpl);

	$t->set_var("SID",$SID);
	$t->set_var("captcha_texto_session",$captcha_texto);
	
	$url = $_SERVER['REQUEST_URI'];
		
	if(isset($pagina)){
		$inicio = ($productos_per_page*($pagina-1));
	}else{
		$pagina=1;
		$inicio = 0;
	}

	$resultComercios=mysql_query("select s.*,count(p.id) as cant_productos from ".$tof_usuarios_sistema." s join ".$tof_productos." p on(s.id=p.id_usuario) where id_tipousuario!=1 and s.activo=1 group by s.id order by nombre asc limit ".$inicio.",".$comercios_per_page);
			
		$t->set_block("pl","b_comercios","_b_comercios");	
		while($row=mysql_fetch_array($resultComercios)){
			$entro=1;
			$t->set_var("nombre_comercio", $row[nombre]);
			$t->set_var("id_comercio", $row[id]);
			$t->set_var("comercio", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("contenido_comercio", $row[description]);
			$t->set_var("cant_productos", $row[cant_productos]);
			
			//select la imagen
			$resultImages=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxusuarios." where id_producto=".$rowProducto[id]." and publicado=1");
			if(mysql_num_rows($resultImages)){
				$rowimagen=mysql_fetch_array($resultImages);
				$t->set_var("imagen_src", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="'.$rowimagen[path].'" alt="'.$rowimagen[nombre].'" width="100" height="100"/></a></p>');
			}else{
				$t->set_var("imagen_src", '/images/default.jpg');
			}
			
			$t->parse("_b_comercios","b_comercios",true);		
		}
		
//paginado
	$resultcant=mysql_query("select count(*) as cant from ".$tof_productos." n join ".$tof_productosxidioma." ni on (n.id=ni.id) where ni.idioma='".$idioma."' and id_comercio=".$id_secc." and publicado=1 order by ni.nombre desc");
			
	$rowcant=mysql_fetch_array($resultcant);
	$nb=$rowcant[cant];
		
	$nb_page=intval(ceil($nb/$productos_per_page));
	
	$t->set_var("pagina",$pagina);
	$t->set_var("cant_paginas",$nb_page);
		
	if ($nb_page>1){
		$t->set_block("pl","block_paginas","_block_paginas");	
		for($i=1;$i <= $nb_page; $i++){
			$t->set_var("nro",$i);
			if($i!=1)
				$t->set_var("nro_pagina","/pagina-".$i);
			else
				$t->set_var("nro_pagina","");

			if($i==$pagina)
				$t->set_var("selected_pagina",'class="selected_pagina"');
			else
				$t->set_var("selected_pagina",'');

			$t->set_var("path",strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id]);
			$t->parse("_block_paginas","block_paginas",true);
		}



		if ($pagina>1){
		if ($pagina-1 !=1)
			$t->set_var("anterior",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'/pagina-'.($pagina-1).'.htm"><< Anterior</a>');
		else
			$t->set_var("anterior",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'.htm"><< Anterior</a>');
			
		}
		
		if ($pagina<$nb_page)
			$t->set_var("siguiente",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'/pagina-'.($pagina+1).'.htm">Siguiente >></a>');
	}
//fin paginado

	
	$t->set_var("id_comercio", $id_comercio);	
	$t->set_var("titulo", $row[nombre]);
	$t->set_var("contenido", $row[contenido]);
	
		
	$t->set_var("description", $row[description]);
	$t->set_var("title","Nuestros Comercios");
	
	$t->set_var("keywords", $row[keywords]);
	$t->set_var("idioma", $row[idioma]);
	
	$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxcomercios." where (id_comercio=".$id_secc." or id_comercio=".$row[id_padre].") and publicado=1");
	if(mysql_num_rows($result)){
		$t->set_block("pl","block_imagenes","_block_imagenes");	
		$t->set_block("pl","block_imagenes_principio","_block_imagenes_principio");	
		while($row=mysql_fetch_array($result)){
			if($row[principio]==0){
				$t->set_var("imagen", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				$t->parse("_block_imagenes","block_imagenes",true);
			}else{
				$t->set_var("imagen_principio", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				//$t->parse("_block_imagenes_principio","block_imagenes_principio",true);			
			}
		}	
	}

	setearMenu(&$t,$id_secc);
	setearVariablesComunes(&$t);
	setearBanners(&$t,$id_secc);
	
	$t->set_var("float", '');
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function mostrar_comercio(){
	global $tof_usuarios_sistema,$tof_secciones,$tof_seccionesxidioma,$tof_productos,$tof_productosxidioma,$tof_comentariosxcomercios,$tof_comentariosxcomerciosxidioma,$tof_imagenesxproductos,$tof_imagenesxcomercios,$id_comercio,$idioma,$pagina,$productos_per_page;

	$name_tpl="comercio.htm";
	$t = new Template("modulos/comercios/templates", "remove");
	$t->set_file("pl", $name_tpl);

	$t->set_var("SID",$SID);
	$t->set_var("captcha_texto_session",$captcha_texto);
	
	$url = $_SERVER['REQUEST_URI'];
		
	if(isset($pagina)){
		$inicio = ($productos_per_page*($pagina-1));
	}else{
		$pagina=1;
		$inicio = 0;
	}
			
	$resultProducto=mysql_query("select * from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id_usuario=".$id_comercio." and si.idioma='".$idioma."' and publicado=1 order by nombre asc limit ".$inicio.",".$productos_per_page);
		$t->set_block("pl","b_productos","_b_productos");	
		while($rowProducto=mysql_fetch_array($resultProducto)){
			$result=mysql_query("select si.*,s.id_padre,s.video from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$rowProducto[id_seccion]." and si.idioma='".$idioma."'");
			$row=mysql_fetch_array($result);
		
			$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$row[id_padre]." and si.idioma='".$idioma."'");
					
			$entro=1;
			if(isset($row1[nombre]) and ($row1[nombre]!='')){
				$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
				$t->set_var("id_categoria", "-".$row1[id]);
				}
			$t->set_var("subcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_subcategoria", "-".$row[id]);
			$t->set_var("producto", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowProducto[nombre]))));
			$t->set_var("id_producto", "_".$rowProducto[id]);
			$t->set_var("anchor", $rowProducto[nombre]);
			$t->set_var("contenido_producto", $rowProducto[description]);
			$t->set_var("precio", $rowProducto[precio]);
			
			//select la imagen
			$resultImages=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxproductos." where id_producto=".$rowProducto[id]." and publicado=1");
			if(mysql_num_rows($resultImages)){
				$rowimagen=mysql_fetch_array($resultImages);
				$t->set_var("imagen_producto", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="'.$rowimagen[path].'" alt="'.$rowimagen[nombre].'" width="100" height="100"/></a></p>');
				
			}
			$t->parse("_b_productos","b_productos",true);		
		}
		
//paginado
	$resultcant=mysql_query("select count(*) as cant from ".$tof_productos." n join ".$tof_productosxidioma." ni on (n.id=ni.id) where ni.idioma='".$idioma."' and id_comercio=".$id_secc." and publicado=1 order by ni.nombre desc");
			
	$rowcant=mysql_fetch_array($resultcant);
	$nb=$rowcant[cant];
		
	$nb_page=intval(ceil($nb/$productos_per_page));
	
	$t->set_var("pagina",$pagina);
	$t->set_var("cant_paginas",$nb_page);
		
	if ($nb_page>1){
		$t->set_block("pl","block_paginas","_block_paginas");	
		for($i=1;$i <= $nb_page; $i++){
			$t->set_var("nro",$i);
			if($i!=1)
				$t->set_var("nro_pagina","/pagina-".$i);
			else
				$t->set_var("nro_pagina","");

			if($i==$pagina)
				$t->set_var("selected_pagina",'class="selected_pagina"');
			else
				$t->set_var("selected_pagina",'');

			$t->set_var("path",strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id]);
			$t->parse("_block_paginas","block_paginas",true);
		}



		if ($pagina>1){
		if ($pagina-1 !=1)
			$t->set_var("anterior",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'/pagina-'.($pagina-1).'.htm"><< Anterior</a>');
		else
			$t->set_var("anterior",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'.htm"><< Anterior</a>');
			
		}
		
		if ($pagina<$nb_page)
			$t->set_var("siguiente",'<a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].'/pagina-'.($pagina+1).'.htm">Siguiente >></a>');
	}
//fin paginado

	$resultComercio=mysql_query("select s.* from ".$tof_usuarios_sistema." s where id_tipousuario!=1 and s.activo=1 and id=".$id_comercio);
	$row=mysql_fetch_array($resultComercio);
	
	$t->set_var("id_comercio", $id_comercio);	
	$t->set_var("titulo", $row[nombre]);
	$t->set_var("contenido", $row[contenido]);
	
		
	$t->set_var("description", $row[nombre]);
	$t->set_var("title", $row[nombre]);
	
	$t->set_var("keywords", $row[nombre]);
	$t->set_var("idioma", $row[idioma]);
	
	$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxcomercios." where (id_comercio=".$id_secc." or id_comercio=".$row[id_padre].") and publicado=1");
	if(mysql_num_rows($result)){
		$t->set_block("pl","block_imagenes","_block_imagenes");	
		$t->set_block("pl","block_imagenes_principio","_block_imagenes_principio");	
		while($row=mysql_fetch_array($result)){
			if($row[principio]==0){
				$t->set_var("imagen", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				$t->parse("_block_imagenes","block_imagenes",true);
			}else{
				$t->set_var("imagen_principio", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				//$t->parse("_block_imagenes_principio","block_imagenes_principio",true);			
			}
		}	
	}

	setearMenu(&$t,$id_secc);
	setearVariablesComunes(&$t);
	setearBanners(&$t,$id_secc);
	
	$t->set_var("float", '');
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

?>
