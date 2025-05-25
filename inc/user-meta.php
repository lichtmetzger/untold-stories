<?php
	add_action( 'show_user_profile', 'untoldstories_show_extra_profile_fields' );
	add_action( 'edit_user_profile', 'untoldstories_show_extra_profile_fields' );

	if ( ! function_exists( 'untoldstories_show_extra_profile_fields' ) ):
		function untoldstories_show_extra_profile_fields( $user ) {

			$networks = untoldstories_get_social_networks();
			?>
			<h3><?php esc_html_e( 'Author social networks', 'untold-stories' ); ?></h3>

			<table class="form-table">
				<?php foreach ( $networks as $network ) : ?>
					<tr>
						<th><label for="user_<?php echo esc_attr( $network['name'] ); ?>"><?php echo $network['label']; ?></label></th>

						<td>
							<input type="text" name="user_<?php echo esc_attr( $network['name'] ); ?>" id="user_<?php echo esc_attr( $network['name'] ); ?>"
							       value="<?php echo esc_attr( get_the_author_meta( 'user_' . $network['name'], $user->ID ) ); ?>"
							       class="regular-text"/><br/>
							<span class="description"><?php sprintf( esc_html__( 'Your %s profile URL', 'untold-stories' ), $network['label'] ); ?></span>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

			<h3><?php esc_html_e( 'Author signature', 'untold-stories' ); ?></h3>

			<table class="form-table">
				<tr>
					<th><label for="user_greeting_text"><?php esc_html_e( 'Greeting text', 'untold-stories' ); ?></label></th>
					<td>
						<input type="text" name="user_greeting_text" id="user_greeting_text"
						       value="<?php echo esc_attr( get_the_author_meta( 'user_greeting_text', $user->ID ) ); ?>"
						       class="regular-text"/><br/>
						<span class="description"><?php echo esc_html__( 'Provide a greeting (sign off) message that will be displayed right before your signature.', 'untold-stories' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="user_signature_text"><?php esc_html_e( 'Signature text', 'untold-stories' ); ?></label></th>
					<td>
						<input type="text" name="user_signature_text" id="user_signature_text"
						       value="<?php echo esc_attr( get_the_author_meta( 'user_signature_text', $user->ID ) ); ?>"
						       class="regular-text"/><br/>
						<span class="description"><?php echo esc_html__( 'Provide your text signature (e.g. your name). If you set a signature image below, this text will not be shown.', 'untold-stories' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="user_signature_image"><?php esc_html_e( 'Signature image', 'untold-stories' ); ?></label></th>
					<td>
						<?php $user_signature_image = get_the_author_meta( 'user_signature_image', $user->ID ); ?>
						<div class="untoldstories-upload-preview">
							<div class="upload-preview">
								<?php if ( ! empty( $user_signature_image ) ): ?>
									<?php
										$image_url = untoldstories_get_image_src( $user_signature_image, 'untoldstories_thumb_featgal_small_thumb' );
										echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
											$image_url,
											esc_attr( esc_html__('Remove image', 'untold-stories') )
										);
									?>
								<?php endif; ?>
							</div>
							<input type="hidden" class="untoldstories-uploaded-id" name="user_signature_image" value="<?php echo esc_attr( $user_signature_image ); ?>" />
							<input type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
						</div>
					</td>
				</tr>
			</table>
			<?php
		}
	endif;

	add_action( 'personal_options_update', 'untoldstories_save_extra_profile_fields' );
	add_action( 'edit_user_profile_update', 'untoldstories_save_extra_profile_fields' );

	if ( ! function_exists( 'untoldstories_save_extra_profile_fields' ) ):
		function untoldstories_save_extra_profile_fields( $user_id ) {
			if ( ! current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}

			$networks = untoldstories_get_social_networks();

			foreach ( $networks as $network ) {
				update_user_meta( $user_id, 'user_' . $network['name'], esc_url_raw( $_POST[ 'user_' . $network['name'] ] ) );
			}

			update_user_meta( $user_id, 'user_greeting_text', sanitize_text_field( $_POST['user_greeting_text'] ) );
			update_user_meta( $user_id, 'user_signature_text', sanitize_text_field( $_POST['user_signature_text'] ) );
			update_user_meta( $user_id, 'user_signature_image', intval( $_POST['user_signature_image'] ) );
		}
	endif;
