<?php
require('server/Inicial.php');
$conexionSecure = connSecure();
$sql = "SELECT id,Evento FROM identa_configuracion";
$resultado = $conexionSecure->query($sql);
$rs = $conexionSecure->query("select max(id) from identa_eventos");
if ($row = mysqli_fetch_row($rs)) {
  $id = trim($row[0] + 1);
}
$id_juser = $_GET["user"];
$row_user = $conexionSecure->query("SELECT * FROM `identa_users` where id = $id_juser;");
if ($row = mysqli_fetch_row($row_user)) {
  $ejectutivo = trim($row[1]);
}

if ($row = mysqli_fetch_row($conexionSecure->query("SELECT * FROM `identa_user_usergroup_map` where user_id = $id_juser and group_id IN (12,27,16);"))) {
  $permiso = trim($row[1]);
} else {
  $permiso = 0;
}
if ($permiso != 12 && $permiso != 27 && $permiso != 16) {
  $js_doc = "app.js";
} else {
  $js_doc = "app_2.js";
}
if ($row = mysqli_fetch_row($conexionSecure->query("SELECT * FROM `identa_user_usergroup_map` where user_id = $id_juser and group_id IN (13);"))) {
  $permiso2 = trim($row[1]);
} else {
  $permiso2 = 0;
}
?>

