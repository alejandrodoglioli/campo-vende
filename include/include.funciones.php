<?PHP
function separadorDE($idioma){
switch ($idioma) {
   case "es" :
		return " de ";
   case "en" :	
		return " from ";
   case "fr" :	
		return " de ";
   case "it" :	
		return " da ";
   case "de" :	
		return " from ";
   default :
	 return " de ";
	 }
}

function separadorA($idioma,$id_seccion){
global $tof_secciones;
$result=mysql_query("select s.id_tiposeccion from ".$tof_secciones." s where s.id=".$id_seccion);
$row=mysql_fetch_array($result);
if ($row[id_tiposeccion]==3){ //es un coche
	switch ($idioma) {
	   case "es" :
			return " coche ";
	   case "en" :	
			return " to ";
	   case "fr" :	
			return " à ";
	   case "it" :	
			return " a ";
	   case "de" :	
			return " a ";
	   default :
		 return " a ";
		 }
}if ($row[id_tiposeccion]==5){ //es un coche
	switch ($idioma) {
	   case "es" :
			return "cruceros ";
	   case "en" :	
			return " to ";
	   case "fr" :	
			return " à ";
	   case "it" :	
			return " a ";
	   case "de" :	
			return " a ";
	   default :
		 return " a ";
		 }
}elseif ($row[id_tiposeccion]==2){// es un hotel
	switch ($idioma) {
	   case "es" :
			return " en ";
	   case "en" :	
			return " in ";
	   case "fr" :	
			return " en ";
	   case "it" :	
			return " a ";
	   case "de" :	
			return " in ";	
	   default :
		 return " en ";
		 }
}else{
switch ($idioma) {
	   case "es" :
			return " a ";
	   case "en" :	
			return " to ";
	   case "fr" :	
			return " à ";
	   case "it" :	
			return " a ";
	   case "de" :	
			return " a ";
	   default :
		 return " a ";
		 }
}
}

