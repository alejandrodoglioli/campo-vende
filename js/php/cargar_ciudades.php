<?php
//include("../../../include/config.php");
//include("../../../include/conexion.php");

function conectarBD(){
	$dbhost="localhost";
	$dblogin="root";
	$dbpass="root";
	$db="biendecampo";
	MYSQL_CONNECT($dbhost,$dblogin,$dbpass) OR DIE ("unable to connect to database");
	@mysql_select_db($db) or die ("unable to select database");

}
function cargarCiudades($code){
	conectarBD();
	$consulta = "select l.id,l.nombre from localidades l join departamentos d on(l.departamento_id = d.id) join provincias p on(d.provincia_id=p.id) where p.id=".$code;
	$resultado = mysql_query($consulta);
	if(!$resultado)
	{
		echo 'No hubo resultados: ' . mysql_error();
		return false;
		exit;
	}
	else{

		$ciudades = array();
		while($row = mysql_fetch_assoc($resultado)){
				
			$id = $row["id"];
			$nombre = $row["nombre"];
			$ciudades[$id]=$nombre;

		}
		return $ciudades;
		 
	}
}

$code = $_GET["code"];
$ciudades = cargarCiudades($code);
foreach($ciudades as $key=>$value)
{
	echo "<option value=\"$key\">$value</option>";
}

 
?>