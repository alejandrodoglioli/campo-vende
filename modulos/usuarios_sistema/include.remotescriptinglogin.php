<?php

include("../../include/class.Template.php");
include("../../include/config.php");
include("../../include/conexion.php");
require("../../admin/include/jsrsServer.php.inc");

jsrsDispatch( "recuperarEmail" );

function recuperarEmail($email){

	global $tof_usuarios_sistema;
	
	$result=mysql_query("select u.email, u.password from ".$tof_usuarios_sistema." u where u.email='".$email."'");
	//echo "select * from ".$tof_usuarios_sistema." u where u.email='".$email."'";
	$row=mysql_fetch_array($result);
    $out = array();

    
	if (mysql_num_rows($result)<=0){
		//$t->set_var("error", "NO existe un usuario con ese email, pruebe de nuevo.");
		return 0;
	}else{
		return 1;
	}
	
}
		
?>

