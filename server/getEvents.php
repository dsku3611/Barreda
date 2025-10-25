<?php
setlocale(LC_TIME, "spanish");
require('./conector.php');
require('./Inicial.php');
$con = new ConectorDB();
$response['msg'] = $con->initConexion($con->database); // iniciando conexion


if ($response['msg'] == 'OK') {
    $resultado = $con->consultar(['identa_eventos'], ['*'],  '');
    $i = 0;
    while ($fila = $resultado->fetch_assoc()) { // recorrer el arreglo de resultados
        $response['eventos'][$i]['id'] = $fila['id'];
        $response['eventos'][$i]['title'] = $fila['titulo'];
        $response['eventos'][$i]['color'] = $fila['Categoria'];
        $response['eventos'][$i]['Estatus'] = $fila['Estatus'];
        $response['eventos'][$i]['Factura'] = $fila['Factura'];
        $response['eventos'][$i]['Ejecutivo'] = $fila['Ejecutivo'];
        $response['eventos'][$i]['Ubicacion'] = $fila['Ubicacion'];
        $response['eventos'][$i]['Uniforme'] = $fila['Uniforme'];
        $response['eventos'][$i]['Direccion_eve'] = $fila['Direccion_eve'];
        $response['eventos'][$i]['Referencias'] = $fila['Referencias'];
        $response['eventos'][$i]['Num_parte'] = $fila['Num_parte'];
        $response['eventos'][$i]['Modelo'] = $fila['Modelo'];
        $response['eventos'][$i]['Serie'] = $fila['Serie'];
        $response['eventos'][$i]['Cod_cliente'] = $fila['Cod_cliente'];
        $response['eventos'][$i]['Razon_cliente'] = $fila['Razon_cliente'];
        $response['eventos'][$i]['Direccion_cliente'] = $fila['Direccion_cliente'];
        $response['eventos'][$i]['Contacto_cliente'] = $fila['Contacto_cliente'];
        $response['eventos'][$i]['Telefono_cliente'] = $fila['Telefono_cliente'];
        $response['eventos'][$i]['email_cliente'] = $fila['email_cliente'];
        $response['eventos'][$i]['Razon_Final'] = $fila['Razon_Final'];
        $response['eventos'][$i]['Contacto_final'] = $fila['Contacto_final'];
        $response['eventos'][$i]['Telefono_final'] = $fila['Telefono_final'];
        $response['eventos'][$i]['Email_final'] = $fila['Email_final'];
        $response['eventos'][$i]['Observaciones_final'] = $fila['Observaciones_final'];
        $response['eventos'][$i]['Filial'] = $fila['Filial'];
        $response['eventos'][$i]['Tipo_producto'] = $fila['Tipo_producto'];
         
        if ($fila['allday'] == 0) { // verificar si el regitro esta fullday
            $allDay = false;
            $response['eventos'][$i]['start'] = $fila['fecha_inicio'] . 'T' . $fila['hora_inicio'];
            $response['eventos'][$i]['end'] = $fila['fecha_fin'] . 'T' . $fila['hora_fin'];
        } else {
            $allDay = true;
            $response['eventos'][$i]['start'] = $fila['fecha_inicio'];
            $response['eventos'][$i]['end'] = "";
        }
        $response['eventos'][$i]['allDay'] = $allDay;
        $i++;
    }
    $response['getData'] = "OK";
}
echo json_encode($response); // devolver resultados en json