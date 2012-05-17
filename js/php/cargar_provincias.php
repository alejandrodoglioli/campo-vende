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


//$resultadof=mysql_fetch_array($resultado);
  // echo "resul: ".$resultadof[nombre];exit;
}
function cargarProvincias(){
	conectarBD();
$consulta = "select * from provincias";
$resultado = mysql_query($consulta);
	if(!$resultado)
	{
  		echo 'No hubo resultados: ' . mysql_error();
  		return false;
	    exit;
	}
	else{
		
		$provincias = array();
		while($row = mysql_fetch_assoc($resultado)){
			
			$id = $row["id"];
			$nombre = $row["nombre"];
			$provincias[$id]=$nombre;
		
		}
  	return $provincias;		
  	
	}
}
    //echo "pepe";exit;
    $provincias = cargarProvincias();
	foreach($provincias as $key=>$value)
{
		echo "<option value=\"$key\">$value</option>";
}
 
  	
?>