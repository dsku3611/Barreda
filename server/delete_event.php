<?php
require('./conector.php');
require('./Inicial.php');
$conexionSecure = connSecure();
$sql = "insert into identa_eventos_borrados (id, titulo, fecha_inicio, hora_inicio, fecha_fin, hora_fin, allday, Estatus, Factura, Ejecutivo, Categoria, Ubicacion, Uniforme, Direccion_eve, Referencias, Num_parte, Modelo, Serie, Cod_cliente, Razon_cliente, Direccion_cliente, Contacto_cliente, Telefono_cliente, email_cliente, Razon_Final, Contacto_final, Telefono_final, Email_final, Observaciones_final, Filial, Tecnico)
select id, titulo, fecha_inicio, hora_inicio, fecha_fin, hora_fin, allday, Estatus, Factura, Ejecutivo, Categoria, Ubicacion, Uniforme, Direccion_eve, Referencias, Num_parte, Modelo, Serie, Cod_cliente, Razon_cliente, Direccion_cliente, Contacto_cliente, Telefono_cliente, email_cliente, Razon_Final, Contacto_final, Telefono_final, Email_final, Observaciones_final, Filial, Tecnico from identa_eventos where id =". $_POST['id'];
$resultado = $conexionSecure->query($sql);
$con = new ConectorDB();
$response['conexion'] = $con->initConexion($con->database);
if ($response['conexion'] == 'OK')
    if ($con->eliminarRegistro('identa_eventos', 'id=' . $_POST['id'])) // elimina el evento solicitado
        $response['msg'] = 'OK';
    else
        $response['msg'] = "Ha ocurrido un error al Eliminar el evento";
else
    $response['msg'] = "Error en la comunicacion con la base de datos";
echo json_encode($response);