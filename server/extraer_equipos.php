<?php
require 'conexion.php';

// Número de registros recuperados
$numberofrecords = 10;

if(!isset($_POST['searchTerm'])){

   // Obtener registros a tarves de la consulta SQL
   $stmt = $db->prepare("SELECT * FROM identa_productos ORDER BY Descripcion LIMIT :limit");
   $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
   $stmt->execute();
   $lista_productos = $stmt->fetchAll();

}else{

   $search = $_POST['searchTerm'];// Search text

   // Mostrar resultados
   $stmt = $db->prepare("SELECT * FROM identa_productos WHERE Descripcion like :Descripcion ORDER BY Descripcion LIMIT :limit");
   $stmt->bindValue(':Descripcion', '%'.$search.'%', PDO::PARAM_STR);
   $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
   $stmt->execute();
   //Variable en array para ser procesado en el ciclo foreach
   $lista_productos = $stmt->fetchAll();

}

$response = array();

// Leer los datos de MySQL
foreach($lista_productos as $pro){
   $response[] = array(
      "id" => $pro['Cod_articulo'],
      "text" => $pro['Descripcion']
   );
}

echo json_encode($response);
exit();
?>