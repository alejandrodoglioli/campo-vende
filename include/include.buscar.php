<?PHP

function mostrar_busqueda($texto){
	global $tof_secciones,$tof_seccionesxidioma,$tof_index,$tof_modulos,$tof_modulosxidioma,$tof_noticiasxidioma,$tof_noticias,$idioma;

	$name_tpl="buscar.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	$t->set_var("idioma", $idioma);
	$t->set_var("title", "Resultado Búsqueda");
	$t->set_var("titulo", "Resultado Búsqueda");
	
	$t->set_var("breadcrumb", ' >> Resultado Búsqueda');
	
	$result=mysql_query("select si.nombre,si.contenido, s.id,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and (si.contenido like '%$texto%' or si.nombre like '%$texto%' or si.description like '%$texto%' or si.keywords like '%$texto%') order by s.orden");
	
	$bandera=false;
	$t->set_block("pl","resultados_busqueda","_resultados_busqueda");	
	if(mysql_num_rows($result))
		while($row=mysql_fetch_array($result)){
			$bandera=true;
			$t->set_var("seccion", $row[nombre]);
			$t->set_var("descripcion", substr(sacar_acentos(strip_tags($row[contenido])),0,150)."......");
			if ($row[id_padre]==0){
				if ($row[nombre]!="Home")
					$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row[id].".htm");
				else
					$t->set_var("path", "/".$idioma."/");
			}else{
				$result1=mysql_query("select si.nombre,si.contenido, s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and s.id=".$row[id_padre]." order by s.orden");
				$row1=mysql_fetch_array($result1);
				$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row1[nombre])))."/".strtolower(sacar_acentos(str_replace(" ","-" ,$row[nombre])))."-".$row1[id]."-".$row[id].".htm");
				
			}
			$t->parse("_resultados_busqueda","resultados_busqueda",true);
		}
		
	$result1=mysql_query("select si.titulo,si.headline, s.id from ".$tof_noticias." s join ".$tof_noticiasxidioma." si on (s.id=si.id) where si.idioma='".$idioma."' and s.publicado=1 and (si.titulo like '%$texto%' or si.headline like '%$texto%' or si.noticia like '%$texto%' or si.keywords like '%$texto%') order by s.orden");	
	if(mysql_num_rows($result1))
		while($row=mysql_fetch_array($result1)){
			$bandera=true;
			$t->set_var("seccion", $row[titulo]);
			$t->set_var("descripcion", substr(strip_tags($row[headline]),0,150)."......");
			$t->set_var("path", "/".$idioma."/".strtolower(sacar_acentos(str_replace(" ","-","noticias/".strtolower(str_replace(" ","-" ,$row[titulo])))))."-".$row[id].".htm");
			$t->parse("_resultados_busqueda","resultados_busqueda",true);
		}	
			
		if(!$bandera){
			$t->set_var("seccion", Error);
			$t->set_var("descripcion", "No se encontró resultado. Vuelva a intentarlo.");
		}
	setearMenu(&$t);
	setearVariablesComunes(&$t);
	setearBanners(&$t,0);	

	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}

?>