<!DOCTYPE html>
<html class="no-js" lang="es" dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
  <link rel="stylesheet" href="css/foundation.min.css" />
  <link rel="stylesheet" href="css/fullcalendar.min.css" />
  <script src="js/i18n/es.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
  <script src="js/lib2.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
  <script src="js/Val_Enter.js"></script>
  <script src="js/Val_Tam.js"></script>
  <link
    rel="stylesheet"
    href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" />
  <link
    rel="stylesheet"
    href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="expanded-row main-container">
    <div class="left-cont">
      <div class="calendario"></div>
    </div>

    <div class="right-cont">
      <div class="modal" tabindex="-1" id="ModalAdd" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <form autocomplete="off">
                <div class="row">
                 
                  <div class="small-12 columns" style=" background: #000;">
                  <label style=" TEXT-ALIGN: center;  FONT-SIZE: 1.5rem; ">DATOS DEL EVENTO </label>
                  </div>
                  <div class="small-2 columns">
                    <label>TICKET</label>
                    <input type="text" style="text-align:center;" class="form-control" size="5" value="SRV00<?= $id; ?>" readonly style="font-weight: bold;">
                    </label>
                  </div>
                  <div class="small-2 columns">
                    <label>Fecha inicio
                      <input type="text" id="start_date" />
                    </label>
                  </div>
                  <!--<div class="small-2 columns">
                <label>Fecha fin
                  <input type="text" id="end_date" />
                </label>
              </div>-->
                  <div class="small-2 columns">
                    <label>Hora de inicio
                      <input type="text" class="timepicker" id="start_hour" />
                    </label>
                  </div>
                  <!--<div class="small-2 columns">
                <label>Hora fin
                  <input type="text" class="timepicker" id="end_hour" />
                </label>
              </div>-->
                  <div class="small-4 columns">
                    <label>Ejecutivo
                      <input type="text" id="Ejecutivo" value="<?= $ejectutivo; ?>" readonly />
                    </label>
                  </div>
                  <fieldset class="large-2 columns" id="dia-set">
                    <input id="allDay" <?php if ($permiso != 12) {echo 'type="hidden"';} ?>type="checkbox" /><label for="allDay"><?php if ($permiso == 12) {echo 'Apartar Dia';} ?></label>
                  </fieldset>

                  <div class="small-8 columns">
                    <label>Tipo de evento
                      <select id="titulo">
                        <option value="">Selecciona una opcion</option>
                        <?php while ($fila = $resultado->fetch_assoc()) { ?>
                          <option value="<?php echo $fila['Evento']; ?>"><?php echo $fila['Evento']; ?></option>
                        <?php } ?>
                      </select>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Numero Factura
                      <input type="text" id="Factura" onchange="buscar_datos();" />
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Categoria
                      <select name="categoria" id="Categoria">
                        <option value="#000000" selected> Categoria </option>
                        <option style="color:#008000;" value="#008000"> Normal </option>
                        <option style="color:#FF0000;" value="#630000"> Urgente </option>
                      </select>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Ubicacion
                      <select id="Ubicacion">
                        <option value="0"> * Ubicacion </option>
                        <option value="Local"> Local </option>
                        <option value="Foraneo"> Foraneo </option>
                      </select>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Uniforme
                      <select name="Uniforme" id="Uniforme">
                        <option value="0"> * Uniforme </option>
                        <option value="Si"> Si </option>
                        <option value="No"> No </option>
                      </select>
                    </label>
                  </div>
                  <div class="small-12 columns">
                    <label>Direccion del Evento
                      <textarea name="Direccion_eve" id="Direccion_eve" rows="3" maxlenght="100" class="form-control" placeholder="Direccion" onKeyPress="noEnter(this)" onBlur="noEnter(this)"></textarea>
                    </label>
                  </div>

                  <div class="small-12 columns">
                    <label>Referencias
                      <input type="text" id="Referencias" />
                    </label>
                  </div>
                  <div class="small-7 columns">
                    <label>Filial
                      <select id="Filial">
                        <option value="0"> * Elije una </option>
                        <option value="IDentatronics"> IDentatronics </option>
                        <option value="Carnets de México"> Carnets de México </option>
                      </select>
                    </label>
                  </div>

                  <div class="small-5 columns">
                    <label>Tipo de Producto
                      <select name="Tipo_producto" id="Tipo_producto">
                        <option value="0"> * TIPO </option>
                        <option value="HARDWARE"> HARDWARE </option>
                        <option value="SOFTWARE"> SOFTWARE </option>
                        <option value="HARDWARE Y SOFTWARE"> HARDWARE Y SOFTWARE </option>
                      </select>
                    </label>
                  </div>

                  <div class="small-12 columns" style=" background: #000;">
                    <label style=" TEXT-ALIGN: center;  FONT-SIZE: 1.5rem; ">DATOS DEL DISTRIBUIDOR / CLIENTE NUEVO </label>
                  </div>

                  <div class="small-2 columns">
                    <label>Codigo Del cliente
                      <input type="text" name="Cod_client" id="Cod_cliente" class="form-control" size="1" placeholder="Codigo Cliente" maxlength="10" readonly ondblclick="buscar_cliente();">
                    </label>
                  </div>
                  <div class="small-5 columns">
                    <label>Razon Social
                    </label>
                    <input type="text" id="Razon_cliente" />
                  </div>

                  <div class="small-5 columns">
                    <label>Buscar por Razon Social
                    </label>
                    <select id='Buscar_Razon_cliente' style='width: 100%; ' lang="es">
                      <option value='0'>- Buscar -</option>
                    </select>
                  </div>

                  <div class="small-12 columns">
                    <label>Direccion
                      <textarea name="Direccion_cliente" id="Direccion_cliente" rows="3" class="form-control" placeholder="* Direccion" required tabindex="13" onKeyPress="noEnter(this)" onBlur="noEnter(this)"></textarea>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Nombre de Contacto
                      <input type="text" name="Contacto_cliente" id="Contacto_cliente" class="form-control" maxlenght="60" placeholder="* Nombre de Contacto" required>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Telefono
                      <input type="text" name="Telefono_cliente" id="Telefono_cliente" maxlenght="25" class="form-control" size="1" placeholder="* Telefono" required>
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>E-Mail
                      <input type="text" name="email_cliente" id="email_cliente" maxlenght="60" class="form-control" placeholder="* E-Mail" required>
                    </label>
                  </div>
                  <div class="small-12 columns" style=" background: #000;">
                    <label style=" TEXT-ALIGN: center;  FONT-SIZE: 1.5rem; ">DATOS DEL EQUIPO</label>
                  </div>
                  <div class="small-12 columns">
                    <label>Buscar por Modelo
                    </label>
                    <select id='Buscar_Equipos' style='width: 100%; ' lang="es">
                      <option value='0'>- Buscar -</option>
                    </select>
                  </div>
                  <div class="small-3 columns">
                    <label>Numero de Parte
                      <input type="text" name="Num_parte" id="Num_parte" class="form-control buscar2" readonly placeholder="* Num. Parte" title="Agregar Articulos" ondblclick="Buscar_Datos_equipo();">
                    </label>
                  </div>
                  <div class="small-6 columns">
                    <label>Modelo
                      <input type="text" name="Modelo" id="Modelo" class="form-control" maxlength="50" readonly placeholder="* Modelo">
                    </label>
                  </div>
                  <div class="small-3 columns">
                    <label>Serie
                      <input type="text" name="Serie" id="Serie" class="form-control" maxlength="50" placeholder="* Serie">
                    </label>
                  </div>
                  <div class="small-12 columns" style=" background: #000;">
                    <label style=" TEXT-ALIGN: center;  FONT-SIZE: 1.5rem; ">USUARIO FINAL</label>
                  </div>
                  <div class="small-12 columns">
                    <label>Razon Social
                      <input type="text" name="Razon_Final" id="Razon_Final" class="form-control" maxlenght="60" placeholder="Razon Social">
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Nombre de Contacto
                      <input type="text" name="Contacto_final" id="Contacto_final" maxlenght="60" class="form-control" placeholder="Nombre de Contacto">
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>Telefono
                      <input type="text" name="Telefono_final" id="Telefono_final" maxlenght="25" class="form-control" placeholder="Telefono">
                    </label>
                  </div>
                  <div class="small-4 columns">
                    <label>E-Mail
                      <input type="text" name="Email_final" id="Email_final" maxlenght="60" class="form-control" placeholder="E-Mail">
                    </label>
                  </div>
                  <div class="small-12 columns">
                    <label>Observaciones
                      <textarea name="Observaciones_final" id="Observaciones_final" rows="3" maxlenght="100" class="form-control" placeholder="Observaciones" onKeyPress="noEnter(this)" onBlur="noEnter(this)"></textarea>
                    </label>
                  </div>

                  <div class="small-12 columns btn-cont-enviar">
                    <button type="submit" class="success button">Añadir</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      
      <?php
      if ($permiso == 12) {
        echo '<div><br/></div>
           <div class="delete-btn">
              <h6>ELIMINAR</h6>
              <img src="img/trash.png" alt="Eliminar" />
            </div>
            <div><br/></div>';
      }
      ?>


    </div>
  </div>


  <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
  <script src="js/vendor/what-input.js"></script>
  <script src="js/vendor/foundation.min.js"></script>
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
  <script src="js/vendor/fullcalendar.min.js"></script>
  <script src="js/vendor/es.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script src="js/<?php echo $js_doc ?>"></script>

</body>

</html>