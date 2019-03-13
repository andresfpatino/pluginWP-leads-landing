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
						<input size="80" type="text" name="logo" value="<?php echo esc_attr(get_option('logo')); ?>" placeholder="Ingrese la URL"> <br>
						<small> Por favor, ingrese la url de la imagen deseada de la biblioteca de medios <small>
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




add_action( 'admin_footer', 'media_selector_print_scripts' );
function media_selector_print_scripts() {
	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#image_attachment_id' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php
}

