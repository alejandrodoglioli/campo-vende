<?php

include("../../../include/class.Template.php");
include("../../../include/config.php");
include("../../../include/conexion.php");

function listar_newsletters(){
	global $tof_newsletters,$tof_newslettersxidioma,$row_per_page,$page;
	$name_tpl="listar_newsletters.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Listar newsletters");
	$t->set_var("categoria_modulo", "newsletters");
	
	$t->set_var("action", "listar_newsletter");

	if(isset($page)){
		$inicio = ($row_per_page*($page-1));
	}else{
		$page=1;
		$inicio = 0;
	}
	
	$result=mysql_query("select f.* from ".$tof_newsletters." f join ".$tof_newslettersxidioma." a on (f.id=a.id) order by nombre limit ".$inicio.",".$row_per_page);
	
	$t->set_block("pl","block_newsletters","_block_newsletters");	
    while($row=mysql_fetch_array($result))
    {
      $t->set_var("nombre_newsletter",$row[nombre]);
      $t->set_var("enviado_newsletter",$row[enviado]);
      $t->set_var("id_newsletter",$row[id]);
      $t->parse("_block_newsletters","block_newsletters",true);
    }

	
	$resultcant=mysql_query("select count(*) as cant from ".$tof_newsletters." f join ".$tof_newslettersxidioma." a on (f.id=a.id)");
	
		
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
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");

}


function insertar_newsletters(){
	global $tof_newsletters,$tof_idioma;
	$name_tpl="insertar_newsletters.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Insertar Newsleter");
	$t->set_var("categoria_modulo", "newsletters");
	
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
		$t->parse("_block_idiomas1","block_idiomas1",true);
	}
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas2","_block_idiomas2");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("lenguaje2", $row[idioma]);
		$t->parse("_block_idiomas2","block_idiomas2",true);
	}
	
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function insertar_newsletters_ok(){
	global $tof_newsletters, $tof_newslettersxidioma,$tof_idioma,$fecha;
	
	global $enviado,$nombre;
	if (isset($enviado))
		$enviado=1;
	else
		$enviado=0;
	
	mysql_query("insert into ".$tof_newsletters." values('NULL', '".$nombre."','".$fecha."','".$enviado."')");
	$last_id = mysql_insert_id();
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$contenido ="contenido_".$row[idioma];
		
		global $$titulo,$$contenido;
	 
	 	mysql_query("insert into ".$tof_newslettersxidioma." values(".$last_id.",'".$$titulo."','".$$contenido."','".$row[idioma]."')");
		

		}	
		
	listar_newsletters();
}

function editar_newsletters(){
	global $tof_newsletters, $tof_newslettersxidioma,$tof_idioma,$id_newsletter;
	$name_tpl="editar_newsletters.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Editar newsletters");
	$t->set_var("categoria_modulo", "newsletters");
	
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
	
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	$t->set_block("pl","block_idiomas1","_block_idiomas1");	
	while($row=mysql_fetch_array($result)){
	
		$result1=mysql_query("select * from ".$tof_newsletters." n join ".$tof_newslettersxidioma." ni on (n.id=ni.id) where n.id=".$id_newsletter." and ni.idioma='".$row[idioma]."'");
		if (mysql_num_rows($result1)){
			while($row1=mysql_fetch_array($result1)){
				$t->set_var("lenguaje1", $row[idioma]);
				$t->set_var("titulo", $row1[subject]);
				$t->set_var("contenido", $row1[texto]);
				$t->parse("_block_idiomas1","block_idiomas1",true);
			}
		}else{
				$t->set_var("titulo", "");
				$t->set_var("contenido", "");
				$t->parse("_block_idiomas1","block_idiomas1",true);
		}
	}
	
	$result1=mysql_query("select * from ".$tof_newsletters." where id=".$id_newsletter);
	$row1=mysql_fetch_array($result1);
	if($row1[enviado]==1)
		$enviado='checked';
	else
		$enviado='';
		
	$t->set_var("nombre", $row1[nombre]);
	$t->set_var("enviado", $enviado);
	$t->set_var("fecha", $row1[fecha]);
	$t->set_var("id_newsletter", $id_newsletter);
			
	$row=mysql_fetch_array($result);
    if($row[is_admin]==1)
		$es_administrador="checked";
	
	$t->set_var("nombre_usuario",$row[nickname]);
	$t->set_var("es_administrador_usuario",$es_administrador);
	$t->set_var("password_usuario",$row[password]);
	$t->set_var("id_usuario",$row[ID]);
    
	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function editar_newsletters_ok(){
	global $tof_newsletters, $tof_newslettersxidioma,$tof_idioma,$id_newsletter,$enviado,$fecha;
	
	if (isset($enviado))
		$enviado=1;
	else
		$enviado=0;
	
	if (isset($fecha))
		mysql_query("update ".$tof_newsletters." set enviado=".$enviado.", fecha='".$fecha."' where id=".$id_newsletter);
	else
		mysql_query("update ".$tof_newsletters." set enviado=".$enviado." where id=".$id_newsletter);
		
	$result=mysql_query("select idioma, nombre from ".$tof_idioma." where publicado=1");
	while($row=mysql_fetch_array($result)){
		$titulo ="titulo_".$row[idioma];
		$contenido ="contenido_".$row[idioma];
			
		global $$titulo,$$contenido,$$title,$$description,$$keywords;
	 
	 	mysql_query("update ".$tof_newslettersxidioma." set texto='".$$contenido."', subject='".$$titulo."' where id=".$id_newsletter." and idioma='".$row[idioma]."'");

		}	
		
	listar_newsletters();
}

