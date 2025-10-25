validarSession();
let myModal = new bootstrap.Modal(document.getElementById('ModalAdd'));
class EventsManager {
    constructor() {
        this.obtenerDataInicial();
    }
    obtenerDataInicial() {
        let url = "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/getEvents.php";
        $.ajax({
            url: url,
            dataType: "json",
            cache: false,
            processData: false,
            contentType: false,
            type: "GET",
            success: (data) => {
                if (data.msg == "OK") {
                    if (data.getData == "OK") {
                        this.poblarCalendario(data.eventos);
                        return data.eventos;
                    } else {
                        alert("Hubo un error al obtener los eventos.");
                    }
                } else {
                    alert(data.msg);
                    window.location.href = "index.php";
                }
            },
            error: function () {
                alert("Error en la comunicación con el servidor data inicial");

            },
        });
    }

    poblarCalendario(eventos) {
        var d = new Date();
        $(".calendario").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,basicDay",

            },
            defaultDate:
                d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate(),
            navLinks: true,
            //editable: true, // no apto para ventas
            eventLimit: true,
            droppable: true,
            selectable: true,
            selectHelper: true,
            eventOverlap: true,
            dragRevertDuration: 0,
            timeFormat: "H:mm",
            hiddenDays: [ 0, 6 ],
            lang: 'es',
            showNonCurrentDates:true,
            themeSystem:'jquery-ui',
            select: function (start, end) {

                $('#ModalAdd #start_date').val(moment(start).format('YYYY-MM-DD'));
                //$('#ModalAdd #end').val(moment(end).format('DD-MM-YYYY'));
                //$('#ModalAdd').modal({ show: true });
                myModal.show();
            },

            //validRange: {
                //start: defaultDate,
              //  start: d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate(),
                //},
         
            //eventDrop: (event) => {
                //alert(info.event.title + " was dropped on " + info.event.start.toISOString());
            //    this.actualizarEvento(event);
            //},
            events: eventos,
           // eventDragStart: (event, jsEvent) => {
                //$(".delete-btn").find("img").attr("src", "img/trash-open.png");
                //$(".delete-btn").css("background-color", "#a70f19");
           // },
          //  eventDragStop: (event, jsEvent) => {
             //   var trashEl = $(".delete-btn");
            //    var ofs = trashEl.offset();
             //   var x1 = ofs.left;
             //   var x2 = ofs.left + trashEl.outerWidth(true);
             //   var y1 = ofs.top;
             //   var y2 = ofs.top + trashEl.outerHeight(true);
             //   if (
            //        jsEvent.pageX >= x1 &&
            //        jsEvent.pageX <= x2 &&
            //        jsEvent.pageY >= y1 &&
             //       jsEvent.pageY <= y2
              //  ) {
               //     if (confirm("Deseas aliminar el evento") == true) {
             //           this.eliminarEvento(event, jsEvent);
              //          $(".calendario").fullCalendar("removeEvents", event.id);
                //    } else {
                 //       window.location.reload();
                //    }

