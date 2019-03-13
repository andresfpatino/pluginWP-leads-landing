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
    ?>  <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
                <title>Landing Page</title>  
                <?php $PATH = plugin_dir_url( __FILE__ );  ?>
                <link href="https://fonts.googleapis.com/css?family=Poppins:700|Raleway:300" rel="stylesheet">
                <link rel="stylesheet" href="<?php echo $PATH . 'css/bootstrap.css'; ?>"> 
                <link rel="stylesheet" href="<?php echo $PATH . 'css/main.css'; ?>">        
            </head>
            <body>
            <header id="header">
                <div class="container main-menu">
                    <div class="row align-items-center justify-content-between d-flex">
                        <div id="logo">
                            <a href="<?php echo get_home_url(); ?>">
                                <img src="<?php echo esc_html(get_option('logo')); ?>" width="150">
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="principal pt-100">
                <main class="container">  
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-5 col-md-5">  
                           <img class="img-fluid" src="<?php echo $PATH ?>img/mockup.png" alt="">
                        </div>

                        <div class="col-lg-7 col-md-7">   
                            <div class="info">
                            <h1 class="title"><?php echo esc_html(get_option('titulo')); ?></h1>
                            <p><?php echo esc_html(get_option('intro_txt')); ?></p>           
                                <form class="contacto" method="POST">
                                    <div class="form-row">
                                        <div class="col">
                                            <input class="form-control" type="text" name="nombre" placeholder="Nombres" required>
                                        </div>
                                        <div class="col">
                                            <input class="form-control" type="text" name="apellido" placeholder="Apellidos" required>                        
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <input class="form-control" type="emai" name="correo" placeholder="Correo" required>
                                        </div>
                                        <div class="col">
                                            <input class="form-control" type="tel" name="telefono" placeholder="Teléfono" required>
                                        </div>
                                    </div>
                                    <div class="campo">  
                                        <?php $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); ?>
                                        <input type="hidden" name="fecha" value="<?php echo date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ; ?>">
                                    </div>   
                                    <div class="form-row">  
                                        <div class="col">                               
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="politicas" required checked>
                                                <label class="custom-control-label" for="politicas"> Acepto las <a target="_blank" href="<?php echo esc_html(get_option('link_politicas')); ?>">políticas de privacidad</a> </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <input type="submit" name="enviar" class="button" value="Solicitar información">
                                        </div>
                                    </div>
                                    <input type="hidden" name="oculto" value="1"> 
                                    <!-- Mensaje gracias-->
                                    <?php if (isset($_POST['enviar']) && $_POST['oculto'] == "1"){ 
                                        $nombre = sanitize_text_field( $_POST['nombre']);
                                        $mensaje = esc_html(get_option('thanks_page')); ?>
                                        <div class="form-row">
                                            <div class="alert alert-success fade show" role="alert">
                                              <strong><?php echo $nombre . ', '?></strong> <?php echo $mensaje ?>
                                            </div>
                                        </div>
                                    <?php }  ?>
                                </form>
                            </div>                   
                        </div>  
                    </div>
                </main>
                <footer>
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <p>Todos los derechos reservados &reg; <?php echo date("Y"); ?>, <a href="http://felipepatino.com/" target="_blank">Andrés Felipe Patiño</a> </p>
                        </div>
                    </div>
                </footer>
            </div>
                
        </body>
        </html>
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
                $fecha = sanitize_text_field( $_POST['fecha']);

                $tabla = $wpdb->prefix.'leads';
                $datos = array(
                    'nombre'    => $nombre,
                    'apellido'     => $apellido,
                    'correo'    => $correo,
                    'telefono'  => $telefono,
                    'fecha'  => $fecha
                );
                
                $formato = array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                );
                $wpdb->insert($tabla, $datos, $formato);   
            } 
        endif;
    } add_action('init' , 'guardar_BD');