function eliminar_newsletters(){
	global $tof_newsletters, $tof_newslettersxidioma, $id_newsletter;
	$name_tpl="eliminar_newsletters.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Eliminar Sección");
	$t->set_var("categoria_modulo", "newsletters");

	$result=mysql_query("select * from ".$tof_newsletters." n join ".$tof_newslettersxidioma." ni on (n.id=ni.id) where n.id=".$id_newsletter);
	
	$row=mysql_fetch_array($result);
    if($row[enviado]==1)
		$enviado="Si";
	else
		$enviado="No";
		
	$t->set_var("nombre_newsletter",$row[nombre]);
	$t->set_var("fecha_publicacion_newsletter",$row[fecha]);
	$t->set_var("enviado_newsletter",$enviado);
	$t->set_var("id_newsletter",$id_newsletter);
    	
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}

function eliminar_newsletters_ok(){
	global $tof_newsletters,$tof_newslettersxidioma,$id_newsletter;

	mysql_query("delete from ".$tof_newsletters." where id=".$id_newsletter);
	mysql_query("delete from ".$tof_newslettersxidioma." where id=".$id_newsletter);
		
	listar_newsletters();
}

function enviar_newsletters(){
	
	global $tof_newsletters, $tof_newslettersxidioma, $tof_grupos_contactos,$id_newsletter;
	$name_tpl="enviar_newsletters.htm";
	$t = new Template("./templates", "remove");
	$t->set_file("pl", $name_tpl);
	
	setear_menu(&$t);
setearVariablesComunes(&$t);
	
	$t->set_var("title", "Enviar Newsletters");
	$t->set_var("categoria_modulo", "Enviar Newsletters");

	$result=mysql_query("select * from ".$tof_newsletters." n join ".$tof_newslettersxidioma." ni on (n.id=ni.id) where n.id=".$id_newsletter);
	$row=mysql_fetch_array($result);
		
	$t->set_var("newsletter",$row[texto]);
	$t->set_var("id_newsletter",$id_newsletter);

	$result=mysql_query("select id,nombre_grupo from ".$tof_grupos_contactos);
	$t->set_block("pl","block_grupo_contacto","_block_grupo_contacto");	
    while($row=mysql_fetch_array($result)){
		$t->set_var("nombre_grupo_contacto", $row[nombre_grupo]);
		$t->set_var("id_grupo_contacto", $row[id]);
		$t->parse("_block_grupo_contacto","block_grupo_contacto",true);
	}
		
	$t->parse("MAIN", "pl");
    $t->p("MAIN");
}
		
function enviar_newsletters_ok(){
	global $tof_idioma,$tof_newsletters,$tof_newslettersxidioma,$tof_contactos,$tof_configuracion,$tof_grupos_contactos,$id_newsletter,$id_grupo_contacto;
	include_once("./../../../include/mail.php");
		
		$name_tpl="enviar_newsletters_gracias.htm";
		$t = new Template("./templates", "remove");
		$t->set_file("pl", $name_tpl);
	
		$t->set_var("title", "Newsletters Enviado");
		$t->set_var("categoria_modulo", "Newsletters Enviado");

		setear_menu(&$t);
		setearVariablesComunes(&$t);

		$cont-0;
		
		$result3=mysql_query("select * from ".$tof_configuracion." where id=0");
		$row3=mysql_fetch_array($result3);
		$From=$row3[mail_empresa];
		$FromName=	$row3[nombre_empresa];
		
		$result=mysql_query("select * from ".$tof_idioma);
	
		while($row=mysql_fetch_array($result)){

			$result1=mysql_query("select * from ".$tof_newsletters." n join ".$tof_newslettersxidioma." ni on (n.id=ni.id) where n.id=".$id_newsletter." and ni.idioma='".$row[idioma]."'");
			$row1=mysql_fetch_array($result1);

			
			$subject=$row3[nombre_empresa]." -".$row1[subject];
			$body=  $row1[texto];
			
			if(isset($id_grupo_contacto) and ($id_grupo_contacto!=0))
				$result2=mysql_query("select c.email from ".$tof_contactos." c join ".$tof_grupos_contactos." gc on(c.id_grupo_contacto=gc.id) where gc.id=".$id_grupo_contacto." and c.idioma='".$row[idioma]."'");
			else 						
				$result2=mysql_query("select email from ".$tof_contactos." where idioma='".$row[idioma]."'");
			if(mysql_num_rows($result2)){
				$t->set_block("pl","block_contactos","_block_contactos");	
				while($row2=mysql_fetch_array($result2)){
					$To=$row2[email];
					$resultado=enviar_email($From,$FromName,$To,$body,$subject,$row2[email]);
					if($resultado){
						$cont++;
						$t->set_var("contacto", $row2[email]);
						$t->parse("_block_contactos","block_contactos",true);
						}
					}
				}						
			} 
			
			$t->set_var("cant_contactos", $cont);

			mysql_query("update ".$tof_newsletters." set enviado=1 where id=".$id_newsletter);
			
			$t->parse("MAIN", "pl");
		    $t->p("MAIN");

		}

?>

