<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");


function listar_comentariosxsecciones(){
	global $tof_comentariosxsecciones,$tof_comentariosxseccionesxidioma,$tof_seccionesxidioma,$tof_secciones,$id_padre,$row_per_page,$page;;
	$name_tpl="listar_comentariosxsecciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar comentariosxsecciones");
	$t->set_var("categoria_modulo", "comentariosxsecciones");

	$t->set_var("action", "listar_comentariosxsecciones");
	
	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	if(isset($id_padre) and ($id_padre<>0)){
		$result=mysql_query("select si.*,s.publicado,s.id_seccion,sec.nombre as nombreseccion from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id) left join ".$tof_seccionesxidioma." sec on (sec.id=s.id_seccion and sec.idioma='es') where s.id_seccion=".$id_padre." group by s.id order by fecha_publicacion limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id) where s.id_seccion=".$id_padre);
		}
	else{
		$result=mysql_query("select si.*,s.publicado,s.id_seccion,sec.nombre as nombreseccion  from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id)  left join ".$tof_seccionesxidioma." sec on (sec.id=s.id_seccion) group by s.id order by fecha_publicacion limit ".$inicio.",".$row_per_page);
		$resultcant=mysql_query("select count(*) as cant from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id) ");
		}
		
	$t->set_block("pl","block_comentariosxsecciones","_block_comentariosxsecciones");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre",$row[nombre]);
	  $t->set_var("nombre_padre",$row[nombreseccion]);
      $t->set_var("publicado",$row[publicado]);
      $t->set_var("id_comentarioxseccion",$row[id]);
      $t->parse("_block_comentariosxsecciones","block_comentariosxsecciones",true);
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
	
	$result=mysql_query("select * from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id)");
	$t->set_block("pl","block_padre","_block_padre");	
    while($row=mysql_fetch_array($result))
    {
		$t->set_var("id_padre",$row[id]);
		$t->set_var("nombre_padre",$row[nombre]);
		if($row[id]==$id_padre)
			$t->set_var("selected_padre","selected");
		else
			$t->set_var("selected_padre","");
		$t->parse("_block_padre","block_padre",true);
	}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_comentariosxsecciones(){
	global $tof_comentariosxsecciones,$tof_comentariosxseccionesxidioma,$tof_secciones,$tof_seccionesxidioma,$tof_idioma;
	$name_tpl="insertar_comentariosxsecciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Comentario x Secci�n");
	$t->set_var("categoria_modulo", "comentariosxsecciones");
	
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
	$result1=mysql_query("select si.*,s.id_padre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where si.idioma='es' and publicado=1 and s.id_padre=0");
		 while($row1=mysql_fetch_array($result1)){
			$t->set_var("id", $row1[id]);
			$t->set_var("nombre_padre", $row1[nombre]);
			$t->parse("_block_padre","block_padre",true);
		}
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_comentariosxsecciones_ok(){
	global $tof_comentariosxsecciones, $tof_comentariosxseccionesxidioma,$tof_idioma,$idioma;
	global $publicado,$fecha_publicacion,$fecha_publicacion,$nombre_seccion,$nombre_subseccion,$nombre_subsubseccion,$menu_lateral;
	
	if (isset($nombre_subsubseccion)and($nombre_subsubseccion!=0))
		$nombre_seccion=$nombre_subseccion;
	elseif (isset($nombre_subseccion)and($nombre_subseccion!=0))
		$nombre_seccion=$nombre_subseccion;
	
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
			
	mysql_query("insert into ".$tof_comentariosxsecciones." values('NULL','".$fecha_publicacion."',".$publicado.",".$nombre_seccion.")");
	$last_id = mysql_insert_id();
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$nombre ="nombre_".$row[idioma];
		$email ="email_".$row[idioma];
		$comentario ="comentario_".$row[idioma];
		
		global $$nombre,$$email,$$comentario;
	 	
		if (($$nombre!='') and ($$comentario!=''))
		 	mysql_query("insert into ".$tof_comentariosxseccionesxidioma." values(".$last_id.",'".$row[idioma]."','".$$nombre."','".$$email."','".$$comentario."')");
		}	
		
	listar_comentariosxsecciones();
}

