<?php
session_start();
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

function crearRSS($path=""){
global $tof_noticias,$tof_noticiasxidioma,$tof_modulos,$tof_modulosxidioma,$tof_idioma,$path_images,$urlSite;

 	$result=mysql_query("select idioma from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){	
	$archivo = 'feed_'.$row[idioma].'.xml';

	$fp = fopen($path.$archivo, "w+");
	
	$sitemap='<?xml version="1.0" encoding="ISO-8859-1"?>';
	$sitemap.='<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
						<channel>
							<title>RSS de '.$urlSite.'</title>
							<link>'.$urlSite.'feed.xml</link>
							<description>RSS de Alojandome.com</description>
							<language>'.$row[idioma].'</language>
							<sy:updatePeriod>hourly</sy:updatePeriod>
							<sy:updateFrequency>1</sy:updateFrequency>
';
								
		$result2=mysql_query("select mi.nombre,m.id,m.path from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$row[idioma]."' and m.habilitado=1 and mi.nombre<>'secciones' and m.path='noticias' order by m.orden ");
		$row2=mysql_fetch_array($result2);

		$result4=mysql_query("select n.fecha_publicacion,ni.titulo,ni.headline,ni.id from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$row[idioma]."' order by n.fecha_publicacion desc limit 15");	
		
		while($row4=mysql_fetch_array($result4)){
			if ($row4[titulo]!=''){
			$sitemap.='
						<item>
							<title>'.$row4[titulo].'</title>
							<link>'.$urlSite.'/'.$row[idioma].'/'.strtolower(str_replace(" ","-" ,$row2[nombre]))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row4[titulo])))."-".$row4[id].'.htm</link>
							<pubDate>'.$row4[fecha_publicacion].'</pubDate>
							<description>'.$row4[headline].'</description>
						</item>';
				}
			}
	$sitemap.='
	</channel>
</rss>';

	$write = fputs($fp, $sitemap);
fclose($fp);
	}
}

function crearSitemap(){
global $tof_secciones,$tof_seccionesxidioma,$tof_modulos,$tof_modulosxidioma,$tof_noticias,$tof_noticiasxidioma,$tof_idioma,$path_images,$tof_idioma,$urlSite;

 	$result=mysql_query("select idioma from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$archivo = 'sitemap_'.$row[idioma].'.xml';
		$fp = fopen('../'.$archivo, "w+");
		$idioma=$row[idioma];
		$result1=mysql_query("select si.nombre,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$row[idioma]."' and s.publicado=1 and id_padre=0 order by s.orden");
$prioridad=1;
$sitemap='<?xml version="1.0" encoding="UTF-8"?>';
	$sitemap.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
						<url>
							<loc>'.$urlSite.'</loc>
								<priority>'.$prioridad.'</priority>
								<changefreq>daily</changefreq>
						</url>';
						
		$prioridad=0.8;	
		while($row1=mysql_fetch_array($result1)){
				$sitemap.='
								<url>
									<loc>'.$urlSite.'/'.$row[idioma].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm</loc>
									<priority>'.$prioridad.'</priority>
									<changefreq>daily</changefreq>
								</url>';
				
				
				$result2=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$row[idioma]."' and s.publicado=1 and s.id_padre=".$row1[id]." order by s.orden");
			
				if (mysql_num_rows($result2)){
					$prioridad=0.5;	
					$subsecciones="";
					$submenu='';
					while($row2=mysql_fetch_array($result2)){
						$sitemap.='
								<url>
									<loc>'.$urlSite.'/'.$row[idioma].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row1[id].'-'.$row2[id].'.htm</loc>
									<priority>'.$prioridad.'</priority>
									<changefreq>daily</changefreq>
								</url>';
								
								$result3=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$row[idioma]."' and s.publicado=1 and s.id_padre=".$row2[id]." order by s.orden");
								
								if (mysql_num_rows($result3)){
									$prioridad=0.3;	
									$subsecciones="";
									$submenu='';
									while($row3=mysql_fetch_array($result3)){
										$sitemap.='
												<url>
													<loc>'.$urlSite.'/'.$row[idioma].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row3[nombre]))).'-'.$row1[id].'-'.$row2[id].'-'.$row3[id].'.htm</loc>
													<priority>'.$prioridad.'</priority>
													<changefreq>daily</changefreq>
												</url>';
													}
												}
								
						}
				}
								
			}
		
			$prioridad=0.5;
			$result3=mysql_query("select mi.nombre,m.id,m.path from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$row[idioma]."' and m.habilitado=1 and mi.nombre<>'secciones' order by m.orden ");
			while($row3=mysql_fetch_array($result3)){
				if (($row3[path]!='newsletters') and ($row3[path]!='secciones')){
					
					$sitemap.='
								<url>
									<loc>'.$urlSite.'/'.$row[idioma].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row3[nombre]))).'.htm</loc>
									<priority>'.$prioridad.'</priority>
									<changefreq>daily</changefreq>
								</url>';
					
			
					if ($row3[path]=="noticias"){
							$prioridad=0.3;
							$result4=mysql_query("select ni.titulo,ni.headline,ni.id from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$row[idioma]."'");					
							while($row4=mysql_fetch_array($result4)){
							$sitemap.='
								<url>
									<loc>'.$urlSite.'/'.$row[idioma].'/'.strtolower(str_replace(" ","-" ,$row3[nombre]))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row4[titulo])))."-".$row4[id].'.htm</loc>
									<priority>'.$prioridad.'</priority>
									<changefreq>daily</changefreq>
								</url>';
															
								}
						}
				
					}
			}
	
	$prioridad=0.2;
	$sitemap.='
	<url>
		<loc>'.$urlSite.'/'.$idioma.'/contacto.htm</loc>
		<priority>'.$prioridad.'</priority>
		<changefreq>daily</changefreq>
	</url>
	<url>
		<loc>'.$urlSite.'/'.$idioma.'/feed</loc>
		<priority>'.$prioridad.'</priority>
		<changefreq>daily</changefreq>
	</url>
</urlset>';

	$write = fputs($fp, $sitemap);
fclose($fp);
	}
	
}

function setear_menu($t)
{	global $tof_modulos,$tof_modulosxidioma;

	$result=mysql_query("select m.*,mi.nombre from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) join idioma i on (i.idioma=mi.id_idioma) where m.habilitado=1 and i.idioma='es'");

	if (mysql_num_rows($result)){
	$t->set_block("pl","block_modulos_menu","_block_modulos_menu");	
    while($row=mysql_fetch_array($result)){
			$t->set_var("imagen", $row[imagen_modulo]);
			$t->set_var("nombre", $row[nombre]);
			$t->set_var("action", $row[action]);
			$t->set_var("path", $row[path]);
		 $t->parse("_block_modulos_menu","block_modulos_menu",true);
	}
	}
	}
	
function setearVariablesComunes($t){
	global $urlSite,$tof_configuracion;
	
	$result=mysql_query("select nombre_empresa from ".$tof_configuracion." where id=0");
	$row=mysql_fetch_array($result);
	
	$t->set_var("empresa", $row[nombre_empresa]);
	
	$t->set_var("usuario", $_SESSION['login']);
	
	}


function mostrar_home()
{
	$home="home.htm";
	$t = new Template("./templates", "keep");
	$t->set_file("pl", $home);
	
	crearSitemap();
	crearRSS("../");
	
	//$usuario=retorna_usuario();
	$t->set_var("id_usuario", $usuario[0][id]);
	$t->set_var("nombre", $usuario[0][nombre]);
	$t->set_var("apellido", $usuario[0][apellidos]);
	$t->set_var("email", $usuario[0][email]);
	$t->set_var("usuario", $usuario[0][login]);
	$t->set_var("contrasena1", base64_decode($usuario[0][pass]));
	$t->set_var("contrasena2", base64_decode($usuario[0][pass]));

	$t->set_var("menu", "");
	$t->set_var("contenido", 'Bienvenido/a, '.$_SESSION['login']);
	$t->set_var("raiz", $pathGeneral);
	$t->set_var("title", $home);
		
	setear_menu(&$t);
    setearVariablesComunes(&$t);
		
	$t->parse("MAIN", "pl");
	$t->p("MAIN");
}


?>
