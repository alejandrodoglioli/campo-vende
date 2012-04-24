<?PHP
function mostrar_noticias(){
        ?>
		<script type="text/javascript">
			$( "#dialog-modal1" ).dialog({autoOpen: true});
		</script>
		<?
	global $tof_noticias,$tof_noticiasxidioma,$tof_modulos,$tof_imagenesxnoticias,$tof_modulosxidioma,$idioma,$pagina,$noticias_per_page;
	$name_tpl="noticias.htm";
	$t = new Template("modulos/noticias/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	if(isset($pagina)){
		$inicio = ($noticias_per_page*($pagina-1));
	}else{
		$pagina=1;
		$inicio = 0;
	}
	
	$result=mysql_query("select DATE_FORMAT(n.fecha_publicacion,'%d/%m/%Y') as fecha_publicacion,ni.titulo,ni.headline,ni.id from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where n.publicado=1 and ni.idioma='".$idioma."' order by n.fecha_publicacion desc limit ".$inicio.",".$noticias_per_page);
	
	$resultm=mysql_query("select m.path,mi.nombre from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."' and path='noticias'");
	$row1=mysql_fetch_array($resultm);

	$t->set_var("title",$row1[nombre]);
	$t->set_var("titulo",$row1[nombre]);

	$t->set_block("pl","block_noticias","_block_noticias");	
	while($row=mysql_fetch_array($result)){
	   if ($row[titulo]!=""){
		$t->set_var("titulonoticia", $row[titulo]);
		$t->set_var("enlacenoticia", "/".$idioma."/".strtolower(str_replace(" ","-" ,$row1[nombre]))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[titulo])))."-".$row[id].".htm");
		
		$resulti=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxnoticias." where id_noticia=".$row[id]." and publicado=1 limit 1");
		$imagen="";
		if(mysql_num_rows($resulti)){
			$rowi=mysql_fetch_array($resulti);
			$imagen='<p class="imagen"><img src="'.$rowi[path].'" alt="'.$rowi[nombre].'" width="75" height="75" /></p>';
			}

		$t->set_var("headline", $imagen.$row[headline]);
		$t->set_var("fecha", $row[fecha_publicacion]);
		$t->parse("_block_noticias","block_noticias",true);
		}
	}
	
	$resultcant=mysql_query("select count(*) as cant from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$idioma."' and ni.titulo<>'' order by n.fecha_publicacion desc");
			
	$rowcant=mysql_fetch_array($resultcant);
	$nb=$rowcant[cant];
		
	$nb_page=intval(ceil($nb/$noticias_per_page));
	
	$t->set_var("pagina",$pagina);
	$t->set_var("cant_paginas",$nb_page);
	$t->set_var("noticias",$row1[path]);
	
	if ($nb_page>1){
		$t->set_block("pl","block_paginas","_block_paginas");	
		for($i=1;$i <= $nb_page; $i++){
			$t->set_var("nro_pagina",$i);
			if($i==$pagina)
				$t->set_var("selected_pagina",'class="selected_pagina"');
			else
				$t->set_var("selected_pagina",'');
			$t->parse("_block_paginas","block_paginas",true);
		}

	
		if ($pagina>1)
			$t->set_var("anterior",'<a href="/'.$idioma.'/'.$row1[path].'-'.($pagina-1).'.htm"><< Anterior</a>');
		
		if ($pagina<$nb_page)
			$t->set_var("siguiente",'<a href="/'.$idioma.'/'.$row1[path].'-'.($pagina+1).'.htm">Siguiente >></a>');
	}
	
		
	$t->set_var("keywords", $row[keywords]);
	$t->set_var("description", $row[description]);
	
	$t->set_var("idioma", $idioma);
	
	$t->set_var("breadcrum", ' >> '.$row1[nombre]);
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function mostrar_detalle_noticias(){
	global $tof_noticias,$tof_noticiasxidioma,$tof_imagenesxnoticias,$tof_modulos,$tof_modulosxidioma,$noticia,$idioma;
	$name_tpl="detalle_noticias.htm";
	$t = new Template("modulos/noticias/templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);

	$result=mysql_query("select DATE_FORMAT(n.fecha_publicacion,'%d/%m/%Y') as fecha_publicacion,ni.* from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$idioma."' and ni.id=".$noticia);
	$row=mysql_fetch_array($result);
	
	$resultm=mysql_query("select m.path,mi.nombre from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."'and path='noticias'");
	$row1=mysql_fetch_array($resultm);

	if (isset($row[title]) and ($row[title]!="")){ 
		$t->set_var("title",$row[title]);
		}
	else{
		$t->set_var("title",$row[titulo]);
		}

	$t->set_var("titulo", $row[titulo]);
	$t->set_var("headline", $row[headline]);
	$t->set_var("noticia", $row[noticia]);
	$t->set_var("fecha", $row[fecha_publicacion]);
	
	$t->set_var("keywords", $row[keywords]);
	$t->set_var("description", $row[description]);
	
	$t->set_var("idioma", $row[idioma]);
	
	$t->set_var("breadcrum", ' >> <a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'.htm" title="'.$row1[nombre].'" title="'.$row1[nombre].'">'.$row1[nombre].'</a> >> '.$row[titulo]);
	
	$result=mysql_query("select id,path,nombre,principio from ".$tof_imagenesxnoticias." where id_noticia=".$noticia." and publicado=1");
	if(mysql_num_rows($result)){
		$t->set_block("pl","block_imagenes","_block_imagenes");	
		$t->set_block("pl","block_imagenes_principio","_block_imagenes_principio");	
		while($row=mysql_fetch_array($result)){
			if($row[principio]==0){
				$t->set_var("imagen", '<p style="width:260px;float:left"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="250" /></p>');
				$t->parse("_block_imagenes","block_imagenes",true);
			}else{
				$t->set_var("imagen_principio", '<p style="width:260px;float:left"><img src="'.$row[path].'" alt="'.$row[nombre].'" width="250" /></p>');
				$t->parse("_block_imagenes_principio","block_imagenes_principio",true);			
			}
		}	
	}


	
	
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

?>
