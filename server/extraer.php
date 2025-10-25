<?php
require 'conexion.php';

// Número de registros recuperados
$numberofrecords = 5;

if(!isset($_POST['searchTerm'])){

   // Obtener registros a tarves de la consulta SQL
   $stmt = $db->prepare("SELECT * FROM identa_clientes ORDER BY RAZON_SOCIAL LIMIT :limit");
   $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
   $stmt->execute();
   $lista_productos = $stmt->fetchAll();

}else{

   $search = $_POST['searchTerm'];// Search text

   // Mostrar resultados
   $stmt = $db->prepare("SELECT * FROM identa_clientes WHERE RAZON_SOCIAL like :RAZON_SOCIAL ORDER BY RAZON_SOCIAL LIMIT :limit");
   $stmt->bindValue(':RAZON_SOCIAL', '%'.$search.'%', PDO::PARAM_STR);
   $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
   $stmt->execute();
   //Variable en array para ser procesado en el ciclo foreach
   $lista_productos = $stmt->fetchAll();

}

$response = array();

// Leer los datos de MySQL
foreach($lista_productos as $pro){
   $response[] = array(
      "id" => $pro['CODIGO_EMP'],
      "text" => $pro['RAZON_SOCIAL']
   );
}

echo json_encode($response);
exit();
?>