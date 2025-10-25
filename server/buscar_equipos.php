<?php
require('./Inicial.php');
$conexionSecure = connSecure();
if(isset($_POST['buscar'])){
       $Cod_articulo = $_POST['Cod_articulo'];
       //$Factura = 104084;
       $valores = array();
       $valores['existe'] = "0";
      
        if ($resultados = mysqli_fetch_array($conexionSecure->query("SELECT * FROM identa_productos where Cod_articulo = '".$Cod_articulo."' ORDER BY Cod_articulo"))) { //".$Factura."
            $valores['existe'] = "1";
            $valores["Cod_articulo"] = $resultados["Cod_articulo"];
            $valores["Descripcion"] = $resultados["Descripcion"];
            }
        }
        $valores = json_encode($valores);
        echo $valores;
        //echo $Factura;
      ?>