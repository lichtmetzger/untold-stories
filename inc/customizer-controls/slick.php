<?php
/**
 * Customize Slick Slider Control class.
 *
 * @see WP_Customize_Control
 */
class Untoldstories_Customize_Slick_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'slick';

	/**
	 * Taxonomy for category dropdown.
	 *
	 * @access public
	 * @var string
	 */
	protected $options = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->options = $options;

		if ( ! isset( $args['settings'] ) ) {
			$manager->add_setting( $id . '_show', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$manager->add_setting( $id . '_term', array(
				'default'           => '',
				'sanitize_callback' => 'absint',
			) );
			$manager->add_setting( $id . '_postids', array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'sanitize_post_ids' ),
			) );
			$manager->add_setting( $id . '_limit', array(
				'default'           => 5,
				'sanitize_callback' => array( $this, 'sanitize_positive_or_minus_one' ),
			) );
			$manager->add_setting( $id . '_autoplay', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$manager->add_setting( $id . '_autoplaySpeed', array(
				'default'           => 3000,
				'sanitize_callback' => 'absint',
			) );
			$manager->add_setting( $id . '_fade', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$this->settings = array(
				'show'          => $id . '_show',
				'term'          => $id . '_term',
				'postids'       => $id . '_postids',
				'limit'         => $id . '_limit',
				'autoplay'      => $id . '_autoplay',
				'autoplaySpeed' => $id . '_autoplaySpeed',
				'fade'          => $id . '_fade',
			);
		}
		parent::__construct( $manager, $id, $args );
	}

	protected function render_content() {
		if ( ! empty( $this->label ) ) :
			?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
		endif;

		if ( ! empty( $this->description ) ) :
			?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		endif;

		?>
		<ul>
			<li>
				<label>
					<input type="checkbox" value="1" <?php $this->link( 'show' ); ?> <?php checked( $this->value( 'show' ), 1 ); ?> />
					<?php esc_html_e( 'Show slider.', 'untold-stories' ); ?>
				</label>
			</li>

			<li>
				<label>
					<input type="checkbox" value="1" <?php $this->link( 'autoplay' ); ?> <?php checked( $this->value( 'autoplay' ), 1 ); ?> />
					<?php esc_html_e( 'Auto slide.', 'untold-stories' ); ?>
				</label>
			</li>

			<li>
				<?php
					$options = wp_parse_args( $this->options, array(
						'taxonomy'          => 'category',
						'show_option_none'  => ' ',
						'selected'          => $this->value( 'term' ),
						'show_option_all'   => '',
						'orderby'           => 'id',
						'order'             => 'ASC',
						'show_count'        => 1,
						'hide_empty'        => 1,
						'child_of'          => 0,
						'exclude'           => '',
						'hierarchical'      => 1,
						'depth'             => 0,
						'tab_index'         => 0,
						'hide_if_empty'     => false,
						'option_none_value' => 0,
						'value_field'       => 'term_id',
					) );
					$options['echo'] = false;

					$dropdown = wp_dropdown_categories( $options );
					$dropdown = str_replace( '<select', '<select ' . $this->get_link( 'term' ), $dropdown );
					$dropdown = str_replace( "name='cat' id='cat' class='postform'", '', $dropdown );
					?><label><span class="customize-control-title"><?php esc_html_e( 'Source category', 'untold-stories' ); ?></span></label><?php
					echo $dropdown;
				?>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php esc_html_e( 'Post IDs', 'untold-stories' ); ?></span>
					<span class="description customize-control-description"><?php esc_html_e( 'You can optionally provide a comma separated list of post IDs. The specific posts will be shown, overriding the source category above. The limit number is still honoured however.', 'untold-stories' ); ?></span>
					<input type="text" value="<?php echo esc_attr( $this->value( 'postids' ) ); ?>" <?php $this->link( 'postids' ); ?> />
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php esc_html_e( 'Limit posts:', 'untold-stories' ); ?></span>
					<input type="number" min="-1" step="1" value="<?php echo esc_attr( $this->value( 'limit' ) ); ?>" <?php $this->link( 'limit' ); ?> />
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php esc_html_e( 'Slide change effect:', 'untold-stories' ); ?></span>
					<select <?php $this->link( 'fade' ); ?>>
						<option value="" <?php selected( $this->value( 'fade' ), '' ); ?>><?php _ex( 'Slide', 'slick slider slide effect', 'untold-stories' ); ?></option>
						<option value="1" <?php selected( $this->value( 'fade' ), 1 ); ?>><?php _ex( 'Fade', 'slick slider slide effect', 'untold-stories' ); ?></option>
					</select>
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php esc_html_e( 'Pause between slides (in milliseconds):', 'untold-stories' ); ?></span>
					<input type="number" min="100" step="100" value="<?php echo esc_attr( $this->value( 'autoplaySpeed' ) ); ?>" <?php $this->link( 'autoplaySpeed' ); ?> />
				</label>
			</li>
		</ul>
		<?php

	}

	public static function sanitize_post_ids( $input ) {
		$input = explode( ',', $input );
		if( $input === false ) {
			return '';
		}
		$input = array_map( 'trim', $input );
		$input = array_map( 'absint', $input );
		$input = implode( ',', $input );

		return $input;
	}

	public static function sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		}

		return '';
	}

	public static function sanitize_positive_or_minus_one( $input ) {
		if ( intval( $input ) > 0 ) {
			return intval( $input );
		}

		return - 1;
	}

}
