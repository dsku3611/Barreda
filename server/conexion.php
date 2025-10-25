<?php
// Declaramos las credenciales de conexion
$hostname ="localhost";
$usuariodb = "root";
$passworddb = "";
//$usuariodb = "dsku3611";
//$passworddb = "R0ad0041";
$adname = "identatronics_v2";

// Creamos la conexion MySQL
try{
	//Creamos la variable de conexión $b
   $db = new PDO("mysql:host=$hostname;dbname=$adname","$usuariodb","$passworddb");
   $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
   die('Error: No se puede conectar a MySQL');
}
?>