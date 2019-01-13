<?php

class SAE_Gallery extends ET_Builder_Module {

	public $slug       = 'sae_gallery';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Fikri Rasyid',
		'author_uri' => 'http://fikrirasy.id',
	);

	public function init() {
		$this->name                    = esc_html__( 'Sae Gallery', 'sae' );
		$this->plural                  = esc_html__( 'Sae Galleries', 'sae' );
		$this->child_slug              = 'sae_gallery_item';
		$this->child_item_text         = esc_html__( 'Gallery Item', 'sae' );
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'    => esc_html__( 'Content', 'sae' ),
						'priority' => 10,
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout' => array(
						'title'    => esc_html__( 'Layout', 'sae' ),
						'priority' => 10,
					),
					'column' => array(
						'title'    => esc_html__( 'Column', 'sae' ),
						'priority' => 20,
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'layout' => array(
				'label'           => esc_html__( 'Gallery Layout', 'sae' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'grid'     => esc_html__( 'Grid', 'sae' ),
					'masonry'  => esc_html__( 'Masonry', 'sae' ),
					'carousel' => esc_html__( 'Carousel', 'sae' ),
				),
				'default'         => 'grid',
				'description'     => esc_html__( '', 'sae' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
			'column' => array(
				'label'           => esc_html__( 'Gallery Column', 'sae' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'1' => esc_html__( '1', 'sae' ),
					'2' => esc_html__( '2', 'sae' ),
					'3' => esc_html__( '3', 'sae' ),
					'4' => esc_html__( '4', 'sae' ),
					'5' => esc_html__( '5', 'sae' ),
					'6' => esc_html__( '6', 'sae' ),
				),
				'default'         => '3',
				'description'     => esc_html__( '', 'sae' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'column',
				'show_if'         => array(
					'layout'      => array(
						'grid',
						'masonry',
					),
				),
			),
		);
	}

	public function set_css( $render_slug ) {
		// Masonry layout style
		if ( 'masonry' === $this->props['layout'] ) {
			// Column
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .sae-gallery-wrapper',
				'declaration' => sprintf(
					'-webkit-column-count: %1$s;
					-moz-column-count: %1$s;
					column-count: %1$s;',
					esc_html( $this->props['column'] )
				),
			) );
		}
	}

	public function render( $attrs, $content = null, $render_slug ) {
		// Wrapper classnames
		$wrapper_classnames = array(
			'sae-gallery-wrapper',
			"sae-gallery-layout-{$this->props['layout']}",
		);

		// Wrapper data attributes
		$wrapper_data_attrs = array();

		// Column classnames & data attribute
		if ( in_array( $this->props['layout'], array( 'grid', 'masonry' ) ) ) {
			array_push( $wrapper_classnames, "sae-gallery-column-{$this->props['column']}" );

			$wrapper_data_attrs['column'] = $this->props['column'];
		}

		// Set styles
		$this->set_css( $render_slug );

		// Rendered attributes
		$rendered_wrapper_classnames = implode( ' ', $wrapper_classnames );
		$rendered_data_attrs         = '';

		foreach ( $wrapper_data_attrs as $attr_name => $attr_value ) {
			$rendered_data_attrs .= sprintf(
				' data-sae-%1$s="%2$s"',
				esc_attr( $attr_name ),
				esc_attr( $attr_value )
			);
		}

		return sprintf(
			'<div class="%1$s"%2$s>%3$s</div>',
			esc_attr( $rendered_wrapper_classnames ),
			et_sanitized_previously( $rendered_data_attrs ),
			et_sanitized_previously( $this->content )
		);
	}
}

new SAE_Gallery;
