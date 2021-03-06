<?php 

// registrar opciones, una por campo
function settings_leads(){	
	register_setting('opciones_grupo', 'logo');
	register_setting('opciones_grupo', 'titulo');
	register_setting('opciones_grupo', 'intro_txt');
	register_setting('opciones_grupo', 'thanks_page');
	register_setting('opciones_grupo', 'link_politicas');
}

/* Pagina settings */
function settings(){ ?>
	<div class="wrap">	
		<h1>Configuraciones</h1>
		<hr>
		<p>Desde esta sección usted podrá configurar:</p>

		<form action="options.php" method="POST">

			<?php settings_fields('opciones_grupo'); ?>
			<?php do_settings_sections('opciones_grupo'); ?>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Logo</th>
					<td>
						<input size="53" type="text" name="logo" value="<?php echo esc_attr(get_option('logo')); ?>">
						<button class="button upload-button">Seleccione una imagen</button>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">Título</th>
					<td><input size="80" type="text" name="titulo" value="<?php echo esc_attr(get_option('titulo')); ?>" placeholder="Ingrese el texto"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Intro texto</th>
					<td><input size="80" type="text" name="intro_txt" value="<?php echo esc_attr(get_option('intro_txt')); ?>" placeholder="Ingrese el texto"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Link políticas</th>
					<td><input size="80" type="text" name="link_politicas" value="<?php echo esc_attr(get_option('link_politicas')); ?>" placeholder="Ingrese la URL"></td>
				</tr>
				<tr valign="top">
					<th scope="row">Texto de agradecimiento</th>
					<td><input size="80" type="text" name="thanks_page" value="<?php echo esc_attr(get_option('thanks_page')); ?>" placeholder="Ingrese el texto"></td>
				</tr>
			</table>
			
			<?php submit_button(); ?>	

		</form>
	</div>
	<?php	
}