function editar_comentariosxsecciones(){
	global $tof_comentariosxsecciones, $tof_comentariosxseccionesxidioma,$tof_secciones, $tof_seccionesxidioma,$tof_idioma,$id_comentarioxseccion;
	$name_tpl="editar_comentariosxsecciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar comentariosxsecciones");
	$t->set_var("categoria_modulo", "comentariosxsecciones");
	
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
	
		$result1=mysql_query("select si.*,s.publicado,s.fecha_publicacion,s.id_seccion from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id) where s.id=".$id_comentarioxseccion." and si.idioma='".$row[idioma]."'");

		if (isset($result1) and mysql_num_rows($result1)){
			while($row1=mysql_fetch_array($result1)){
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("nombre", $row1[nombre]);
				$t->set_var("comentario", $row1[comentario]);
				$t->set_var("email", $row1[email]);
				$t->set_var("fecha_publicacion", $row1[fecha_publicacion]);
				$id_padre=$row1[id_seccion];
				
				if($row1[publicado]==1)
					$publicado='checked';
				else
					$publicado='';
				$t->set_var("publicado", $publicado);			
				$t->parse("_block_idiomas1","block_idiomas1",true);
				
			}
		}else{
			$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("fecha_publicacion","");
				$t->set_var("nombre","");
				$t->set_var("comentario", "");
				$t->set_var("email", "");		
				$t->parse("_block_idiomas1","block_idiomas1",true);
		}
	}
	

	$result1=mysql_query("select id,publicado,menu_lateral,orden,id_padre from ".$tof_secciones." where id=".$id_padre);
	$row1=mysql_fetch_array($result1);
	
	$result4=mysql_query("select id,publicado,orden,menu_lateral,id_padre from ".$tof_secciones." where id=".$row1[id_padre]);
	if (($result4!='') and mysql_num_rows($result4)){
		$row4=mysql_fetch_array($result4);
		$id_subpadre=$row4[id];
	}
	
	$result5=mysql_query("select id,publicado,orden,menu_lateral,id_padre from ".$tof_secciones." where id=".$row4[id_padre]);
	if (($result5!='') and mysql_num_rows($result5)){
		$row5=mysql_fetch_array($result5);
		$id_subsubpadre=$row5[id];
	}
	
	if (isset($id_subsubpadre) and ($id_subsubpadre!='')){
		$id_p=$id_subsubpadre;
		$id_sp=$id_subpadre;
		$id_ssp=$id_padre;
	}elseif (isset($id_subpadre) and ($id_subpadre!='')){
		$id_p=$id_subpadre;
		$id_sp=$id_padre;
	}else{
		$id_p=$id_padre;
	}
		
			
	$t->set_block("pl","block_padre","_block_padre");	
	$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where id_padre=0 and si.idioma='es' and publicado=1");

	 while($row2=mysql_fetch_array($result2)){
			$t->set_var("id_padre", $row2[id]);
			$t->set_var("nombre_padre", $row2[nombre]);
			if ($row2[id]==$id_p){
				$t->set_var("selected", "selected");
			}else{
				$t->set_var("selected", "");
				}
			$t->parse("_block_padre","block_padre",true);
	}

	if (isset($id_sp) and ($id_sp!='')){
		$t->set_block("pl","block_spadre","_block_spadre");	
		$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id_padre=".$id_p." and si.idioma='es' and publicado=1");
			 while($row2=mysql_fetch_array($result2)){
				$t->set_var("id_sub_padre", $row2[id]);
				$t->set_var("nombre_sub_padre", $row2[nombre]);
				if ($row2[id]==$id_sp){
					$t->set_var("selected_sub", "selected");
				}else{
					$t->set_var("selected_sub", "");
					}
				$t->parse("_block_spadre","block_spadre",true);
			}
	}
	
	if (isset($id_ssp) and ($id_ssp!='')){
		$row5=mysql_fetch_array($result5);
		$t->set_block("pl","block_sspadre","_block_sspadre");	
		$result2=mysql_query("select si.*,s.id from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where id_padre=".$id_sp." and si.idioma='es' and publicado=1 and s.id<>".$id_p);
	
			 while($row2=mysql_fetch_array($result2)){
				$t->set_var("id_sub_sub_padre", $row2[id]);
				$t->set_var("nombre_sub_sub_padre", $row2[nombre]);
				if ($row2[id]==$id_ssp){
					$id_padre=$row2[id_padre];
					$t->set_var("selected_subsub", "selected");
					}else{
					$t->set_var("selected_subsub", "");
					}
				$t->parse("_block_sspadre","block_sspadre",true);
			}
		}
	
	$t->set_var("id_comentarioxseccion", $id_comentarioxseccion);
						
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_comentariosxsecciones_ok(){
	global $tof_comentariosxsecciones, $tof_comentariosxseccionesxidioma,$tof_idioma,$id_comentarioxseccion,$publicado,$nombre_padre,$nombre_subpadre,$nombre_subsubpadre,$fecha_publicacion;
	
	if (isset($nombre_subsubpadre)and($nombre_subsubpadre!=0))
		$nombre_padre=$nombre_subsubpadre;
	elseif (isset($nombre_subpadre)and($nombre_subpadre!=0))
		$nombre_padre=$nombre_subpadre;
		
	if (isset($publicado))
		$publicado=1;
	else
		$publicado=0;
		
	mysql_query("update ".$tof_comentariosxsecciones." set publicado=".$publicado.",fecha_publicacion='".$fecha_publicacion."',id_seccion=".$nombre_padre." where id=".$id_comentarioxseccion);
		
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$nombre ="nombre_".$row[idioma];
		$comentario ="comentario_".$row[idioma];
		$email ="email_".$row[idioma];
		
		global $$nombre,$$comentario,$$email;
	 	
		if (($$nombre!='') and ($$comentario!=''))
		 	mysql_query("replace ".$tof_comentariosxseccionesxidioma." set id=".$id_comentarioxseccion.",idioma='".$row[idioma]."',comentario='".$$comentario."', nombre='".$$nombre."', email='".$$email."'");

		}	
		
	listar_comentariosxsecciones();
}

