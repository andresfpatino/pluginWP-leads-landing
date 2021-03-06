$=jQuery.noConflict();
$(document).ready(function(){
	// Obtener la URL de admin-ajax.php
	//console.log(url_eliminar.ajaxurl);
	$('.borrar_registro').on('click', function(e){
		e.preventDefault();
		var id = $(this).attr('data-registro');
		//console.log(id);
		swal({
			title: '¿Estas seguro?',
			text: 'Esta acción no se puede revertir',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#35bede',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value){
				$.ajax({
					type: 'POST',
					data: {
						'action' : 'elimina_registro',
						'id': id,
						'tipo': 'eliminar'
					},
					url: url_eliminar.ajaxurl,
					success: function(data){
						var resultado = JSON.parse(data);				
						$("[data-registro='"+ resultado +"']").parent().parent().remove();
						swal({
							title: "Eliminado",
							text: "El registro se ha eliminado correctamente.",
							type: "success",
							showConfirmButton: false,
							timer: 2500
						});					
					}
				});
			}
		})
	});
});