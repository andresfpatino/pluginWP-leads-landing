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
            telefono varchar(50) NOT NULL,
            fecha varchar(50) NOT NULL,
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
    $tabla = $wpdb->prefix . 'leads';
    $sql = "DROP table IF EXISTS $tabla";
	$wpdb->query($sql);
    // Elimina las opciones creadas
    delete_option( 'logo' );
    delete_option( 'titulo' );
    delete_option( 'intro_txt' );
    delete_option( 'thanks_page' );
    delete_option( 'link_politicas' );
}
// Hook que se ejecuta al desactivar el plugin
register_deactivation_hook(__FILE__, 'remove_table' );



// Add menu page
include(RUTA.'/includes/opciones.php');

// Logica de la landing
require_once(RUTA.'/public/landing.php');


// Registra cargar de scripts en el admin
function admin_scripts() {
    wp_enqueue_style('sweetalert', plugin_dir_url( __FILE__ ).'admin/css/sweetalert.css');    
    wp_enqueue_style('pagination', plugin_dir_url( __FILE__ ).'admin/css/pagination.css'); 
    wp_enqueue_script('sweetalertjs', plugin_dir_url( __FILE__ ).'admin/js/sweetalert.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('adminjs', plugin_dir_url( __FILE__ ).'admin/js/admin-ajax.js', array('jquery'), '1.0', true);    
    wp_enqueue_media();
    wp_enqueue_script('upload-image', plugin_dir_url( __FILE__ ).'admin/js/upload-image.js', array('jquery'), '1.0', true);

    // pasar la url de WP ajax al admin-ajax.js
    wp_localize_script(
        'adminjs',
        'url_eliminar',
        array('ajaxurl' => admin_url('admin-ajax.php'))
    );
}
add_action('admin_enqueue_scripts', 'admin_scripts');