<?

/*************************** Inicializacion de variables por defecto *****************************/ 

if (!isset($lang) &&!isset($idioma)){
	$idioma = $default_idioma;
	session_register("idioma");	
}
elseif (isset($lang)){
	$idioma = $lang;
}


/***************************** SECCION DE LOGIN *************************************************/


// si no se ha identificado presenta la pantalla de login
if (!isset($_SESSION['user'])&&($action!="login")) 
{
	include("include.login.php");
	presentar_aut();
	exit;
} 
elseif (($action=="login"))
{
		include("include.login.php");

	    if (comprobar_aut($_REQUEST['login'],$_REQUEST['password'])==1)
		{
			$urlLang =  $_SERVER['HTTP_REFERER'];
			header('Location:'.$urlLang);
			
		}
		else
		{
			?>
			<script language="JavaScript" type="text/javascript">
               window.location="index.php";
			</script>
			<?	
		}	
}
elseif ($action == "logout") // si hace un logout termina la sesion del usuario
{   

	
	$sql="UPDATE mu_usuarios set fecha_login='' where id='".$user."' ";
	$db->query($sql, __FILE__, __LINE__);
	unset($_SESSION['user']);
	unset($_SESSION['pass']);
	unset($_SESSION['id_categoria_usuario']);
	?>
	<script language="JavaScript" type="text/javascript">
       window.location="/atraczion/admin/index.php";
	</script>
	<?	
}
else{
		$modulo = $_SERVER[SCRIPT_URL];
		if (!poseePermisoSeccion($modulo,$id_categoria_usuario)) {
			?>
			<script language="JavaScript" type="text/javascript">
               alert('Usuario sin permiso para esta sección');
				window.location="./admin/index.php";
			</script>
			<?	
		}
			
		
}





function poseePermisoModulo($modulo)
{
	global $db;
	$id = $_SESSION['user'];

	$qry  = "SELECT pm.id_modulo ";
	$qry .= "FROM mu_usuarios us ";
	$qry .= "INNER JOIN permisosxmodulo pm ON (pm.id_categoria = us.id_categoria) ";
	$qry .= "INNER JOIN modulos m ON (pm.id_modulo = m.id) ";
	$qry .= "WHERE us.id = " . $id . " AND path = '" . $modulo . "'";
	
	
	$data = $db->query_array($qry, __FILE__, __LINE__);

	if (!empty($data))
		return true;
	else
		return false;
}

function poseePermisoSeccion($modulo,$id_categoria)
{
	global $db;
	

	$modulo=str_replace('/atraczion/admin/','',$modulo);

	if($modulo=='index.php' || $modulo==''){
		return (true);
	}
	else {
		$modulo=str_replace('modulos/','',$modulo);
		$pos=strrpos ( $modulo, '/');
		$resto = substr ($modulo, 0, $pos); 

		
		$sql="select m.* from moduloxusuario m ";
		$sql.="join modulos mo on (mo.id_modulo=m.id_modulo) ";
		$sql.="where m.id_categoria=".$id_categoria." and mo.path='".$resto."'";

		$data = $db->query_array($sql, __FILE__, __LINE__);

		if (!empty($data))
			return true;
		else
			return false;
	}
	
}
?>