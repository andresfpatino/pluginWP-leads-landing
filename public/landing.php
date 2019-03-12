<?php 

// Escribe un nuevo permalink en la activación
function permalink_activation() {
    permalink_landing();
    flush_rewrite_rules(); 
} register_activation_hook( __FILE__, 'permalink_activation' );

// Si es plugin es desactivado, limpia la estructura de los permalink
function permalink_deactivation() {
    flush_rewrite_rules();
} register_deactivation_hook( __FILE__, 'permalink_deactivation' );

// Crea el permalink para la landing
function permalink_landing() {
    add_rewrite_tag( '%leads-cliente-x%', '([^/]+)' );
    add_permastruct( 'leads-cliente-x', '/%leads-cliente-x%' );
} add_action( 'init', 'permalink_landing' );

// Output pagina landing
function display_landing() {
    if ($query_var = get_query_var('leads-cliente-x')) {
?>  <div class="principal contenedor">
        <main class="contenido">               
            <form class="contacto" method="POST">
                <div class="campo">
                    <input type="text" name="nombre" placeholder="Nombres" required>
                </div>
                <div class="campo">
                    <input type="text" name="apellido" placeholder="Apellidos" required>                        
                </div>
                <div class="campo">
                    <input type="emai" name="correo" placeholder="Correo" required>
                </div>
                <div class="campo">
                    <input type="tel" name="telefono" placeholder="Teléfono" required>
                </div>
                <input type="submit" name="enviar" class="button" value="Solicitar información">
                <input type="hidden" name="oculto" value="1">
            </form>
        </main>
    </div>
<?php exit; 
    }
} add_action( 'template_redirect', 'display_landing' );

// -- Guarda en la BD los datos del formulario
function guardar_BD(){
    if (isset($_POST['enviar']) && $_POST['oculto'] == "1"):
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            global $wpdb;                
            // Limpiamos los campos de caracteres indeseados
            $nombre = sanitize_text_field( $_POST['nombre']);
            $apellido = sanitize_text_field( $_POST['apellido']);
            $correo = sanitize_text_field( $_POST['correo']);
            $telefono = sanitize_text_field( $_POST['telefono']);

            $tabla = $wpdb->prefix.'leads';
            $datos = array(
                'nombre'    => $nombre,
                'apellido'     => $apellido,
                'correo'    => $correo,
                'telefono'  => $telefono
            );
            
            $formato = array(
                '%s',
                '%s',
                '%s',
                '%s'
            );

            $wpdb->insert($tabla, $datos, $formato);

            // redirección luego de enviar
            // $page_url = get_site_url();
            // wp_redirect($page_url . '/gracias-cliente-x');
            exit;          
        }

    endif;
} add_action('init' , 'guardar_BD');