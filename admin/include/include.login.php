<?

include("../include/config.php");
include("../include/lib.inc.php");

function presentar_aut(){
	global $urlSite;
	$t = new Template($path_site."../admin/templates", "keep");
	$t->set_file("pl", "login.htm");
	$t->set_var("urlSite", $urlSite);	
	$t->set_var("title", $login);	
	$t->set_var("raiz", $pathGeneral);
	$t->parse("MAIN", "pl");
	$t->p("MAIN");
}

function comprobar_aut($login,$pass) 
{
	global $login, $password, $tof_users;

	$sql=mysql_query("select * from ".$tof_users." where nickname='".$login."' and password='".$pass."'");
	if(mysql_num_rows($sql)){

		$result=mysql_fetch_array($sql);
		
		if ($result['nickname'] == $login && $result['password'] == $pass){
			$id = $result['ID'];
			$_SESSION['user']=$id;
			$_SESSION['login']=$login;
			$_SESSION['pass']=$pass;
			//$_SESSION['id_categoria_usuario']=$result[0]['id_categoria'];
			return 1;
		}
	}
	return 0;
}


?>