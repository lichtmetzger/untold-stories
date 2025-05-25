<?php
	add_action( 'admin_init', 'untoldstories_cpt_post_add_metaboxes' );
	add_action( 'save_post', 'untoldstories_cpt_post_update_meta' );

	function untoldstories_cpt_post_add_metaboxes() {
		add_meta_box( 'untoldstories-layout-box', esc_html__( 'Post Utilities', 'untold-stories' ), 'untoldstories_add_cpt_post_layout_meta_box', 'post', 'normal', 'high' );
		add_meta_box( 'untoldstories-gallery-box', esc_html__( 'Gallery Details', 'untold-stories' ), 'untoldstories_add_cpt_post_gallery_meta_box', 'post', 'normal', 'high' );
	}

	function untoldstories_cpt_post_update_meta( $post_id ) {

		if ( ! untoldstories_can_save_meta( 'post' ) ) {
			return;
		}

		update_post_meta( $post_id, 'layout', in_array( $_POST['layout'], array( 'sidebar', 'full' ) ) ? $_POST['layout'] : '' );
		update_post_meta( $post_id, 'secondary_featured_id', intval( $_POST['secondary_featured_id'] ) );
		update_post_meta( $post_id, 'gallery_layout', in_array( $_POST['gallery_layout'], array( 'tiled', 'slider' ) ) ? $_POST['gallery_layout'] : '' );
		untoldstories_metabox_gallery_save( $_POST );

	}

	function untoldstories_add_cpt_post_layout_meta_box( $object, $box ) {
		untoldstories_prepare_metabox( 'post' );

		?><div class="untoldstories-cf-wrap"><?php
			untoldstories_metabox_open_tab( esc_html__( 'Layout', 'untold-stories' ) );
				$options = array(
					'sidebar' => esc_html_x( 'With sidebar', 'post layout', 'untold-stories' ),
					'full'    => esc_html_x( 'Full width', 'post layout', 'untold-stories' ),
				);
				untoldstories_metabox_dropdown( 'layout', $options, esc_html__( 'Post layout:', 'untold-stories' ) );
			untoldstories_metabox_close_tab();

			untoldstories_metabox_open_tab( esc_html__( 'Secondary image', 'untold-stories' ) );
				untoldstories_metabox_guide( esc_html__( 'The Looks page template uses images in portrait (tall) orientation. If the Featured Image of this post is in landscape (wide) orientation, you may want to provide a portrait image to be used instead, otherwise an automatically cropped image (based on the Featured Image) will be used.', 'untold-stories' ) );

				$secondary_featured_id = get_post_meta( $object->ID, 'secondary_featured_id', true );
				?>
				<div class="untoldstories-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $secondary_featured_id ) ): ?>
							<?php
								$image_url = untoldstories_get_image_src( $secondary_featured_id, 'untoldstories_thumb_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( esc_html__('Remove image', 'untold-stories') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="untoldstories-uploaded-id" name="secondary_featured_id" value="<?php echo esc_attr( $secondary_featured_id ); ?>" />
					<input type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
				</div>
				<?php
			untoldstories_metabox_close_tab();
		?></div><?php

	}

	function untoldstories_add_cpt_post_gallery_meta_box( $object, $box ) {
		untoldstories_prepare_metabox( 'post' );

		?><div class="untoldstories-cf-wrap"><?php
			untoldstories_metabox_open_tab( '' );
				$options = array(
					'tiled' => esc_html_x( 'Tiled', 'gallery layout', 'untold-stories' ),
					'slider'  => esc_html_x( 'Slider', 'gallery layout', 'untold-stories' ),
				);
				untoldstories_metabox_dropdown( 'gallery_layout', $options, esc_html__( 'Gallery layout:', 'untold-stories' ) );

				untoldstories_metabox_gallery();
			untoldstories_metabox_close_tab();
		?></div><?php

		untoldstories_bind_metabox_to_post_format( 'untoldstories-gallery-box', 'gallery' );
	}
