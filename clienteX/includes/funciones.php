<?php 

/*
* @description Hook que se ejecuta al activar el plugin
*/
register_activation_hook( __FILE__, 'udp_create_tables' );

/*
* @description Función que crea las tablas en la activación del plugin
*/
function udp_create_tables(){
	//obtenemos el objeto $wpdb
    global $wpdb;

    //el nombre de la tabla, utilizamos el prefijo de wordpress
    $table_name = $wpdb->prefix . 'leads';

    //sql con el statement de la tabla
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      search varchar(255) DEFAULT NULL,
      UNIQUE KEY id (id)
    );";

	//upgrade contiene la función dbDelta la cuál revisará si existe la tabla o no
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //creamos la tabla
    dbDelta($sql);
}

/*
* @description Hook que se ejecuta una sóla vez ideal para este caso
*/
add_action( 'wp_footer', 'udp_get_search' );

function udp_get_search(){
	if(isset($_GET["s"]) && !empty($_GET["s"]))
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'udp_statistics_searchs';

	    $wpdb->insert( 
	        $table_name, 
	        array( 
	            'search' =>  esc_attr( $_GET["s"] )
	        )
	    );
	}
}

/*
* @description Hook que se ejecuta al desactivar el plugin
*/
register_deactivation_hook(__FILE__, 'udp_remove_tables' );

/*
* @description Función que se ejecuta al desactivar el plugin
*/
function udp_remove_tables(){
	//obtenemos el objeto $wpdb
    global $wpdb;

    //el nombre de la tabla, utilizamos el prefijo de wordpress
    $table_name = $wpdb->prefix . 'udp_statistics_searchs';

    //sql con el statement de la tabla
    $sql = "DROP table IF EXISTS $table_name";

	$wpdb->query($sql);
}