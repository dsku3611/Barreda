<?php
require('./Inicial.php');
$conexionSecure = connSecure();
if ($row = mysqli_fetch_row($conexionSecure->query("SELECT COUNT(id) FROM identa_eventos where allday = 1 and fecha_inicio = '" . $_POST['start_date'] . "'"))) {
    $resultado = trim($row[0]);
}
if ($_POST['Factura'] == "") {
    $resultado2 = 0;
}else{
    if ($row2 = mysqli_fetch_row($conexionSecure->query("SELECT COUNT(id)  FROM identa_eventos where Factura = " . $_POST['Factura'] . ""))) {
        $resultado2 = trim($row2[0]);
    }
}
if ($row3 = mysqli_fetch_row($conexionSecure->query("SELECT COUNT(id)  FROM identa_eventos where fecha_inicio = '" . $_POST['start_date'] . "'"))) {
    $resultado3 = trim($row3[0]);
}
//echo $resultado;
//echo $resultado2;
//echo $resultado3;
require('./conector.php');
$con = new ConectorDB();
$response['conexion'] = $con->initConexion($con->database);
if ($resultado3 < 2) {
    if ($resultado == 0) {
        if ($resultado2 == 0) {
            if ($response['conexion'] == 'OK') {
                // generar un arreglo con la información a enviar 
                $data['titulo'] = '"' . $_POST['titulo'] . '"';
                $data['fecha_inicio'] = '"' . $_POST['start_date'] . '"';
                $data['hora_inicio'] = '"' . $_POST['start_hour'] . ':00"';
                $data['fecha_fin'] = '"' . $_POST['end_date'] . '"';
                $data['hora_fin'] = '"' . $_POST['end_hour'] . ':00"';
                $data['allday'] = $_POST['allDay'];
                $data['Estatus'] = '"' . $_POST['Estatus'] . '"';
                $data['Factura'] = '"' . $_POST['Factura'] . '"';
                $data['Ejecutivo'] = '"' . $_POST['Ejecutivo'] . '"';
                $data['Categoria'] = '"' . $_POST['Categoria'] . '"';
                $data['Ubicacion'] = '"' . $_POST['Ubicacion'] . '"';
                $data['Uniforme'] = '"' . $_POST['Uniforme'] . '"';
                $data['Direccion_eve'] = '"' . $_POST['Direccion_eve'] . '"';
                $data['Referencias'] = '"' . $_POST['Referencias'] . '"';
                $data['Num_parte'] = '"' . $_POST['Num_parte'] . '"';
                $data['Modelo'] = '"' . $_POST['Modelo'] . '"';
                $data['Serie'] = '"' . $_POST['Serie'] . '"';
                $data['Cod_cliente'] = '"' . $_POST['Cod_cliente'] . '"';
                $data['Razon_cliente'] = '"' . $_POST['Razon_cliente'] . '"';
                $data['Direccion_cliente'] = '"' . $_POST['Direccion_cliente'] . '"';
                $data['Contacto_cliente'] = '"' . $_POST['Contacto_cliente'] . '"';
                $data['Telefono_cliente'] = '"' . $_POST['Telefono_cliente'] . '"';
                $data['email_cliente'] = '"' . $_POST['email_cliente'] . '"';
                $data['Razon_Final'] = '"' . $_POST['Razon_Final'] . '"';
                $data['Contacto_final'] = '"' . $_POST['Contacto_final'] . '"';
                $data['Telefono_final'] = '"' . $_POST['Telefono_final'] . '"';
                $data['Email_final'] = '"' . $_POST['Email_final'] . '"';
                $data['Observaciones_final'] = '"' . $_POST['Observaciones_final'] . '"';
                $data['Filial'] = '"' . $_POST['Filial'] . '"';
                $data['Tipo_producto'] = '"' . $_POST['Tipo_producto'] . '"';

                //$data['fk_usuarios'] = '"' . $_SESSION['email'] . '"';

                if ($con->insertData('identa_eventos', $data)) { // insertar la información en la base de datos

                    $resultado = $con->consultar(['identa_eventos'], ['MAX(id)']); // obtener el id registrado perteneciente al nuevo registro
                    while ($fila = $resultado->fetch_assoc())
                        $response['id'] = $fila['MAX(id)']; // enviar ultimo Id guardado como parámetro para el calendario
                    $response['msg'] = 'OK';
                  //  echo json_encode($response);
                } else
                    $response['msg'] = "Ha ocurrido un error al guardar el evento"; 
                 //   echo json_encode($response);// mensaje de error
            } else
                $response['msg'] = "Error en la comunicacion con la base de datos"; // mensaje de error en caso de conexion fallida
              //  echo json_encode($response);
        } else {
            $response['msg'] = "Ya se tiene un registro con esta factura";
          //  echo json_encode($response);
        }
    } else {
        $response['msg'] = "Este dia esta apartado";
       // echo json_encode($response);
    }
} else {
    $response['msg'] = "Solo es posible registrar 2 eventos por dia, intenta con otra fecha";
    //echo json_encode($response);
}
echo json_encode($response);
?>