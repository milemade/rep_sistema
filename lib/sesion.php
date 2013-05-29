<?
//error_reporting("E_ERROR");
//header( "Cache-Control: no-cache,must-revalidate");
//header( "Expires: Tue, Jan 12 1999 01:01:01 GMT" );
//include("../conf/clave.php");
session_start();
//session_unset();
session_register("global");
//setcookie("global", "", time() + 86400); 
?>