              //  }
           // },




        });
    }

    anadirEvento() {

        //$hoy = j.getFullYear() + "-" + (j.getMonth() + 1) + "-" + j.getDate();
        if (this.validarForm() == true) {
            var form_data = new FormData();
            form_data.append("titulo", $("#titulo").val());
            form_data.append("start_date", $("#start_date").val());
            form_data.append("allDay", document.getElementById("allDay").checked);
            form_data.append("Estatus", "0");
            form_data.append("Factura", $("#Factura").val());
            form_data.append("Ejecutivo", $("#Ejecutivo").val());
            form_data.append("Categoria", $("#Categoria").val());
            form_data.append("Ubicacion", $("#Ubicacion").val());
            form_data.append("Uniforme", $("#Uniforme").val());
            form_data.append("Direccion_eve", $("#Direccion_eve").val());
            form_data.append("Referencias", $("#Referencias").val());
            form_data.append("Num_parte", $("#Num_parte").val());
            form_data.append("Modelo", $("#Modelo").val());
            form_data.append("Serie", $("#Serie").val());
            form_data.append("Cod_cliente", $("#Cod_cliente").val());
            form_data.append("Razon_cliente", $("#Razon_cliente").val());
            form_data.append("Direccion_cliente", $("#Direccion_cliente").val());
            form_data.append("Contacto_cliente", $("#Contacto_cliente").val());
            form_data.append("Telefono_cliente", $("#Telefono_cliente").val());
            form_data.append("email_cliente", $("#email_cliente").val());
            form_data.append("Razon_Final", $("#Razon_Final").val());
            form_data.append("Contacto_final", $("#Contacto_final").val());
            form_data.append("Telefono_final", $("#Telefono_final").val());
            form_data.append("Email_final", $("#Email_final").val());
            form_data.append("Observaciones_final", $("#Observaciones_final").val());
            form_data.append("Filial", $("#Filial").val());
            form_data.append("Tipo_producto", $("#Tipo_producto").val());
            if (!document.getElementById("allDay").checked) {
                form_data.append("end_date", $("#start_date").val());
                form_data.append("end_hour", "");
                form_data.append("start_hour", $("#start_hour").val());
              } else {
                form_data.append("end_date", $("#start_date").val());
                form_data.append("end_hour", "");
                form_data.append("start_hour", "");
              }


            $.ajax({
                url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/new_event.php",
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                data: form_data,
                type: "POST",
                success: (data) => {
                    if (data.msg == "OK") {
                        if (document.getElementById("allDay").checked) {
                            $(".calendario").fullCalendar("renderEvent", {
                                id: data.id,
                                title: $("#titulo").val(),
                                start: $("#start_date").val(),
                                allDay: true,
                            });

                        } else {
                            $(".calendario").fullCalendar("renderEvent", {
                                id: data.id,
                                title: $("#titulo").val(),
                                start: $("#start_date").val() + "T" + $("#start_hour").val(),
                                allDay: false,
                                end: $("#end_date").val() + "T" + $("#end_hour").val(),
                            });
                        }
                        alert("Se ha añadido el evento exitosamente ");
                        window.location.reload();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data) {
                    alert("Ha ocurrido un error en la comunicación con el servidor añadir evento");
                    alert(data.msg);
                },
            });
        } else {
            alert("* Típo de evento y fecha de inicio no pueden ser vacios  \n * No se permiten agendar para el mismo dia");
        }
    }
    validarForm() {
        var d = new Date();
            if ($("#titulo").val() != "" && $("#start_date").val() != "" && $("#start_date").val() != d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()) {
              return true;
            } else {
              return false;
            }
          

    }

    //eliminarEvento(event, jsEvent) {
      //  var form_data = new FormData();
      //  form_data.append("id", event.id);
     //   $.ajax({
      //      url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/delete_event.php",
        //    dataType: "json",
       //     cache: false,
      //      processData: false,
       //     contentType: false,
       //     data: form_data,
        //    type: "POST",
        //    success: (data) => {
          //      if (data.msg == "OK") {
          //          $(".calendario").fullCalendar("removeEvents", event.id);
             //       alert("Se ha eliminado el evento exitosamente");
           //     } else {
           //         alert(data.msg);
           //     }
          //  },
          //  error: function () {
          //      alert("error en la comunicación con el servidor eliminar evento");
           // },
       // });
    //    $(".delete-btn").find("img").attr("src", "img/trash.png");
    //    $(".delete-btn").css("background-color", "#8B0913");
   // }

   // editarEvento(event, jsEvent) {
    //    var form_data = new FormData();
   //     form_data.append("id", event.id);

        //alert("Se ha actualizado el evento exitosamente"+ info.event.id);
    //    $.ajax({
    ///        url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/editar_evento.php",
     //       dataType: "json",
    //        cache: false,
     //       processData: false,
     //       contentType: false,
        //    data: form_data,
          //  type: "POST",
        //    success: (data) => {
         //       if (data.msg == "OK") {
           //         alert("Se ha actualizado el evento exitosamente");
         //       } else {
          //          alert(data.msg);
         //       }
         //   },
          //  error: function () {
         //       alert("error en la comunicación con el servidor actualizar evento");
         //   },
       // });

   // }

    actualizarEvento(evento) {
        let id = evento.id,
            start = moment(evento.start).format("YYYY-MM-DD HH:mm:ss"),
            end = moment(evento.end).format("YYYY-MM-DD HH:mm:ss"),
            form_data = new FormData(),
            start_date,
            end_date,
            start_hour,
            end_hour;

        start_date = start.substr(0, 10);
        end_date = end.substr(0, 10);
        start_hour = start.substr(11, 8);
        end_hour = end.substr(11, 8);

        form_data.append("id", id);
        form_data.append("start_date", start_date);
        form_data.append("end_date", end_date);
        form_data.append("start_hour", start_hour);
        form_data.append("end_hour", end_hour);

        //lert(info.event.title + " was dropped on " + info.event.start.toISOString());

        $.ajax({
            url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/update_event.php",
            dataType: "json",
            cache: false,
            processData: false,
            contentType: false,
            data: form_data,
            type: "POST",
            success: (data) => {
                if (data.msg == "OK") {
                    alert("Se ha actualizado el evento exitosamente");
                } else {
                    alert(data.msg);
                }
            },
            error: function () {
                alert("error en la comunicación con el servidor actualizar evento");
            },
        });
    }
}

$(function () {
    initForm();
    var e = new EventsManager();
    $("form").submit(function (event) {
        event.preventDefault();
        e.anadirEvento();
    });

});

