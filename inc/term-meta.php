<?php
/*
 * Term Layouts
 */

if ( untoldstories_term_meta_supported() ) {
	add_action( 'category_add_form_fields', 'untoldstories_term_meta_image_add', 10 );
	add_action( 'category_edit_form_fields', 'untoldstories_term_meta_image_edit', 10, 2 );
}

if( ! function_exists( 'untoldstories_term_meta_image_add' ) ):
function untoldstories_term_meta_image_add( $taxonomy ) {
	?>
	<div class="form-field term-image-wrap">
		<label for="ci-term-meta-image"><?php esc_html_e( 'Image', 'untold-stories' ); ?></label>
		<div class="untoldstories-upload-preview">
			<div class="upload-preview"></div>
			<input type="hidden" class="untoldstories-uploaded-id" name="untoldstories_term_image" value="" />
			<input id="ci-term-meta-image" type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
		</div>
	</div>
	<?php
}
endif;

if( ! function_exists( 'untoldstories_term_meta_image_edit' ) ):
function untoldstories_term_meta_image_edit( $term, $taxonomy ) {
	$image_id = get_term_meta( $term->term_id, 'image_id', true );
	?>
	<tr class="form-field term-image-wrap">
		<th scope="row"><label for="ci-term-meta-image"><?php esc_html_e( 'Image', 'untold-stories' ); ?></label></th>
		<td>
			<div class="untoldstories-upload-preview">
				<div class="upload-preview">
					<?php if ( ! empty( $image_id ) ): ?>
						<?php
							$image_url = untoldstories_get_image_src( $image_id, 'untoldstories_thumb_featgal_small_thumb' );
							echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
								esc_url( $image_url ),
								esc_attr( esc_html__( 'Remove image', 'untold-stories' ) )
							);
						?>
					<?php endif; ?>
				</div>
				<input type="hidden" class="untoldstories-uploaded-id" name="untoldstories_term_image" value="<?php echo esc_attr( $image_id ); ?>" />
				<input id="ci-term-meta-image" type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
			</div>
		</td>
	</tr>
	<?php
}
endif;


if ( untoldstories_term_meta_supported() ) {
	add_action( 'create_term', 'untoldstories_term_created_edited', 10, 3 );
	add_action( 'edit_term', 'untoldstories_term_created_edited', 10, 3 );
}

if( ! function_exists( 'untoldstories_term_created_edited' ) ):
function untoldstories_term_created_edited( $term_id, $tt_id, $taxonomy ) {
	$taxonomies = array(
		'category',
	);

	if ( in_array( $taxonomy, $taxonomies ) && isset( $_POST['untoldstories_term_image'] ) ) {
		update_term_meta( $term_id, 'image_id', untoldstories_sanitize_intval_or_empty( $_POST['untoldstories_term_image'] ) );
	}
}
endif;
