<?php
function connSecure(){
    $hostname ="localhost";
	$usuariodb = "root";
	$passworddb = "";
    //	$usuariodb = "dsku3611";
	//$passworddb = "R0ad0041";
	$adname = "identatronics_v2";
   //conexion a mysql
    $conectar = new mysqli($hostname,$usuariodb,$passworddb,$adname);
    $conectar->set_charset("utf8");
   return $conectar;

}
?>

