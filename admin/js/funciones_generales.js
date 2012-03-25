function filtro(id_album,page){
	if(page==""){
		if(id_album=='todos')
			window.location = '/admin/modulos/albums/index.php?action=listar_fotos';
		else
			window.location = '/admin/modulos/albums/index.php?action=listar_fotos&id_album='+id_album;
	}else{
		if(id_album=='todos')
			window.location = '/admin/modulos/albums/index.php?action=listar_fotos&page='+page;
		else
			window.location = '/admin/modulos/albums/index.php?action=listar_fotos&id_album='+id_album+'&page='+page;
	}
	
}

function addFoto(n)
{
	var c = n;	
	c++;
	if(!document.getElementById('imagen_inicio'+c))
	{
		var ni = document.getElementById("my"+n+"Div");
		var divIdName = "my"+c+"Div";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		document.getElementById('cant_imagenes').value = c;

		//HTM
		HTML = '<tr>';
		HTML += '<td colspan="2">';
		HTML += '<input type="hidden" id="id_imagen_'+c+'" name="id_imagen_'+c+'" value="0" />';
		HTML += '<table cellpadding="0" cellspacing="1" border="0" style="border:1px solid #dcdcdc;padding:10px;">';
		HTML += '<tr>';
		HTML += '<td valign="top" width="180">Nombre:</td>';
		HTML += '<td><input name="nombre_imagen_'+c+'" id="nombre_imagen_'+c+'" value=""  type="text" size="50"  /></td>';
		HTML += '</tr>';
		HTML += '<tr>';
		HTML += '<td valign="top">Path:</td>';
		HTML += '<td><input name="path_imagen_'+c+'" id="path_imagen_'+c+'" value=""  type="file" size="69"  /></td>';
		HTML += '</tr>';
		HTML += '<tr>';
		HTML += '<td valign="top">Imagen inicio?</td>';
		HTML += '<td><input name="principio_imagen_'+c+'" id="principio_imagen_'+c+'" value=""  type="checkbox"   /></td>';
		HTML += '</tr>';
		HTML += '<tr>';
		HTML += '<td valign="top">Publicado</td>';
		HTML += '<td><input name="publicado_imagen_'+c+'" id="publicado_imagen_'+c+'" value=""  type="checkbox"   /></td>';
		HTML += '</tr>';
		HTML += '</table>';
		HTML += '</td>';
        HTML += '</tr>';
		//FIN HTM
		newdiv.innerHTML = HTML;		
		ni.appendChild(newdiv);

	}
}


function eliminarFoto(c)
{	var ci = "my"+c+"Div";
	document.getElementById(ci).innerHTML = "";	
	document.getElementById('cant_imagenes').value=c-1;
}