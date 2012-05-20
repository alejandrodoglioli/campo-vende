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
			$t->set_var("id_comercio", "-".$row1[id]);
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
	if (isset($row[title]) and ($row[title]!=""))
		$t->set_var("title", $row[title]);
	else
		$t->set_var("title", $row[nombre]);
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
	
	global $tof_comercios,$tof_comerciosxidioma,$tof_productos,$tof_productosxidioma,$tof_comentariosxcomercios,$tof_comentariosxcomerciosxidioma,$tof_imagenesxproductos,$tof_imagenesxcomercios,$id_comercio,$id_subcomercio,$id_subsubcomercio,$idioma,$pagina,$productos_per_page;

	$captcha_texto = "";

	for ($i = 1; $i <= 6; $i++) {
	$captcha_texto .= caracter_aleatorio();
	}

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
	
		
	if (isset($id_subsubcomercio)){
		
		$id_secc=$id_subsubcomercio;
		
		$t->set_var("id_subcomercio",$id_secc);
				
		$result=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subsubcomercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subcomercio." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$result2=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row2=mysql_fetch_array($result2);
		
		$t->set_var("breadcrum",  '>> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row2[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> '.$row[nombre]);
		
	/*	$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row2['id'].'-'.$row1['id'].'-'.$row['id'].'.htm';
		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}
*/
		
		$separadora = separadorA($idioma,$id_secc);	
		if (preg_match("/".$separadora."/i",$row[nombre])){
			$inicio = strpos($row[nombre],$separadora)+strlen($separadora);
			$destino = substr($row[nombre],$inicio);
		}
		
		$resultenlace2=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where s.id<>".$id_secc." and si.nombre like '%".$destino."%' and si.idioma='".$idioma."' order by rand() limit 12");
		
		$entro=0;
		$t->set_block("pl","b_subcategoria","_b_subcategoria");	
		while($rowenlace2=mysql_fetch_array($resultenlace2)){
			$entro=1;
			$resultenlace1=mysql_query("select si.*,s.id_padre,s.video from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where s.id=".$rowenlace2[id_padre]." and si.idioma='".$idioma."'");
			$rowenlace1=mysql_fetch_array($resultenlace1);
			
			if(isset($rowenlace1[id_padre]) && $rowenlace1[id_padre]!=""){
			$resultenlace=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where s.id=".$rowenlace1[id_padre]." and si.idioma='".$idioma."'");

			
				$rowenlace=mysql_fetch_array($resultenlace);
				if (isset($rowenlace) and ($rowenlace!="")){
					$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace[nombre]))));
					$t->set_var("id_categoria", "-".$rowenlace[id]);
					$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace1[nombre]))));
					$t->set_var("id_subcategoria", "-".$rowenlace1[id]);
					$t->set_var("subsubcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace2[nombre]))));
					$t->set_var("id_subsubcategoria", "-".$rowenlace2[id]);
					$t->set_var("anchor", $rowenlace2[nombre]);
					$t->parse("_b_subcategoria","b_subcategoria",true);
				}else{
					$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace1[nombre]))));
					$t->set_var("id_categoria", "-".$rowenlace1[id]);
					$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace2[nombre]))));
					$t->set_var("id_subcategoria", "-".$rowenlace2[id]);
					$t->set_var("subsubcategoria", "");
					$t->set_var("id_subsubcategoria", "");
					$t->set_var("anchor", $rowenlace2[nombre]);
					$t->parse("_b_subcategoria","b_subcategoria",true);
				}
			}
		}
		
		
	}elseif (isset($id_subcomercio)){
		$id_secc=$id_subcomercio;

		$t->set_var("id_subcomercio",$id_secc);

		$result=mysql_query("select si.*,s.id_padre,s.video from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subcomercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
	/*	$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row1['id'].'-'.$row['id'].'.htm';
		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}
		*/
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> '.$row[nombre]);
		
		$result2=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where s.id_padre=".$id_subcomercio." and si.idioma='".$idioma."' order by nombre limit 180");
		$t->set_block("pl","b_subcategoria","_b_subcategoria");	
		while($row2=mysql_fetch_array($result2)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_categoria", "-".$row1[id]);
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_subcategoria", "-".$row[id]);
			$t->set_var("subsubcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))));
			$t->set_var("id_subsubcategoria", "-".$row2[id]);
			$t->set_var("anchor", $row2[nombre]);
			$t->parse("_b_subcategoria","b_subcategoria",true);		
		}
		
		$resultProducto=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id_comercio=".$id_subcomercio." and si.idioma='".$idioma."' and publicado=1 order by nombre asc limit ".$inicio.",".$productos_per_page);
		$t->set_block("pl","b_productos","_b_productos");	
		while($rowProducto=mysql_fetch_array($resultProducto)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_categoria", "-".$row1[id]);
			$t->set_var("subcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_subcategoria", "-".$row[id]);
			$t->set_var("producto", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowProducto[nombre]))));
			$t->set_var("id_producto", "_".$rowProducto[id]);
			$t->set_var("anchor", $rowProducto[nombre]);
			$t->set_var("contenido_producto", $rowProducto[description]);
			
			//select la imagen
			$resultImages=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxproductos." where id_producto=".$rowProducto[id]." and publicado=1");
			if(mysql_num_rows($resultImages)){
				$rowimagen=mysql_fetch_array($resultImages);
				$t->set_var("imagen_producto", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="'.$rowimagen[path].'" alt="'.$rowimagen[nombre].'" width="100" height="100"/></a></p>');
				
			}
						

			$t->parse("_b_productos","b_productos",true);		
		}
	}else{
		
		$id_secc=$id_comercio;
		$t->set_var("id_comercio",$id_secc);
		
		$result=mysql_query("select si.*,s.id_padre,s.video from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		$t->set_var("breadcrum", ' >> '.$row[nombre]);
		
		$result1=mysql_query("select si.*,s.id_padre from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where s.id_padre=".$id_comercio." and si.idioma='".$idioma."' order by nombre");
		
		$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row['id'];
		if (isset($pagina) && ($pagina!=1)){
			$url_real.='/pagina-'.$pagina.'.htm';
		}else{
			$url_real.='.htm';
		}
		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}
		
		$t->set_block("pl","b_subcategoria","_b_subcategoria");	
		while($row1=mysql_fetch_array($result1)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_categoria", "-".$row[id]);
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_subcategoria", "-".$row1[id]);
			$t->set_var("anchor", $row1[nombre]);
			$t->set_var("contenido_subcategoria", substr(strip_tags($row1[contenido]),0,150)."...");
//select la imagen
			$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxcomercios." where (id_comercio=".$row1[id]." or id_comercio=".$row1[id].") and publicado=1");
			if(mysql_num_rows($result)){
				$rowimagen=mysql_fetch_array($result);
				$t->set_var("imagen_subcategoria", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="'.$rowimagen[path].'" alt="'.$rowimagen[nombre].'" width="150" height="150"/></a></p>');
			}
						
			$t->parse("_b_subcategoria","b_subcategoria",true);		
		}

		$resultProductos=mysql_query("select si.*,s.id_comercio from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id_comercio=".$id_comercio." and si.idioma='".$idioma."' and publicado=1 order by nombre asc limit ".$inicio.",".$productos_per_page);

		
		$t->set_block("pl","b_productos","_b_productos");	
		while($rowProducto=mysql_fetch_array($resultProductos)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_categoria", "-".$row[id]);
			$t->set_var("subcategoria", "");
			$t->set_var("id_subcategoria", "");
			$t->set_var("producto", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowProducto[nombre]))));
			$t->set_var("id_producto", "_".$rowProducto[id]);
			$t->set_var("anchor", $rowProducto[nombre]);
			$t->set_var("contenido_subcategoria", substr(strip_tags($rowProducto[contenido]),0,150)."...");
			$t->set_var("contenido_producto",$rowProducto[description]);
