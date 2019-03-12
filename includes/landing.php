<?php 

// Write a new permalink entry on code activation
register_activation_hook( __FILE__, 'customop_activation' );
function customop_activation() {
        customop_custom_output();
        flush_rewrite_rules(); // Update the permalink entries in the database, so the permalink structure needn't be redone every page load
}

// If the plugin is deactivated, clean the permalink structure
register_deactivation_hook( __FILE__, 'customop_deactivation' );
function customop_deactivation() {
        flush_rewrite_rules();
}


// This code create a new permalink entry
add_action( 'init', 'customop_custom_output' );
function customop_custom_output() {
        add_rewrite_tag( '%leads-cliente-x%', '([^/]+)' );
        add_permastruct( 'leads-cliente-x', '/%leads-cliente-x%' );
}

// The following controls the output content
add_action( 'template_redirect', 'customop_display' );
function customop_display() {
        if ($query_var = get_query_var('leads-cliente-x')) {

?>  



        <div class="principal contenedor contacto">
            <main class="contenido-paginas">               
                <form class="reserva-contacto" method="POST">
                     <h2>Realiza una reservación</h2>
                    <div class="campo">
                        <input type="text" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="campo">
                        <input type="datetime-local" name="fecha" placeholder="Fecha" required>                        
                    </div>
                    <div class="campo">
                        <input type="emai" name="correo" placeholder="Correo" required>
                    </div>
                    <div class="campo">
                        <input type="tel" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="campo">
                        <textarea name="mensaje" placeholder="Mensaje" required></textarea>
                    </div>

                    <input type="submit" name="enviar" class="button" value="Reservar">
                    <input type="hidden" name="oculto" value="1">
                </form>
            </main>
        </div>



<?php 

                exit; 
        }
}