//FUNCION DE TODAS LAS VENTANAS PARA EL TAMAÑO
 function Ventana(){
	window.moveTo(0,0);
	window.resizeTo(screen.width,screen.height);
 }

	var statSend = false;
	function checkSubmit() {
    	if (!statSend) {
       	 	statSend = true;
        	return true;
    	} else {
        	alert("El Formulario ya fue Enviado, espere a que termine de Almacenar");
        	return false;
    	}
	}
	
	var statSend2 = false;
	function checkSubmit2() {
    	if (!statSend2) {
       	 	statSend2 = true;
        	return true;
    	} else {
        	alert("El Bloqueo ya fue Enviado, Espere a que termine ...");
        	return false;
    	}
	}
	
	var statSend3 = false;
	function checkSubmit3() {
    	if (!statSend3) {
       	 	statSend3 = true;
        	return true;
    	} else {
        	alert("El Formulario ya fue Enviado, espere a que termine de Almacenar Cambios");
        	return false;
    	}
	}	
	
//FUNCION PARA EL RELOJ DEL PIE DE PAGINA 
 function mueveReloj(){
	momentoActual = new Date()
	hora = momentoActual.getHours()
	minuto = momentoActual.getMinutes()
	segundo = momentoActual.getSeconds()
	
	str_segundo = new String (segundo)
	if (str_segundo.length == 1) 
		segundo = "0" + segundo
		
	str_minuto = new String (minuto)
	if (str_minuto.length == 1) 
		minuto = "0" + minuto

	str_hora = new String (hora)
	if (str_hora.length == 1) 
		hora = "0" + hora
		
	horaImprimible = hora + " : " + minuto + " : " + segundo
	document.form_reloj.reloj.value = horaImprimible	
	setTimeout("mueveReloj()",1000)
}

//CODIGO PARA LIMITAR UN TEXTAREA
$(document).ready(function(){
$("textarea[maxlength]").keyup(function() {
var limit   = $(this).attr("maxlength"); // Límite del textarea
var value   = $(this).val();             // Valor actual del textarea
var current = value.length;              // Número de caracteres actual
if (limit < current) {                   // Más del límite de caracteres?
$(this).val(value.substring(0, limit));
}
});
});

function noEnter(textfield){
	string = textfield.value;
	string = string.replace(/\n/g, " ");
	textfield.value = string;
}

	function msj(){
	alert('¡¡¡CONSIDERACIONES PARA AGENDAR!!!\n\n1.- Capacitaciones de 11:00 - 12:00 hrs. \n2.- Demostraciones de 10:00 - 14:00 hrs.\n3.- Para eventos Locales, Reservar 2 dias antes \n4.- Para eventos Foraneos, Reservar 7 dias antes');	
	}

	<!-- Begin
	function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=yes,location=false,statusbar=0,menubar=0,resizable=false,width=600,height=660,left=225,top=0');");
	}
	// End -->