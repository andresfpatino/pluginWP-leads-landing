<?php
/**
 * Plugin Name: Cliente X 
 * Plugin URI:  https://github.com/andresfpatino/pluginWP-leads-landing
 * Description: Plugin para captar datos de usuarios mediante una landing page
 * Version:     1.0
 * Author:      Andrés Felipe Patiño V.
 * Author URI:  https://felipepatino.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


defined('ABSPATH') or die("Bye bye");
define('RUTA',plugin_dir_path(__FILE__));


/*
* CREA LA TABLA AL ACTIVAR EL PLUGIN
*/
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

function create_table() {
    global $wpdb; 
    // Obtenemos el prefijo de la BD
    $tabla = $wpdb->prefix . 'leads';
    // Obtenemos el collation de la instalación
    $charset_collate = $wpdb->get_charset_collate();
    $sql = dbDelta(
        "CREATE TABLE $tabla (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nombre varchar(50) NOT NULL,
            apellido varchar(50) NOT NULL,
            correo  varchar(50) DEFAULT '' NOT NULL,
            telefono varchar(10) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate; "
    );
}
// Hook que se ejecuta al activar el plugin
register_activation_hook( __FILE__, 'create_table' );


/*
* ELIMINA LA TABLA AL DESACTIVAR EL PLUGIN
*/
function remove_table(){
    global $wpdb;
    //el nombre de la tabla, utilizamos el prefijo de wordpress
    $tabla = $wpdb->prefix . 'leads';
    $sql = "DROP table IF EXISTS $tabla";
	$wpdb->query($sql);
}
// Hook que se ejecuta al desactivar el plugin
register_deactivation_hook(__FILE__, 'remove_table' );



// Add menu page
include(RUTA.'/includes/opciones.php');

// Logica de la landing
require_once(RUTA.'/public/landing.php');