function detectar_idioma(){
	global $tof_idioma;

	$idioma = 'no';
	//revisamos cabecera HTTP_ACCEPT_LANGUAGE	
	$idiomas = explode(";", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	$result=mysql_query("select idioma from ".$tof_idioma. " where publicado=1 order by orden");
	while($row=mysql_fetch_array($result)){
	
		if(strpos($idiomas[0], $row[idioma]) !== FALSE){
		$idioma = $row[idioma];
		}
	}
		//Ante cualquier otro idioma devolvemos "es"
		if($idioma == "no")
			$idioma = "es";
	return $idioma;
}


function sacar_acentos($s){
		 //Despues de  adquirir $message por cualquier medio, cambio codificacion de acentos
	$s = preg_replace("/[áàâãª]/","a",$s);
	$s = preg_replace("/[ÁÀÂÃ]/","A",$s);
	$s = preg_replace("/[ÍÌÎ]/","I",$s);
	$s = preg_replace("/[íìî]/","i",$s);
	$s = preg_replace("/[éèê]/","e",$s);
	$s = preg_replace("/[ÉÈÊ]/","E",$s);
	$s = preg_replace("/[óòôõº]/","o",$s);
	$s = preg_replace("/[ÓÒÔÕ]/","O",$s);
	$s = preg_replace("/[úùûü]/","u",$s);
	$s = preg_replace("/[ÚÙÛ]/","U",$s);
	$s = str_replace("ç","c",$s);
	$s = str_replace("Ç","C",$s);
	$s = str_replace("ñ","n",$s);
	$s = str_replace("Ñ","N",$s);
	$s = str_replace('"',"",$s);
	$s = str_replace("'","",$s);
	$s = str_replace(",","",$s);
	$s = str_replace(";","",$s);
	$s = str_replace(".","",$s);
	$s = str_replace(":","",$s);
	$s = str_replace("?","",$s);
	$s = str_replace("?","",$s);
	$s = str_replace("?","",$s);
	$s = str_replace("¿","",$s);
	$s = str_replace("?","e",$s);
	$s = str_replace("!","",$s);
	$s = str_replace("/","",$s);
	$s = str_replace("+","-",$s);
	return $s;
}

function print_prev_next($pfile,$nfile,$album_ID)
{ 
	global $l_previous,$l_next;
 	if($pfile!=false)
		$enlace = "<a href=index.php?action=mostrar_foto&album_ID=$album_ID&photo_ID=$pfile><< $l_previous&nbsp;</a>\n";
	else
		$enlace = "<strong>Debut</strong>\n";
	
	if($nfile!=false)
		$enlace .= "<a href=index.php?action=mostrar_foto&album_ID=$album_ID&photo_ID=$nfile>&nbsp;$l_next >></a>";
	else
		$enlace .= "<strong>Fin</strong>";
	return $enlace;
}

function setearBanners(&$t, $id_seccion=0){
	global $tof_secciones;
	
	$result=mysql_query("select id_padre from ".$tof_secciones." where id=".$id_seccion);
	$row=mysql_fetch_array($result);
	
	$bannerBuscador='<script type="text/javascript"><!--
google_ad_client = "ca-pub-8620105887902491";
/* bannerSuperiorDirectorioEmpresas */
google_ad_slot = "8796177439";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';

	$bannerInferior='<script type="text/javascript"><!--
google_ad_client = "ca-pub-8620105887902491";
/* bannerInferiorDirectorioEmpresas */
google_ad_slot = "3117538719";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
	
	$bannerLateral = '<script type="text/javascript"><!--
google_ad_client = "ca-pub-8620105887902491";
/* bloqueMenuDirectorioEmpresas */
google_ad_slot = "0882371317";
google_ad_width = 200;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
	

	$bannerOferta='<p style="float:left;margin-right:15px;"><script type="text/javascript"><!--
google_ad_client = "ca-pub-8620105887902491";
/* bloqueCentralDirectorioEmpresas */
google_ad_slot = "8549598658";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></p> ';	
	
	
	$t->set_var("bannerBuscador", $bannerBuscador);
	$t->set_var("bannerBuscador", $bannerInferior);
	$t->set_var("bannerLateral", $bannerLateral);
	$t->set_var("bannerOferta", $bannerOferta);
}

function setearVariablesComunes(&$t){
	global $urlSite,$tof_configuracion,$charset;
	
	include_once("traducciones/index.php");
	setearTraducciones($t);
	
	$result=mysql_query("select nombre_empresa,slogan from ".$tof_configuracion." where id=0");
	$row=mysql_fetch_array($result);
	
	if(isset($_SESSION[nombre_user_sistema])){
		$t->set_var("usuario_logueado", $_SESSION[nombre_user_sistema]);
		$t->set_var("link_login_salir",'<a href="'.$urlSite.'/es/login.htm" title="Mi Cuenta">Mi Cuenta</a> | <a href="/es/logout_productoxusuario" title="Salir">Salir</a>');
	}else{
		$t->set_var("usuario_logueado", "");
		$t->set_var("link_login_salir",'<a href="'.$urlSite.'/es/login.htm" title="Login / Registrarse">Login / Registrarse</a>');
	}
	$t->set_var("empresa", $row[nombre_empresa]);
	$t->set_var("title_empresa", strip_tags($row[nombre_empresa]));
	$t->set_var("slogan", $row[slogan]);
	//$t->set_var("dia", date ( "j/m/y" ));
	$t->set_var("charset", $charset);

	$t->set_var("ancho", 'width:536px;');
	$t->set_var("float", 'style="float:left;"');
	$t->set_var("url_actual", $urlSite.$_SERVER['REQUEST_URI']);
	
	$file = $urlSite."/google_analytics.txt";
		if (file_exists($file))
		{
			$fd = fopen($file, "r");
			$content = fread($fd, filesize($file));
			fclose($fd);
			$t->set_var("google_analytics", $content);
		}
	}
	
function setearMenu(&$t,$id_seccion=''){
	global $tof_secciones,$tof_seccionesxidioma,$tof_tiposeccion,$tof_modulos,$tof_modulosxidioma,$tof_modulos,$tof_modulosxidioma,$tof_idioma,$path_images,$idioma,$modulo;
	

	$t->set_var("idioma", $idioma);
	$result=mysql_query("select si.nombre,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and id_padre=0 and menu_lateral=0 order by s.orden");
		
	$t->set_block("pl","block_menu_principal","_block_menu_principal");	
	while($row=mysql_fetch_array($result)){
		if ($row[nombre]!="Home"){
			if($row[id]==$id_seccion){
				$t->set_var("classmenu", "current_page_item");
			}else
				$t->set_var("classmenu", "");

			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path", $urlSite."/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
			
			$t->parse("_block_menu_principal","block_menu_principal",true);
		}else{
			if(($_SERVER["REQUEST_URI"]=="/es/") or ($_SERVER["REQUEST_URI"]=="")){
				$t->set_var("classmenu", "current_page_item");
			}else
				$t->set_var("classmenu", "");
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path", "/".$idioma."/");
			$t->parse("_block_menu_principal","block_menu_principal",true);

		}
	}

	$url=$GLOBALS['HTTP_SERVER_VARS']['REQUEST_URI'];;
	if (($url!="/")and(strlen($url)<20)){
		$classmenu =str_replace("/es/","",str_replace(".htm","",$url));
		$t->set_var("classmenu".$classmenu, "current_page_item");
	}
	
	$result=mysql_query("select si.nombre,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and id_padre=0 and menu_lateral=1 order by s.orden");

	
	$t->set_block("pl","block_secciones","_block_secciones");	
	while($row=mysql_fetch_array($result)){
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
			
			//$t->set_var("path", "/".$idioma."/");
			if($row[id]==$id_seccion){
				$t->set_var("classmenulateral", "current");
			}else
				$t->set_var("classmenulateral", "");
		
		//submenu
		$result1=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row[id]." order by s.orden");
		
		if (mysql_num_rows($result1)){

			$submenu="";
			$submenu.='<ul class="submenu" id="submenu_'.$row[id].'">';
			while($row1=mysql_fetch_array($result1)){
				
				$submenu.='<li '.$class.'><a href="/'.$idioma.'/'.strtolower(str_replace(" ","-" ,$row[nombre])).'/'.strtolower(str_replace(" ","-" ,$row1[nombre])).'-'.$row[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a></li>';
				}
			$submenu.='</ul>';
			$t->set_var("submenu", $submenu);
			$t->set_var("onmouse", 'onMouseover="mostrarSubmenu(\'submenu_'.$row[id].'\');" onMouseout="ocultarSubmenu(\'submenu_'.$row[id].'\');"');
		}else{
			$t->set_var("submenu", "");
			$t->set_var("onmouse", '');
		}

	//	$t->parse("_block_secciones","block_secciones",true);
	
/*
	$submenu="";
 	$result=mysql_query("select mi.nombre,m.id,m.path from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."' and m.habilitado=1 and mi.nombre<>'secciones' and m.publica=1 order by m.orden ");
	while($row=mysql_fetch_array($result)){
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path","/".$idioma."/".strtolower(str_replace(" ","-" ,$row[path])).".htm");
			$t->set_var("subseccion", "");
			$t->set_var("onmouse", "");
			$t->parse("_block_secciones","block_secciones",true);
			}
	*/
	$t->parse("_block_secciones","block_secciones",true);
	}
	
	$result=mysql_query("select si.nombre,s.id from ".$tof_modulos." s join ".$tof_modulosxidioma." si on (s.id=si.id_modulo) where si.id_idioma='".$idioma."' and s.habilitado=1 and publica=1 and si.nombre!='Secciones' order by s.orden");
	$t->set_block("pl","block_menu_principal_modulo","_block_menu_principal_modulo");	
	while($row=mysql_fetch_array($result)){
			if(strtolower($row[nombre])==$modulo){
				$t->set_var("classmenu", "current_page_item");
			}else
				$t->set_var("classmenu", "");
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).".htm");
			$t->parse("_block_menu_principal_modulo","block_menu_principal_modulo",true);
	}

	$result=mysql_query("select nombre,nombre_imagen,idioma from ".$tof_idioma. " where publicado=1 order by orden");
	$t->set_block("pl","block_idiomas","_block_idiomas");	
	while($row=mysql_fetch_array($result)){
		$t->set_var("idioma_bandera", $row[idioma]);
		$t->set_var("image_idioma", $path_images.$row[nombre_imagen]);
		$t->set_var("nombre_idioma", $row[nombre]);
		$t->parse("_block_idiomas","block_idiomas",true);
	}

	/*nube de tags*/
	if ($id_seccion!=''){
		$resultiposeccion=mysql_query("select s.id_tiposeccion,s.id from ".$tof_secciones." s where s.id=".$id_seccion);
		$rowtiposeccion=mysql_fetch_array($resultiposeccion);
		
		$resulttag=mysql_query("select s.id_padre, si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.id<>".$rowtiposeccion[id]." and s.id_tiposeccion=".$rowtiposeccion[id_tiposeccion]." order by rand() limit 15");
	}else{	
		$resulttag=mysql_query("select s.id_padre, si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' order by rand() limit 15");
	}
	
	$t->set_block("pl","tags","_tags");	
		while($rowtag=mysql_fetch_array($resulttag)){
			if ($rowtag[id_padre]==0){
				$enlace =  strtolower(sacar_acentos(str_replace(" ","-" ,$rowtag[nombre])))."-".$rowtag[id];
				}
			else{
				$resulttag1=mysql_query("select  s.id_padre, si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$rowtag[id_padre]." and  si.idioma='".$idioma."'");
			
				$rowtag1=mysql_fetch_array($resulttag1);
				if ($rowtag1[id_padre]==0){
					$enlace =  strtolower(sacar_acentos(str_replace(" ","-" ,$rowtag1[nombre])))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$rowtag[nombre])))."-".$rowtag1[id]."-".$rowtag[id];
					}
				else{
				$resulttag2=mysql_query("select s.id_padre, si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$rowtag1[id_padre]." and  si.idioma='".$idioma."'");
				$rowtag2=mysql_fetch_array($resulttag2);
				$enlace = strtolower( sacar_acentos(str_replace(" ","-" ,$rowtag2[nombre])))."/".strtolower( sacar_acentos(str_replace(" ","-" ,$rowtag1[nombre])))."/".strtolower( sacar_acentos(str_replace(" ","-" ,$rowtag[nombre])))."-".$rowtag2[id]."-".$rowtag1[id]."-".$rowtag[id];
				}
			}

			$t->set_var("enlace", $enlace);			
			$t->set_var("anchortag", $rowtag[nombre]);
			$t->set_var("tam", rand(6,18)."px");	
			$t->parse("_tags","tags",true);		
		}
		/*fin nube de tags*/
}

