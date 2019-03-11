<?php 

// Top level menu del plugin
function menu_administrador(){
	add_menu_page(
		'Leads cliente X',
		'Leads cliente X',
		'manage_options',
		RUTA .'/admin/configuracion.php',
		'leads_func'
	);

	add_submenu_page(
		RUTA . '/admin/configuracion.php',
		'Settings',
		'Settings',
		'manage_options',
		RUTA . '/admin/settings.php'
	);
}

// El hook admin_menu ejecuta la funcion
add_action( 'admin_menu', 'menu_administrador' );



function leads_func(){
        echo '
        <div class="wrap">
        	<h2>Leads clientes</h2>
        </div>';
}

?>