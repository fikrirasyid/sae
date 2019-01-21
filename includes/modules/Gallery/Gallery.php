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
					'items' => array(
						'title'    => esc_html__( 'Gallery Items', 'sae' ),
						'priority' => 30,
					),
				),
			),
		);
		$this->advanced_fields         = array(
			'borders'      => array(
				'default'  => array(),
				'item'     => array(
					// UI
					'label_prefix'    => esc_html__( 'Gallery Item', 'sae' ),

					// CSS
					'css'             => array(
						'main' => array(
							'border_radii'        => "%%order_class%% .sae_gallery_item",
							'border_styles'       => "%%order_class%% .sae_gallery_item",
							'border_styles_hover' => "%%order_class%% .sae_gallery_item:hover",
						),
					),

					// Defaults
					'defaults'        => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#333333',
							'style' => 'solid',
						),
					),

					// Category & Location
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'items',
				),
			),
			'box_shadow'   => array(
				'default' => array(),
				'item'    => array(
					// UI
					'label'           => esc_html__( 'Gallery Item Box Shadow', 'sae' ),

					// CSS
					'css'             => array(
						'main'        => '%%order_class%% .sae_gallery_item',
					),

					// Defaults
					'default'         => 'none',

					// Category & Location
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'items',
				),
			),
			'link_options' => false,
		);
	}

	public function get_fields() {
		return array(
			// Layout
			'layout' => array(
				// UI
				'label'           => esc_html__( 'Gallery Layout', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'select',
				'options'         => array(
					'masonry'  => esc_html__( 'Masonry', 'sae' ),
					'plain'    => esc_html__( 'Plain', 'sae' ),
				),

				// Defaults
				'default'         => 'masonry',

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),

			// Column
			'column' => array(
				// UI
				'label'           => esc_html__( 'Gallery Column', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'range',
				'allow_empty'     => false,
				'mobile_options'  => true,
				'range_settings'  => array(
					'min'       => 1,
					'max'       => 10,
					'min_limit' => 1,
					'max_limit' => 10,
					'step'      => 1,
				),
				'responsive'      => true,
				'validate_unit'   => false,

				// Defaults
				'default'         => 3,

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'column',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'masonry',
					),
				),
			),
			'column_gutter_width' => array(
				// UI
				'label'           => esc_html__( 'Gallery Column Gutter Width', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'range',
				'allow_empty'     => true,
				'mobile_options'  => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'responsive'      => true,
				'validate_unit'   => true,

				// Defaults
				'default'         => '',
				'default_unit'    => 'px',

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'column',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'masonry',
					),
				),
				'show_if_not'     => array(
					'column' => '1',
				),
			),

			// Gallery Items
			'item_background' => array(
				//
				'label'             => esc_html__( 'Item Background', 'sae' ),
				'description'       => esc_html__( '', 'sae' ),

				// Settings
				'type'              => 'background-field',
				'base_name'         => 'item_background',
				'context'           => 'item_background',
				'custom_color'      => true,
				'background_fields' => $this->generate_background_options(
					'item_background',
					// Intentionally use color, gradient, and image ala button background
					// only to keep things simple
					'button',
					'advanced',
					'layout',
					'item_background'
				),

				// Category & Location
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'items',
			),
			'item_padding'    => array(
				// UI
				'label'           => esc_html__( 'Gallery Item Padding', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'responsive'      => true,

				// Defaults

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'items',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'plain',
						'masonry',
					),
				),
			),
			'item_margin'     => array(
				// UI
				'label'           => esc_html__( 'Gallery Item Margin', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'responsive'      => true,

				// Defaults

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'items',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'plain',
						'masonry',
					),
				),
			),
		);
	}

	public function set_css( $render_slug ) {
		$has_column_gutter_width = '' !== $this->props['column_gutter_width'];
		$column                  = intval( $this->props['column'] );

		// Masonry layout style
		if ( 'masonry' === $this->props['layout'] ) {
			// Column
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .sae-gallery-wrapper',
				'declaration' => sprintf(
					'-webkit-column-count: %1$s;
					-moz-column-count: %1$s;
					column-count: %1$s;',
					esc_html( $column )
				),
			) );

			// Column Gutter Width
			if ( $has_column_gutter_width ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '%%order_class%% .sae-gallery-wrapper',
					'declaration' => sprintf(
						'-webkit-column-gap: %1$s;
						-moz-column-gap: %1$s;
						column-gap: %1$s;',
						esc_html( $this->props['column_gutter_width'] )
					),
				) );
			}
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
		if ( in_array( $this->props['layout'], array( 'masonry' ) ) ) {
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
