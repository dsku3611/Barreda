<?php
require('./Inicial.php');
$conexionSecure = connSecure();
if(isset($_POST['buscar'])){
       $CODIGO_EMP = $_POST['CODIGO_EMP'];
       //$Factura = 104084;
       $valores = array();
       $valores['existe'] = "0";
      
        if ($resultados = mysqli_fetch_array($conexionSecure->query("SELECT * FROM identa_clientes where CODIGO_EMP = '".$CODIGO_EMP."' ORDER BY RAZON_SOCIAL"))) { //".$Factura."
            $direccion_unido = ("CALLE ". $resultados["CALLE1"] ." ".$resultados["CALLE2"].", NO. INT. ".$resultados["NUMERO_CALLE"].", NO. EXT. ".$resultados["NUM_INT"].", COLONIA ".$resultados["COLONIA"].", CP ".$resultados["CP"].", LOCALIDAD " .$resultados["CIUDAD"].", MUNICIPIO ".$resultados["MUN1"]. ", ESTADO DE ".$resultados["ESTADO1"]." , PAIS DE ".$resultados["PAIS"]);
            $valores['existe'] = "1";
            $valores["RAZON_SOCIAL_CLIENTE"] = $resultados["RAZON_SOCIAL"];
            $valores["NUM_CLIENTE"] = $resultados["CODIGO_EMP"];
            $valores["TELEFONO_CLIENTE"] = $resultados["TEL1"];
            $valores["EMAIL_CLIENTE"] = $resultados["EMAIL"];
            $valores["CONTACTO_CLIENTE"] = $resultados["PER_CONTACTO"];
            $valores["DIRECCION_CLIENTE"] = $direccion_unido;
            }
        }
        $valores = json_encode($valores);
        echo $valores;
        //echo $Factura;
      ?>