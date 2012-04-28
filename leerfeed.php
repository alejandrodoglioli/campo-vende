<?php
require("js/simplepie.inc");
include_once("include/config.php");
include_once("include/lib.inc.php");
include_once("include/conexion.php");
include_once("admin/include/include.funciones.php");

global $tof_feeds,$tof_feedsxidioma,$tof_noticias,$cantidad,$path_images_noticias,$tof_imagenesxnoticias;

 function recibe_imagen ($url_origen,$archivo_destino){
        $mi_curl = curl_init($url_origen);
        $fs_archivo = fopen ($path_imagenes_noticias.$archivo_destino, "w");
        curl_setopt ($mi_curl, CURLOPT_FILE, $fs_archivo);
        curl_setopt ($mi_curl, CURLOPT_HEADER, 0);
        curl_exec ($mi_curl);
        curl_close ($mi_curl);
        fclose ($fs_archivo);
}

function get_image_name($url){
	echo $url;
    $endtext = strlen($url);
    echo $endtext;
    $lastSlash = strrpos($url,"/");
    echo $lastSlash;
    
    return substr($url,$lastSlash+1,$endtext);
 }

//variable pasada como parametro en la url
if (!isset($cantidad))
	$cantidad =4;

$result=mysql_query("select si.*,s.publicado from ".$tof_feeds." s join ".$tof_feedsxidioma." si on (s.id=si.id) where publicado=1 order by nombre");

$cont=0;
while($row_feed=mysql_fetch_array($result)){ 
	echo "PEPA: ".$row_feed;
	$array_feed[$cont]=$row_feed;
	$cont++;	
}

$vfeed = new SimplePie();
$diasemana = date("w");

//$vfeed->set_feed_url($array_feed[$diasemana][url]);
$vfeed->set_feed_url($array_feed[0][url]);
$vfeed->init();
$vfeed->handle_content_type();
$vmax = $vfeed->get_item_quantity();
$cant=0;
$path_imagenes_noticias = "/images/noticias/";
for ($x = 0; $x <$vmax && $cant<$cantidad; $x++) {
	$vitem = $vfeed->get_item($x);
    if ($enclosure = $vitem->get_enclosure()){
    	
    	$image_url = $enclosure->get_link();
    	$image_name=get_image_name($image_url);//$vitem->get_id();
    	$path_image = $path_imagenes_noticias.$image_name;
    	$fecha = time();
		$fecha_publicacion= date("Y-m-j",$fecha);
		$publicado = 1;
		$orden = 1;
		$headline = substr($vitem->get_description(),0,100);
		$description=$headline;
	   recibe_imagen($image_url,$path_image);

	$keywords=$vitem->get_title();
	mysql_query ("SET NAMES 'utf8'");
	
	$result=mysql_query("select * from ".$tof_noticiasxidioma." where titulo like '%".$vitem->get_title()."%'");

	$row=mysql_fetch_array($result);
	$cantregistros = mysql_num_rows($result);

	if ($cantregistros<=0){
		mysql_query("insert into ".$tof_noticias." values('NULL','".$fecha_publicacion."',".$publicado.",'".$orden."')");
		echo "insert into ".$tof_noticias." values('NULL','".$fecha_publicacion."',".$publicado.",'".$orden."')";
		$last_id = mysql_insert_id();
		
		$descripcion = $vitem->get_description();
		$descripcion.='<br /><br />Fuente: <a href="'.$vitem->get_link().'" title="'.$vitem->get_link().'" rel="nofollow">'.$vitem->get_link().'</a>';

		mysql_query("insert into ".$tof_noticiasxidioma." values(".$last_id.",'".$vitem->get_title()."','".$headline."','".$descripcion."','NULL','es','".$headline."','".$keywords."','".$title."')");
        if(($path_image==null)||($path_image==""))
           $path_image = "/images/noticias/defaultnoticias.jpg"; 
		mysql_query("insert into ".$tof_imagenesxnoticias." values('NULL','".$image_name."','".$path_image."',1,1,".$last_id.")");
		echo "insert into ".$tof_imagenesxnoticias." values('NULL','".$image_name."','".$path_image."',1,1,".$last_id.")";
		
		$cant++;
	}
    }
}
	
echo "Se agregaron ".$cant." entradas.";
?>
