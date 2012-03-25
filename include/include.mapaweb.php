<?PHP
function mostrar_mapaweb_seccion($id_seccion){
	
	global $tof_secciones,$tof_seccionesxidioma,$tof_index,$tof_modulos,$tof_modulosxidioma,$tof_noticiasxidioma,$tof_noticias,$idioma;
	
	$name_tpl="mapaweb.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->set_var("idioma", $idioma);

	
	$result=mysql_query("select si.nombre,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id=".$id_seccion." and id_padre=0 order by s.orden");
	$row=mysql_fetch_array($result);
	$t->set_var("seccion", $row[nombre]);
	$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
	
	$enlace = '<a href="/'.$idioma.'/mapaweb.htm">Mapaweb</a>';
	$t->set_var("breadcrumb", ' >> '.$enlace.' >> Mapa Web '. $row[nombre]);
	
	$result1=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row[id]." order by s.orden");
	if (mysql_num_rows($result1)){
			$subsecciones="";
			$submenu='';
			while($row1=mysql_fetch_array($result1)){
				$submenu.='<li class="subsecciones"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row[id].'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a></li>';
				
				$result2=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row1[id]." order by s.orden");
		
				if (mysql_num_rows($result2)){
					$subsubsecciones="";
					$subsubmenu='';
					while($row2=mysql_fetch_array($result2)){
						$submenu.='<li class="subsubsecciones"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row[id].'-'.$row1[id].'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a></li>';
						}
						$t->set_var("subsubsecciones", $subsubmenu);
				}else{
					$t->set_var("subsecciones", "");	
				}
			}
			$t->set_var("subsecciones", $submenu);
		}else{
			$t->set_var("subsecciones", "");
		}
		
		$t->set_var("title", "Mapaweb ".$row[nombre]);
		$t->set_var("titulo", "Mapaweb ".$row[nombre]);
		$t->set_var("keywords", "Mapaweb ".$row[nombre]);
		
		$t->parse("MAIN", "pl");
	    $t->p("MAIN");
}

function mostrar_mapaweb(){
	global $tof_secciones,$tof_seccionesxidioma,$tof_index,$tof_modulos,$tof_modulosxidioma,$tof_noticiasxidioma,$tof_noticias,$idioma;
	
	$name_tpl="mapaweb.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);
	
	$t->set_var("idioma", $idioma);
	$t->set_var("title", "Mapaweb");
	$t->set_var("titulo", "Mapaweb");
	$t->set_var("keywords", "Mapaweb");
	
	$t->set_var("breadcrumb", ' >> Mapa Web');
	
	$result=mysql_query("select si.nombre,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and id_padre=0 order by s.orden");
	
	$t->set_block("pl","secciones_mapaweb","_secciones_mapaweb");	
	while($row=mysql_fetch_array($result)){
		$t->set_var("seccion", $row[nombre]);
		if ($row[nombre]!="Home"){
			$result1=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row[id]." order by s.orden");
			if (mysql_num_rows($result1)){
				$t->set_var("path", "/".$idioma."/mapaweb-".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
			}else{
				$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
				}
			}
		else
			$t->set_var("path", "/".$idioma."/");
		
		/*$result1=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row[id]." order by s.orden");
		
		if (mysql_num_rows($result1)){
			$subsecciones="";
			$submenu='';
			while($row1=mysql_fetch_array($result1)){
				$submenu.='<li class="subsecciones"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'.htm" title="'.$row1[nombre].'">'.$row1[nombre].'</a></li>';
				
				$result2=mysql_query("select si.nombre,s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id_padre=".$row1[id]." order by s.orden");
		
				if (mysql_num_rows($result2)){
					$subsubsecciones="";
					$subsubmenu='';
					while($row2=mysql_fetch_array($result2)){
						$submenu.='<li class="subsubsecciones"><a href="/'.$idioma.'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).'-'.$row[id].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre]))).'-'.$row1[id].'/'.strtolower(sacar_acentos(str_replace(" ","-" ,$row2[nombre]))).'-'.$row2[id].'.htm" title="'.$row2[nombre].'">'.$row2[nombre].'</a></li>';
						}
						$t->set_var("subsubsecciones", $subsubmenu);
				}else{
					$t->set_var("subsecciones", "");	
				}
			}
			$t->set_var("subsecciones", $submenu);
		}else{
			$t->set_var("subsecciones", "");
		}*/
		
		$t->parse("_secciones_mapaweb","secciones_mapaweb",true);
		
	}

	$result=mysql_query("select mi.nombre,m.id,m.path from ".$tof_modulos." m join ".$tof_modulosxidioma." mi on (m.id=mi.id_modulo) where mi.id_idioma='".$idioma."' and m.publica=1 and m.habilitado=1 and mi.nombre<>'secciones' order by m.orden ");
	while($row=mysql_fetch_array($result)){
		if ($row[path]!='newsletters'){
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("path","/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre]))).".htm");
			$t->set_var("subsecciones", "");		
			if ($row[path]=="noticias"){
					$result1=mysql_query("select ni.titulo,ni.headline,ni.id from ".$tof_noticias." n join ".$tof_noticiasxidioma." ni on (n.id=ni.id) where ni.idioma='".$idioma."'");					
					while($row1=mysql_fetch_array($result1)){
						$subsecciones1.="<li class='subsecciones'><a href='/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row1[titulo])))."-".$row1[id].".htm' title='".$row1[titulo]."'>".$row1[titulo]."</a></li>";
						
						}
				$t->set_var("subsecciones", $subsecciones1);				
			}else{
				$t->set_var("subsecciones", "");
			}
		
			$t->parse("_secciones_mapaweb","secciones_mapaweb",true);
			}else{
					$t->set_var("subsecciones", "");				
				}
	}
	
	$t->set_var("seccion", "Feed");
	$t->set_var("path","feed");
	$t->set_var("subsecciones", "");
	$t->parse("_secciones_mapaweb","secciones_mapaweb",true);
	
	$t->set_var("seccion", "Contacto");
	$t->set_var("path","contacto.htm");
	$t->set_var("subsecciones", "");
	$t->parse("_secciones_mapaweb","secciones_mapaweb",true);
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

?>
