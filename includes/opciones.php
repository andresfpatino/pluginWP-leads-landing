<?php 

include(RUTA.'/admin/leads.php');
include(RUTA.'/admin/settings.php');

// Añadir item de opciones al menu
function menu_administrador(){
	add_menu_page(
		'Leads ClienteX',
		'Leads ClienteX',
		'administrator',
		'leads_cliente_x', 
		'leads_func', // Callback
		'dashicons-groups',
		2
	);

	add_submenu_page(
		'leads_cliente_x',
		'Settings',
		'Settings',
		'administrator',
		'settings', //callback 
		'settings'
	);

	
}

// El hook admin_menu ejecuta la funcion
add_action( 'admin_menu', 'menu_administrador' );

// Llamar el registro de las opciones en el submenu page settings
add_action('admin_menu', 'settings_leads');

?>