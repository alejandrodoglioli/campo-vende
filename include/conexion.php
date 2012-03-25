<?PHP

MYSQL_CONNECT($dbhost,$dblogin,$dbpass) OR DIE ("unable to connect to database");
@mysql_select_db($db) or die ("unable to select database");

?>