//select la imagen estaaaaaaa
			$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxproductos." where id_producto=".$rowProducto[id]." and publicado=1");
			if(mysql_num_rows($result)){
				$rowimagen=mysql_fetch_array($result);
				$t->set_var("imagen_src", $rowimagen[path]);
				$t->set_var("imagen_nombre",$rowimagen[nombre]);
				
			}else{
					$t->set_var("imagen_src", "/images/default.jpg");
				    $t->set_var("imagen_nombre","sin foto");
			}
						
			$t->parse("_b_productos","b_productos",true);		
		}
		
		
	} 
	
	if ($entro==0){
		$t->set_var("enlacesubcategoriasvisibles", "display:none");
	
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

	$separadora = separadorA($idioma,$row[id]);	
	if (preg_match("/".$separadora."/i",$row[nombre])){
		$inicio = strpos($row[nombre],$separadora)+strlen($separadora);
		$destino = substr($row[nombre],$inicio);
		if (strstr($row[nombre],separadorDE($idioma))){
			$inicio = strpos($row[nombre],separadorDE($idioma))+strlen(separadorDE($idioma));
			$fin=strpos($row[nombre],$separadora)-(strpos($row[nombre],separadorDE($idioma))+strlen(separadorDE($idioma)));
			$origen = substr($row[nombre],$inicio,$fin);
			
			$t->set_var("onload","onload=\"initialize('$origen','$destino');\"");
			$t->set_var("mapa",'<div class="mapa"><form action="#" onsubmit="showAddress(this.address.value); return false">
								  <div id="map_canvas" style="width:640px; height: 350px"></div>
								  <p>
									<input type="text" size="38" name="address" value="form: '.$origen.' to: '.$destino.'" />
									<input type="submit" value="{traduccion_buscar}" id="boton" />
								  </p>
								</form>
							</div>');
		}else{
			$t->set_var("onload","onload=\"initialize('','$destino');\"");
			$t->set_var("mapa",'<div class="mapa"><form action="#" onsubmit="showAddress(this.address.value); return false">
								  <div id="map_canvas" style="width: 640px; height: 350px"></div>
								  <p>
									<input type="text" size="38" name="address" value="'.$destino.'" />
									<input type="submit" value="{traduccion_buscar}" id="boton" />
								  </p>
								</form>
							</div>');

		}
	}else{
		$t->set_var("destino", "");
		$t->set_var("onload","");
		$t->set_var("mapa","");
	}
	
	
	$t->set_var("id_comercio", $id_secc);	
	$t->set_var("titulo", $row[nombre]);
	$t->set_var("contenido", $row[contenido]);
	
	if (isset($row[video]) and ($row[video]!=NULL))
		$t->set_var("video", 
		'<!-- Video 1-->
		
		<div class="entry">	
		<p class="meta">Videos Hacienda</p>
		<iframe width="480" height="390" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/'.$row[video].'"></iframe></div>
		<!-- Fin video-->');

	else
		$t->set_var("video", "");
	
	$t->set_var("description", $row[description]);
	if (isset($row[title]) and ($row[title]!=""))
		$t->set_var("title", $row[title]);
	else
		$t->set_var("title", $row[nombre]);
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
/*	Saque comentarios de comercios
	$result=mysql_query("select si.*,s.fecha_publicacion from ".$tof_comentariosxcomercios." s join ".$tof_comentariosxcomerciosxidioma." si on (s.id=si.id) where s.id_comercio=".$id_secc." and publicado=1 and si.idioma='".$idioma."' order by fecha_publicacion desc");

	if(mysql_num_rows($result)){
		$t->set_var("comentariosvisibles", "");
		$t->set_block("pl","block_comentarios","_block_comentarios");	
		while($row=mysql_fetch_array($result)){
			$t->set_var("nombre", $row[nombre]);
			$t->set_var("comentario", $row[comentario]);
			$t->set_var("fecha_publicacion", $row[fecha_publicacion]);
			$t->parse("_block_comentarios","block_comentarios",true);
		}
	}else{
		$t->set_var("comentariosvisibles", "display:none;");
	}
	*/
	setearMenu(&$t,$id_secc);
	setearVariablesComunes(&$t);
	setearBanners(&$t,$id_secc);
	
	$t->set_var("float", '');
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_comentario(){
global $tof_comercios,$tof_comerciosxidioma,$tof_comentariosxcomercios,$tof_comentariosxcomerciosxidioma,$id_comercio,$id_subsubcomercio,$id_subcomercio,$nombre, $email, $comentario,$idioma;

	$name_tpl="gracias-comentario.htm";
	$t = new Template("modulos/comercios/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	if (isset($id_subsubcomercio) && ($id_subsubcomercio!="")){

		$id_secc=$id_subsubcomercio;

		$result=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subsubcomercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subcomercio." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$result2=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row2=mysql_fetch_array($result2);
		
		$t->set_var("breadcrum",  '>> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row2[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row2[id].'-'.$row1[id].'-'.$row[id].' title="'.$row[nombre].'">'.$row[nombre].'</a> >> Gracias');
	}elseif (isset($id_subcomercio) && ($id_subsubcomercio!="")){

		$id_secc=$id_subcomercio;
		
		$result=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_subcomercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'.htm" title="'.$row[nombre].'">'.$row[nombre].'</a> Gracias');
		
	
	}else{
		
		$id_secc=$id_comercio;
		$result=mysql_query("select si.* from ".$tof_comercios." s join ".$tof_comerciosxidioma." si on (s.id=si.id) where si.id=".$id_comercio." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'.htm" title="'.$row[nombre].'">'.$row[nombre].'</a> >> Gracias');
		}	
		
	mysql_query("insert into ".$tof_comentariosxcomercios." values('NULL','".date("Y-m-d")."',0,".$id_secc.")");
	$last_id = mysql_insert_id();
	
	mysql_query("insert into ".$tof_comentariosxcomerciosxidioma." values(".$last_id.",'".$idioma."','".$nombre."','".$email."','".$comentario."')");

	$t->set_var("titulo", "Comentario enviado correctamente");
	$t->set_var("contenido", "Gracias por contactarse con Campo-Vende.com.ar");
	$t->set_var("description", "En caso que lo haya solicitado nuestro equipo se pondra en contacto con usted a la brevedad");
	$t->set_var("title", "Gracias por su comentario");
	$t->set_var("keywords", "");
	$t->set_var("idioma", $idioma);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

	}	
?>