function eliminar_comentariosxsecciones(){
	global $tof_comentariosxsecciones, $tof_comentariosxseccionesxidioma, $tof_secciones,$tof_seccionesxidioma,$id_comentarioxseccion;
	$name_tpl="eliminar_comentariosxsecciones.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
	setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Comentario x Secci�n");
	$t->set_var("categoria_modulo", "comentariosxsecciones");

	$result=mysql_query("select si.*,s.publicado,s.fecha_publicacion,s.id_seccion from ".$tof_comentariosxsecciones." s join ".$tof_comentariosxseccionesxidioma." si on (s.id=si.id) where s.id=".$id_comentarioxseccion);
	$row=mysql_fetch_array($result);
	
	$result1=mysql_query("select si.nombre from ".$tof_secciones." s join ".$tof_seccionesxidioma." si on (s.id=si.id) where s.id=".$row[id_seccion]." and idioma='".$row[idioma]."'");
	$row1=mysql_fetch_array($result1);
	
    if($row[publicado]==1)
		$publicado="Si";
	else
		$publicado="No";
		
	$t->set_var("nombre",$row[nombre]);
	$t->set_var("email",$row[email]);
	$t->set_var("comentario",$row[comentario]);
	$t->set_var("fecha_publicacion",$row[fecha_publicacion]);
	$t->set_var("publicado_comentario",$publicado);
	$t->set_var("nombre_seccion",$row1[nombre]);
	$t->set_var("id_comentarioxseccion",$row[id]);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_comentariosxsecciones_ok(){
	global $tof_comentariosxsecciones,$tof_comentariosxseccionesxidioma,$id_comentarioxseccion;

	mysql_query("delete from ".$tof_comentariosxsecciones." where id=".$id_comentarioxseccion);
	mysql_query("delete from ".$tof_comentariosxseccionesxidioma." where id=".$id_comentarioxseccion);

	listar_comentariosxsecciones();
}


?>

