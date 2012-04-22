<?

include_once("include/class.Template.php");

include_once("include/include.funciones.php");
include_once("include/config.php");
include_once("include/lib.inc.php");
include_once("include/conexion.php");

/*************************** Inicializacion de variables por defecto *****************************/ 

if (!isset($lang) &&!isset($idioma)){
	
	$idioma = $default_idioma;
	session_register("idioma");	
}
elseif (isset($lang)){
	$idioma = $lang;
}


/***************************** SECCION DE LOGIN ************** ***********************************/

// si no se ha identificado presenta la pantalla de login
if (!isset($_SESSION['user_sistema'])&&(!$_REQUEST['email_usuario'])&&($action=="login")){
	include("modulos/usuarios_sistema/index.php");
	
	presentar_aut();
	exit;
} 
elseif (isset($_REQUEST['email_usuario']) && ($action=="login"))
{

	include("modulos/usuarios_sistema/index.php");

	    if (comprobar_aut($_REQUEST['email_usuario'],$_REQUEST['password_usuario'])==1)
		{
			//$urlLang =  "/index.php?action=mostrar_usuario_sistema&idioma=es";

			$urlLang =  $_SERVER['HTTP_REFERER'];
			header('Location:'.$urlLang);

			?>
			<script language="JavaScript" type="text/javascript">
               window.location=$urlLang;
			</script>
			<?	
			
		}
		else
		{
			?>
			<script language="JavaScript" type="text/javascript">
               window.location="/es/login.htm";
			</script>
			<?	
		}	
}
elseif ($action == "logout_productoxusuario") // si hace un logout termina la sesion del usuario
{   

	
	//$sql="UPDATE ".$tof_usuarios_sistema." set fecha_login=".date ( "Y-n-j" )." where id='".$user."' ";
	//$db->query($sql, __FILE__, __LINE__);
	unset($_SESSION['user_sistema']);
	unset($_SESSION['pass_sistema']);
	unset($_SESSION['email_sistema']);
	unset($_SESSION['nombre_user_sistema']);
	unset($_SESSION['id_categoria_usuario']);
	?>
	<script language="JavaScript" type="text/javascript">
       window.location="/es/login.htm";
	</script>
	<?	
}
else{
		$modulo = $_SERVER[SCRIPT_URL];
		if (!poseePermisoSeccion($modulo,$id_categoria_usuario)) {
			?>
			<script language="JavaScript" type="text/javascript">
               alert('Usuario sin permiso para esta secci�n');
				window.location="./admin/index.php";
			</script>
			<?	
		}
			
		
}

?>