<?php 

// Imprime la información de las reservas
function leads_func(){	
	?>
	<div class="wrap">
		<h1>Datos de sus usuarios </h1>
		<hr>
		<p>Para ver la landing visite el siguiente 
			<a href="<?php echo get_home_url(); ?>/leads-cliente-x" target="_blank">link</a>. Para la correcta visualización por favor actualice los enlaces permanentes.
		</p>
		<br>
		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th class="manage-column">ID</th>
					<th class="manage-column">Nombres</th>
					<th class="manage-column">Apellidos</th>
					<th class="manage-column">Correo</th>
					<th class="manage-column">Teléfono</th>
					<th class="manage-column">Fecha de registro</th>
				</tr>
			</thead>
			<tbody>
				<?php
					global $wpdb;
					$tabla = $wpdb->prefix . 'leads';
					$registros = $wpdb->get_results("SELECT * FROM $tabla", ARRAY_A);

					foreach ($registros as $registro) {
				?>

				<tr>
					<td> <?php echo $registro['id'] ?> </td>
					<td> <?php echo $registro['nombre'] ?> </td>
					<td> <?php echo $registro['apellido'] ?> </td>
					<td> <?php echo $registro['correo'] ?> </td>
					<td> <?php echo $registro['telefono'] ?> </td>
					<td> <?php echo $registro['fecha'] ?> </td>
				<tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
	<?php

}




