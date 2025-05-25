<?php
	add_action( 'admin_init', 'untoldstories_cpt_page_add_metaboxes' );
	add_action( 'save_post', 'untoldstories_cpt_page_update_meta' );

	function untoldstories_cpt_page_add_metaboxes() {
		add_meta_box( 'untoldstories-tpl-looks-box', esc_html__( 'Looks Details', 'untold-stories' ), 'untoldstories_add_cpt_page_looks_meta_box', 'page', 'normal', 'high' );
	}

	function untoldstories_cpt_page_update_meta( $post_id ) {

		if ( ! untoldstories_can_save_meta( 'page' ) ) {
			return;
		}

		update_post_meta( $post_id, 'looks_base_category', intval( $_POST['looks_base_category'] ) );
		update_post_meta( $post_id, 'looks_posts_per_page', untoldstories_sanitize_intval_or_empty( $_POST['looks_posts_per_page'] ) );
		update_post_meta( $post_id, 'looks_layout', in_array( $_POST['looks_layout'], array( '2cols_side', '3cols_full' ) ) ? $_POST['looks_layout'] : '2cols_side' );
	}

	function untoldstories_add_cpt_page_looks_meta_box( $object, $box ) {
		untoldstories_prepare_metabox( 'page' );

		?><div class="untoldstories-cf-wrap"><?php
			untoldstories_metabox_open_tab( '' );

				$options = array(
					'2cols_side' => esc_html__( '2 Columns - With sidebar', 'untold-stories' ),
					'3cols_full' => esc_html__( '3 Columns - Full width', 'untold-stories' ),
				);
				untoldstories_metabox_dropdown( 'looks_layout', $options, esc_html__( 'Layout:', 'untold-stories' ), array( 'default' => '2cols_side' ) );

				$category = get_post_meta( $object->ID, 'looks_base_category', true );
				untoldstories_metabox_guide( esc_html__( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'untold-stories' ) );
				?><p><label for="base_looks_category"><?php esc_html_e( 'Base Looks category:', 'untold-stories' ); ?></label><?php
				wp_dropdown_categories( array(
					'taxonomy'          => 'category',
					'selected'          => $category,
					'id'                => 'looks_base_category',
					'name'              => 'looks_base_category',
					'show_option_none'  => ' ',
					'option_none_value' => 0,
					'hierarchical'      => 1,
					'show_count'        => 1,
				) );
				?><p><?php

				$allowed_html_array = array(
					'strong' => array(),
					'em' => array()
				);

				untoldstories_metabox_guide( sprintf( 	wp_kses(__( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <em>all items</em>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings > Reading</em>, currently set to <strong>%s items per page</strong>.', 'untold-stories' ), $allowed_html_array ), get_option( 'posts_per_page' ) ) );
				untoldstories_metabox_input( 'looks_posts_per_page', esc_html__( 'Items per page:', 'untold-stories' ) );

			untoldstories_metabox_close_tab();
		?></div><?php

		untoldstories_bind_metabox_to_page_template( 'untoldstories-tpl-looks-box', 'template-listing-looks.php' );
	}
