<?php 
// Imprime la información de las reservas
function leads_func(){	
	?>
	<div class="wrap">
		<h1>Datos de sus usuarios </h1>

		<div class="notice notice-warning">
			<p> Para ver la landing visite el siguiente 
				<a href="<?php echo get_home_url(); ?>/leads-cliente-x" target="_blank">link</a>.
				Si tiene problemas con la visualización por favor actualice los <a href="<?php echo get_admin_url(); ?>options-permalink.php">enlaces permanentes.</a>
			</p>
		</div>

		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th class="manage-column">ID</th>
					<th class="manage-column">Nombres</th>
					<th class="manage-column">Apellidos</th>
					<th class="manage-column">Correo</th>
					<th class="manage-column">Teléfono</th>
					<th class="manage-column">Fecha de registro</th>
					<th class="manage-column">Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<?php
					global $wpdb;

					$tabla = $wpdb->prefix . 'leads';

					$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
					$limit = 11; // limite de paginación
					$offset = ( $pagenum - 1 ) * $limit;
					$total = $wpdb->get_var( "SELECT COUNT('id') FROM $tabla" );
					$num_of_pages = ceil( $total / $limit );

					$entries = $wpdb->get_results( "SELECT * FROM $tabla LIMIT $offset, $limit" );

					foreach ($entries as $entry) {
				?>

				<tr>
					<td> <?php echo $entry->id; ?> </td>
					<td> <?php echo $entry->nombre; ?> </td>
					<td> <?php echo $entry->apellido; ?> </td>
					<td> <?php echo $entry->correo; ?> </td>
					<td> <?php echo $entry->telefono; ?> </td>
					<td> <?php echo $entry->fecha; ?> </td>
					<td>
						<a href="#" class="borrar_registro" data-registro="<?php echo $entry->id; ?>"> <span class="dashicons dashicons-trash"></span> Eliminar</a>
					</td>
				<tr>

				<?php } ?>

			</tbody>
		</table>

		<!-- paginación -->
		<?php 

			$page_links = paginate_links( array(
			    'base' => add_query_arg( 'pagenum', '%#%' ),
			    'format' => '',
			    'prev_text' => __( '&laquo;', 'text-domain' ),
			    'next_text' => __( '&raquo;', 'text-domain' ),
			    'total' => $num_of_pages,
			    'current' => $pagenum
			) );

			if ( $page_links ) {
			    echo '
			    	<div class="tablenav bottom">
			    		<div class="tablenav-pages" style="margin: 1em 0">
			    			<span class="pagination-links">
			    				<span class="tablenav-pages-navspan">' . $page_links . '</span>
			    			</span>
			    		</div>
			    	</div>
			    ';
			}

		?>
	</div>

	<?php
}