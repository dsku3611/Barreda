/*----POSICION DEL CURSOR---*/
	$(function () {
		$(window).load(function () {
			$(':input:visible:enabled:first').focus();
		});
	});
	
/*----PASAR CON ENTER---*/
    function cambiaEnter(campo){
	            tb = $(campo);

			   if ($.browser.mozilla) {
			       $(tb).keypress(enter2tab);
			   } else {
			       $(tb).keydown(enter2tab);
			      
			   }

			function enter2tab(e) {
		     if (e.keyCode == 13) {
		             cb = parseInt($(this).attr('tabindex'));
		    
		           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
		           		$(':input[tabindex=\'' + (cb + 1) + '\']').select();
		               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
		               
		               e.preventDefault();
		    
		               return false;
		           }
		       }
		   }
   }
/*MAYUSCULAS*/
   function mayuscula(campo){
	                $(campo).keyup(function() {
	                $(this).val($(this).val().toUpperCase());
	                });
   }