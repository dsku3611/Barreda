<?php
require('./Inicial.php');
$conexionSecure = connSecure();
if(isset($_POST['buscar'])){
       $Factura = $_POST['factura'];
       //$Factura = 104084;
       $valores = array();
       $valores['existe'] = "NO";
      
        if ($resultados = mysqli_fetch_array($conexionSecure->query("SELECT a.id, b.DocNum ,  a.CODIGO_EMP, a.RAZON_SOCIAL, a.N_RFC, a.CALLE1, a.CP, a.CALLE2, a.PER_CONTACTO, a.CIUDAD, a.MUN1, a.MUN2, a.PAIS, a.CIUDAD2, a.ESTADO1, a.ESTADO2, a.COLONIA, a.NUM_INT, a.NUMERO_CALLE, a.TEL1, a.TEL2, a.EMAIL,  b.CANCELED, b.DocDate, b.U_IL_Atencion FROM identa_facturas b , identa_clientes a where a.CODIGO_EMP = b.CardCode and DocNum ='".$Factura."'"))) { //".$Factura."
            $direccion_unido = ("CALLE ". $resultados["CALLE1"] ." ".$resultados["CALLE2"].", NO. INT. ".$resultados["NUMERO_CALLE"].", NO. EXT. ".$resultados["NUM_INT"].", COLONIA ".$resultados["COLONIA"].", CP ".$resultados["CP"].", LOCALIDAD " .$resultados["CIUDAD"].", MUNICIPIO ".$resultados["MUN1"]. ", ESTADO DE ".$resultados["ESTADO1"]." , PAIS DE ".$resultados["PAIS"]);
            $valores['existe'] = "SI";
            $valores["RAZON_SOCIAL_CLIENTE"] = $resultados["RAZON_SOCIAL"];
            $valores["NUM_CLIENTE"] = $resultados["CODIGO_EMP"];
            $valores["TELEFONO_CLIENTE"] = $resultados["TEL1"];
            $valores["EMAIL_CLIENTE"] = $resultados["EMAIL"];
            $valores["CONTACTO_CLIENTE"] = $resultados["PER_CONTACTO"];
            $valores["ESTATUS"] = $resultados["CANCELED"];
            $valores["VENDEDOR"] = $resultados["U_IL_Atencion"];
            $valores["DIRECCION_CLIENTE"] = $direccion_unido;
            }
        }
        $valores = json_encode($valores);
        echo $valores;
        //echo $Factura;
      ?>