function initForm() {
    $("#start_date, #titulo, #end_date").val("");
    $("#start_date, #end_date").datepicker({
        dateFormat: "yy-mm-dd",
        beforeShowDay: $.datepicker.noWeekends,
        minDate: +1, maxDate: "+1M +10D"
    });
    $(".timepicker").timepicker({
        timeFormat: "HH:mm",
        interval: 30,//interval: 180,
        minTime: "11:00",
        maxTime: "15:00",
        defaultTime: "11",
        startTime: "10:00",
        dynamic: false,
        dropdown: true,
        scrollbar: true,
    });
    $("#allDay").on("change", function () {
        if (this.checked) {
            $(".timepicker, #end_date").attr("disabled", "disabled");
        } else {
            $(".timepicker, #end_date").removeAttr("disabled");
        }
    });
}

function validarSession() {
    $.ajax({
        url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/session.php",
        dataType: "json",
        type: "post",
        success: function (data) {
            if (data.msg == "") {
                window.location.href = "./index.php";
            }
        },
        error: function (data) {
            //window.location.href = './index.php'
        },
    });
}

function Abrir_ventana(pagina) {
    var opciones = "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=400,height=400,top=50,left=80";
    window.open(pagina, "", opciones);
}

$(document).ready(function(){
    //alert("entro en la funcion");
    $("#Buscar_Razon_cliente").select2({
        dropdownParent: $('#ModalAdd'),
        ajax: {
            url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/extraer.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            //beforeSend: function () {alert("antes de enviar"); },
            //error: function () { alert("Error"); },
            complete: function () {
                

             },
            data: function (params) {
                
                return {
                    searchTerm: params.term // search term
                    
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $("#Buscar_Equipos").select2({
        dropdownParent: $('#ModalAdd'),
        ajax: {
            url: "http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/extraer_equipos.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            //beforeSend: function () {alert("antes de enviar"); },
            //error: function () { alert("Error"); },
            complete: function () {
                

             },
            data: function (params) {
                
                return {
                    searchTerm: params.term // search term
                    
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
});

function buscar_datos() {
    //alert("entro en buscar datos");
    factura = $("#Factura").val();
    var parametros =
    {
        "buscar": "1",
        "factura": factura
    };
    $.ajax(
        {
            data: parametros,
            dataType: 'json',
            url: 'http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/buscar_factura.php',
            type: 'post',
            beforeSend: function () { },
            error: function () { alert("Error"); },
            complete: function () { },
            success: function (valores) {
                if (valores.existe == 'NO'){
                    alert("* Factura ingresada sin registro");
                  }else{
                    if (valores.ESTATUS == 'Y' ) {
                        //alert(valores.VENDEDOR);
                        alert("*Factura ingresada cancelada sin registros");
                    } else {
                        $("#Cod_cliente").val(valores.NUM_CLIENTE);
                        $("#Razon_cliente").val(valores.RAZON_SOCIAL_CLIENTE);
                        $("#Telefono_cliente").val(valores.TELEFONO_CLIENTE);
                        $("#email_cliente").val(valores.EMAIL_CLIENTE);
                        $("#Contacto_cliente").val(valores.CONTACTO_CLIENTE);
                        $("#Direccion_cliente").val(valores.DIRECCION_CLIENTE);
    
                    }
                  }
            }
        })
}

function buscar_cliente() {
    //alert("entro en buscar clientes");
    CODIGO_EMP = $("#Buscar_Razon_cliente").val();
    var parametros =
    {
        "buscar": "1",
        "CODIGO_EMP": CODIGO_EMP
    };
    $.ajax(
        {
            data: parametros,
            dataType: 'json',
            url: 'http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/buscar_cliente.php',
            type: 'post',
            beforeSend: function () { },
            error: function () { alert("Error"); },
            complete: function () { },
            success: function (valores) {

                $("#Cod_cliente").val(valores.NUM_CLIENTE);
                $("#Razon_cliente").val(valores.RAZON_SOCIAL_CLIENTE);
                $("#Telefono_cliente").val(valores.TELEFONO_CLIENTE);
                $("#email_cliente").val(valores.EMAIL_CLIENTE);
                $("#Contacto_cliente").val(valores.CONTACTO_CLIENTE);
                $("#Direccion_cliente").val(valores.DIRECCION_CLIENTE);

            }
        })
}
function Buscar_Datos_equipo() {
    //alert("entro en buscar clientes");
    Cod_articulo = $("#Buscar_Equipos").val();
    var parametros =
    {
        "buscar": "1",
        "Cod_articulo": Cod_articulo
    };
    $.ajax(
        {
            data: parametros,
            dataType: 'json',
            url: 'http://localhost/IDENTATRONICSV2/Adicionales/Agenda/server/buscar_equipos.php',
            type: 'post',
            beforeSend: function () { },
            error: function () { alert("Error"); },
            complete: function () { },
            success: function (valores) {

                $("#Modelo").val(valores.Descripcion);
                $("#Num_parte").val(valores.Cod_articulo);
            }
        })
}
