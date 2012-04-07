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

function mostrar_producto(){
	global $tof_productos,$tof_productosxidioma,$tof_secciones,$tof_seccionesxidioma,$tof_comentariosxproductos,$tof_comentariosxproductosxidioma,$tof_imagenesxproductos,$id_producto,$id_seccion,$id_subseccion,$idioma;

	$captcha_texto = "";
	for ($i = 1; $i <= 6; $i++) {
	$captcha_texto .= caracter_aleatorio();
	}

	$name_tpl="producto.htm";
	$t = new Template("modulos/productos/templates", "remove");
	$t->set_file("pl", $name_tpl);

	$t->set_var("SID",$SID);
	$t->set_var("captcha_texto_session",$captcha_texto);
	
	$url = $_SERVER['REQUEST_URI'];

	if (isset($id_subsubseccion)){
		$id_secc=$id_subsubseccion;
		
		$t->set_var("id_subseccion",$id_secc);
				
		$result=mysql_query("select si.*,s.id_seccion from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result2=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$id_secc." and si.idioma='".$idioma."'");
		$row2=mysql_fetch_array($result2);
		
		$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$row1[id_padre]." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		
		$t->set_var("breadcrum",  '>> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row2[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> '.$row[nombre]);
		
		$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row2['id'].'-'.$row1['id'].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'_'.$row['id'].'.htm';
		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}

		
		$separadora = separadorA($idioma,$id_secc);	
		if (preg_match("/".$separadora."/i",$row[nombre])){
			$inicio = strpos($row[nombre],$separadora)+strlen($separadora);
			$destino = substr($row[nombre],$inicio);
		}
		
		$resultenlace2=mysql_query("select si.*,s.id_padre from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id<>".$id_secc." and si.nombre like '%".$destino."%' and si.idioma='".$idioma."' order by rand() limit 12");
		
		$entro=0;
		$t->set_block("pl","b_productos","_b_productos");	
		while($rowenlace2=mysql_fetch_array($productos2)){
			$entro=1;
			$resultenlace1=mysql_query("select si.*,s.id_padre,s.video from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$rowenlace2[id_padre]." and si.idioma='".$idioma."'");
			$rowenlace1=mysql_fetch_array($resultenlace1);
			
			if(isset($rowenlace1[id_padre]) && $rowenlace1[id_padre]!=""){
			$resultenlace=mysql_query("select si.*,s.id_padre from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id=".$rowenlace1[id_padre]." and si.idioma='".$idioma."'");

			
				$rowenlace=mysql_fetch_array($resultenlace);
				if (isset($rowenlace) and ($rowenlace!="")){
					$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace[nombre]))));
					$t->set_var("id_categoria", "-".$rowenlace[id]);
					$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace1[nombre]))));
					$t->set_var("id_subcategoria", "-".$rowenlace1[id]);
					$t->set_var("subsubcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace2[nombre]))));
					$t->set_var("id_subsubcategoria", "-".$rowenlace2[id]);
					$t->set_var("anchor", $rowenlace2[nombre]);
					$t->parse("_b_productos","b_productos",true);
				}else{
					$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace1[nombre]))));
					$t->set_var("id_categoria", "-".$rowenlace1[id]);
					$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$rowenlace2[nombre]))));
					$t->set_var("id_subcategoria", "-".$rowenlace2[id]);
					$t->set_var("subsubcategoria", "");
					$t->set_var("id_subsubcategoria", "");
					$t->set_var("anchor", $rowenlace2[nombre]);
					$t->parse("_b_productos","b_productos",true);
				}
			}
		}
		
		
	}elseif (isset($id_subseccion)){
		$id_secc=$id_subseccion;

		$t->set_var("id_subseccion",$id_secc);

		$result=mysql_query("select si.*,s.id_seccion,s.video from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
$result2=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$id_secc." and si.idioma='".$idioma."'");
		$row2=mysql_fetch_array($result2);
		
		$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$row2[id_padre]." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		
		$t->set_var("breadcrum",  '>> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row1[id].'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a> >> '.$row[nombre]);
		
		$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row1['id'].'-'.$row2['id'].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'_'.$row['id'].'.htm';
		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}
		
		
		$result2=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where s.id_padre=".$id_subproducto." and si.idioma='".$idioma."' order by nombre limit 180");
		$t->set_block("pl","b_productos","_b_productos");	
		while($row2=mysql_fetch_array($result2)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_categoria", "-".$row1[id]);
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_subcategoria", "-".$row[id]);
			$t->set_var("subsubcategoria", "/".strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))));
			$t->set_var("id_subsubcategoria", "-".$row2[id]);
			$t->set_var("anchor", $row2[nombre]);
			$t->parse("_b_productos","b_productos",true);		
		}
		
	}else{
		$id_secc=$id_seccion;
		$t->set_var("id_producto",$id_secc);
		
		$result=mysql_query("select si.*,s.id_seccion,s.video from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.*,s.id_padre,s.video from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.id=".$id_secc." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >>'.$row[nombre]);
		
		
		$url_real='/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1['id'].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'_'.$row['id'].'.htm';

		if ($url!=$url_real){
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: /".$url_real);
		}
		
		$t->set_block("pl","b_productos","_b_productos");	
		while($row1=mysql_fetch_array($result1)){
			$entro=1;
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_categoria", "-".$row[id]);
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_subcategoria", "-".$row1[id]);
			$t->set_var("anchor", $row1[nombre]);
			$t->set_var("contenido_subcategoria", substr(strip_tags($row1[contenido]),0,150)."...");
//select la imagen
			$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxproductos." where (id_producto=".$row[id]." or id_producto=".$row1[id].") and publicado=1");
			if(mysql_num_rows($result)){
				$rowimagen=mysql_fetch_array($result);
				$t->set_var("imagen_producto", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="'.$rowimagen[path].'" alt="'.$rowimagen[nombre].'" width="150" height="150"/></a></p>');
			}
						
			$t->parse("_b_productos","b_productos",true);		
		}
	} 
	
	if ($entro==0){
		$t->set_var("enlacesubcategoriasvisibles", "display:none");
	
	}

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
	
	
	$t->set_var("id_producto", $id_producto);	
	$t->set_var("titulo", $row[nombre]);
	$t->set_var("contenido", $row[contenido]);
	//$t->set_var("imagen_producto", '<p style="width:30%;float:left"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."-".$row[id]."-".$row1[id].'.htm"  ><img src="/images/productos/_P1030880.JPG" alt="'.$rowimagen[nombre].'" width="150" height="150"/></a></p>');
		
	
	if (isset($row[video]) and ($row[video]!=NULL))
		$t->set_var("video", 
		'<!-- Video 1-->
		<p class="meta">&nbsp;</p>
		<p class="meta">Videos Hacienda</p>
		<div class="entry">	
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
	
	$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxproductos." where (id_producto=".$id_secc." or id_producto=".$row[id_padre].") and publicado=1");
	if(mysql_num_rows($result)){
		$t->set_block("pl","block_imagenes","_block_imagenes");	
		$t->set_block("pl","block_imagenes_principio","_block_imagenes_principio");	
		while($row=mysql_fetch_array($result)){
			if($row[principio]==0){
				$t->set_var("imagen_producto", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				$t->parse("_block_imagenes","block_imagenes",true);
			}else{
				$t->set_var("imagen_principio", '<p style="width:30%;float:left"><a href="'.$row[path].'"  rel="opendialog"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="150" height="150" /></a></p>');
				//$t->parse("_block_imagenes_principio","block_imagenes_principio",true);			
			}
		}	
	}
	
	$result=mysql_query("select si.*,s.fecha_publicacion from ".$tof_comentariosxproductos." s join ".$tof_comentariosxproductosxidioma." si on (s.id=si.id) where s.id_producto=".$id_secc." and publicado=1 and si.idioma='".$idioma."' order by fecha_publicacion desc");

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
	
	setearMenu(&$t,$id_secc);
	setearVariablesComunes(&$t);
	setearBanners(&$t,$id_secc);
	
	$t->set_var("float", '');
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_comentario(){
global $tof_productos,$tof_productosxidioma,$tof_comentariosxproductos,$tof_comentariosxproductosxidioma,$id_producto,$id_subsubproducto,$id_subproducto,$nombre, $email, $comentario,$idioma;

	$name_tpl="gracias-comentario.htm";
	$t = new Template("modulos/productos/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	
	if (isset($id_subsubproducto) && ($id_subsubproducto!="")){

		$id_secc=$id_subsubproducto;

		$result=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_subsubproducto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_subproducto." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$result2=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row2=mysql_fetch_array($result2);
		
		$t->set_var("breadcrum",  '>> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row2[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row2[id].'-'.$row1[id].'-'.$row[id].' title="'.$row[nombre].'">'.$row[nombre].'</a> >> Gracias');
	}elseif (isset($id_subproducto) && ($id_subsubproducto!="")){

		$id_secc=$id_subproducto;
		
		$result=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_subproducto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		
		$result1=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row1=mysql_fetch_array($result1);
		
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'.htm" title="'.$row[nombre].'">'.$row[nombre].'</a> Gracias');
		
	
	}else{
		
		$id_secc=$id_producto;
		$result=mysql_query("select si.* from ".$tof_productos." s join ".$tof_productosxidioma." si on (s.id=si.id) where si.id=".$id_producto." and si.idioma='".$idioma."'");
		$row=mysql_fetch_array($result);
		$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'.htm" title="'.$row[nombre].'">'.$row[nombre].'</a> >> Gracias');
		}	
		
	mysql_query("insert into ".$tof_comentariosxproductos." values('NULL','".date("Y-m-d")."',0,".$id_secc.")");
	$last_id = mysql_insert_id();
	
	mysql_query("insert into ".$tof_comentariosxproductosxidioma." values(".$last_id.",'".$idioma."','".$nombre."','".$email."','".$comentario."')");

	$t->set_var("titulo", "Gracias por su comentario");
	$t->set_var("contenido", "Gracias por su comentario, el mismo ser� publicado cuando sea validado por nuestro equipo.");
	$t->set_var("description", "Gracias por su comentario, el mismo ser� publicado cuando sea validado por nuestro equipo.");
	$t->set_var("title", "Gracias por su comentario");
	$t->set_var("keywords", "");
	$t->set_var("idioma", $idioma);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

	}	
?>