function mostrarHome(){
	global $tof_index,$tof_modulos,$tof_modulosxidioma,$tof_secciones,$tof_seccionesxidioma,$tof_noticiasxidioma,$tof_noticias,$tof_imagenesxnoticias,$cant_noticias_home,$idioma;
	
	if(!isset($idioma) or ($idioma=='')){
	// para que muestre la pagina en el idioma del navegador
		$idioma=detectar_idioma();
	}
	$name_tpl="home.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$results=mysql_query("select si.contenido,si.description,si.keywords,si.title from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and nombre='Home'");

	$row2=mysql_fetch_array($results);
	
	if ((isset($row2[title])) and ($row2[title]!="") ){
		$t->set_var("title", $row2[title]);
		$t->set_var("titulo", $row2[title]);
	}else{
		$t->set_var("title", "Home");
		$t->set_var("titulo", "Home");
	}

	$t->set_var("contenido", $row2[contenido]);
	$t->set_var("keywords", $row2[keywords]);
	$t->set_var("description", $row2[description]);

	
	$resultm=mysql_query("select m.path,mi.nombre from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."' and path='noticias'");
	$row1=mysql_fetch_array($resultm);


	$result=mysql_query("select ni.titulo,ni.headline,ni.id,DATE_FORMAT(n.fecha_publicacion,'%d/%m/%Y') as fecha_publicacion from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where n.publicado=1 and  ni.idioma='".$idioma."' order by n.fecha_publicacion desc limit ".$cant_noticias_home);

	$t->set_block("pl","block_noticias","_block_noticias");	
	while($row=mysql_fetch_array($result)){
		if ($row[titulo]!=""){
			$t->set_var("titulo_noticia", $row[titulo]);
			$t->set_var("fecha_noticia", $row[fecha_publicacion]);
			
			$resulti=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxnoticias." where id_noticia=".$row[id]." and publicado=1 limit 1");
			$imagen="";
			if(mysql_num_rows($resulti)){
				$rowi=mysql_fetch_array($resulti);
				$imagen='<p class="imagen"><img src="'.$rowi[path].'" alt="'.$rowi[nombre].'" width="75" height="75" /></p>';
			}
			
			$t->set_var("headline_noticia", $imagen.$row[headline]);
			$t->set_var("enlace_noticia", "/".$idioma."/".strtolower(str_replace(" ","-" ,$row1[nombre]))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[titulo])))."-".$row[id].".htm");
			$t->parse("_block_noticias","block_noticias",true);
			}
		
	}
	
	$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre>=2 and s.id_padre<=13 and si.idioma='".$idioma."' order by rand() limit 12");
	
	
	//$row1=mysql_fetch_array($result1);
	//$result2=mysql_query("select si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=".$row1['id']." and s.id_padre!='' and si.idioma='".$idioma."' order by rand() limit 12");
	
		$t->set_block("pl","block_destacados_hostales","_block_destacados_hostales");	
		while($row1=mysql_fetch_array($result1)){
			$result=mysql_query("select si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$row1['id_padre']." and si.idioma='".$idioma."'");
			$row=mysql_fetch_array($result);
	
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("id_categoria", $row[id]);			
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_subcategoria", $row1[id]);
			//$t->set_var("subsubcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))));
			//$t->set_var("id_subsubcategoria", $row2[id]);
			$t->set_var("anchor", $row1[nombre]);
			$t->parse("_block_destacados_hostales","block_destacados_hostales",true);		
		}
	
	/*$result=mysql_query("select si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=2 and si.idioma='".$idioma."'");
	$row=mysql_fetch_array($result);
	$result1=mysql_query("select si.* from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=2 and si.idioma='".$idioma."' order by rand() limit 12");
	
		$t->set_block("pl","block_destacados_ferries","_block_destacados_ferries");	
		while($row1=mysql_fetch_array($result1)){
			$t->set_var("categoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))));
			$t->set_var("subcategoria", strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))));
			$t->set_var("id_subcategoria", $row1[id]);
			$t->set_var("anchor", $row1[nombre]);
			$t->parse("_block_destacados_ferries","block_destacados_ferries",true);		
		}
		*/
	
			
	setearMenu($t);
	setearVariablesComunes($t);
	setearBanners($t,1);
	
		
	$t->set_var("float", '');
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}


?>
