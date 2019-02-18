<?php

class SAE_Gallery extends SAE_Builder_Module {
	public $slug                 = 'sae_gallery';
	public $vb_support           = 'on';
	public $main_css_element     = '%%order_class%%';

	protected $module_credits = array(
		'module_uri' => 'https://github.com/fikrirasyid/sae',
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
					'caption' => array(
						'title'    => esc_html__( 'Caption', 'sae' ),
						'priority' => 40,
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
							'border_radii'        => "{$this->main_css_element} .sae_gallery_item",
							'border_styles'       => "{$this->main_css_element} .sae_gallery_item",
							'border_styles_hover' => "{$this->main_css_element} .sae_gallery_item:hover",
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
				'caption' => array(
					// UI
					'label_prefix'    => esc_html__( 'Caption', 'sae' ),

					// CSS
					'css'             => array(
						'main' => array(
							'border_radii'        => "{$this->main_css_element} .sae-gallery-item-caption",
							'border_styles'       => "{$this->main_css_element} .sae-gallery-item-caption",
							'border_styles_hover' => "{$this->main_css_element} .sae-gallery-item-caption:hover",
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
					'toggle_slug'     => 'caption',
				),
			),
			'box_shadow'   => array(
				'default' => array(),
				'item'    => array(
					// UI
					'label'           => esc_html__( 'Gallery Item Box Shadow', 'sae' ),

					// CSS
					'css'             => array(
						'main'        => "{$this->main_css_element} .sae_gallery_item",
					),

					// Defaults
					'default'         => 'none',

					// Category & Location
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'items',
				),
				'caption' => array(
					// UI
					'label'           => esc_html__( 'Caption Box Shadow', 'sae' ),

					// CSS
					'css'             => array(
						'main' => "{$this->main_css_element} .sae-gallery-item-caption",
					),

					// Defaults
					'defaults'        => 'none',

					// Category & Location
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'caption',
				),
			),
			'fonts'        => array(
				'caption'  => array(
					'label' => esc_html__( 'Title', 'et_builder' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .sae-gallery-item-caption"
					),
				),
			),
			'link_options' => false,
			'text'         => array(
				'use_text_orientation'  => false,
			),
			'text_shadow' => array(
				'default' => false,
			),
		);
	}

	public function get_fields() {
		$fields = array(
			// Layout
			'layout' => array(
				// UI
				'label'           => esc_html__( 'Gallery Layout', 'sae' ),
				'description'     => esc_html__( 'Set layout type used by the gallery.', 'sae' ),

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
				'description'     => esc_html__( 'Set number of column used by the gallery.', 'sae' ),

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
				'description'     => esc_html__( 'Set gutter width of the gallery column.', 'sae' ),

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
			'item_background_color' => array(
				// UI
				'label'             => esc_html__( 'Item Background', 'sae' ),
				'description'       => esc_html__( 'Set background for gallery item. ', 'sae' ),

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
				'description'     => esc_html__( 'Set padding for gallery item.', 'sae' ),

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
				'description'     => esc_html__( 'Set padding for gallery item.', 'sae' ),

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

			// Caption
			'caption_position' => array(
				// UI
				'label'           => esc_html__( 'Caption Position', 'sae' ),
				'description'     => esc_html__( 'Set position of the gallery caption.', 'sae' ),

				// Settings
				'type'            => 'select',
				'options'         => array(
					'below'   => esc_html__( 'Below', 'sae' ),
					'overlay' => esc_html__( 'Overlay', 'sae' ),
					'hidden'  => esc_html__( 'No Caption', 'sae' ),
				),

				// Defaults
				'default'         => 'below',

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'caption',
			),

			'caption_background_color' => array(
				// UI
				'label'             => esc_html__( 'Caption Background', 'sae' ),
				'description'       => esc_html__( 'Set background of gallery caption.', 'sae' ),

				// Settings
				'type'              => 'background-field',
				'base_name'         => 'caption_background',
				'context'           => 'caption_background',
				'custom_color'      => true,
				'background_fields' => $this->generate_background_options(
					'caption_background',
					// Intentionally use color, gradient, and image ala button background
					// only to keep things simple
					'button',
					'advanced',
					'layout',
					'caption_background'
				),

				// Category & Location
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'caption',
			),
			'caption_padding'    => array(
				// UI
				'label'           => esc_html__( 'Caption Padding', 'sae' ),
				'description'     => esc_html__( 'Set padding of gallery caption.', 'sae' ),

				// Settings
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'responsive'      => true,

				// Defaults
				'default'         => '10px|10px|10px|10px',

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'caption',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'plain',
						'masonry',
					),
				),
			),
			'caption_margin'     => array(
				// UI
				'label'           => esc_html__( 'Caption Margin', 'sae' ),
				'description'     => esc_html__( 'Set margin of gallery caption.', 'sae' ),

				// Settings
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'responsive'      => true,

				// Defaults

				// Category & Location
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'caption',

				// Visibility
				'show_if'         => array(
					'layout'      => array(
						'plain',
						'masonry',
					),
				),
			),
		);

		// background-field's fields need to be manually added as `skip` type of field so its value
		// can be properly saved and fetched
		$fields = array_merge(
			$fields,
			$this->generate_background_options(
				'item_background',
				// Intentionally use color, gradient, and image ala button background
				// only to keep things simple
				'skip',
				'advanced',
				'layout',
				'item_background'
			),
			$this->generate_background_options(
				'caption_background',
				// Intentionally use color, gradient, and image ala button background
				// only to keep things simple
				'skip',
				'advanced',
				'layout',
				'caption_background'
			)
		);

		return $fields;
	}

	/**
	 * Set custom CSS
	 *
	 * @since 0.1
	 *
	 * @param string $render_slug
	 */
	public function sae_set_css( $render_slug ) {
		$has_column_gutter_width = '' !== $this->props['column_gutter_width'];
		$column                  = intval( $this->props['column'] );

		// SELECTORS
		$gallery_wrapper_selector = "{$this->main_css_element} .sae-gallery-wrapper";
		$gallery_item_selector    = "{$this->main_css_element} .sae_gallery_item";
		$gallery_caption_selector = "{$this->main_css_element} .sae-gallery-item-caption";

		// GALLERY WRAPPER
		// Masonry layout style
		if ( 'masonry' === $this->props['layout'] ) {
			// GALLERY WRAPPER - Column
			$this->sae_set_field_css(
				$render_slug,
				'range',
				'column',
				$gallery_wrapper_selector,
				'column-count',
				true
			);

			// GALLERY WRAPPER - Column Gap / Gutter Width
			$this->sae_set_field_css(
				$render_slug,
				'range',
				'column_gutter_width',
				$gallery_wrapper_selector,
				'column-gap',
				true
			);
		}

		// GALLERY ITEM
		// GALLERY ITEM - Background
		$this->sae_set_field_css(
			$render_slug,
			'background',
			'item_background',
			$gallery_item_selector,
			'',
			false
		);

		// GALLERY ITEM - Margin
		$this->sae_set_field_css(
			$render_slug,
			'margin',
			'item',
			$gallery_item_selector,
			'',
			false
		);

		// GALLERY ITEM - Padding
		$this->sae_set_field_css(
			$render_slug,
			'padding',
			'item',
			$gallery_item_selector,
			'',
			false
		);

		// CAPTION
		// CAPTION - Background
		$this->sae_set_field_css(
			$render_slug,
			'background',
			'caption_background',
			$gallery_caption_selector,
			'',
			false
		);

		// CAPTION - Margin
		$this->sae_set_field_css(
			$render_slug,
			'margin',
			'caption',
			$gallery_caption_selector,
			'',
			false
		);

		// CAPTION - Padding
		$this->sae_set_field_css(
			$render_slug,
			'padding',
			'caption',
			$gallery_caption_selector,
			'',
			false
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		// Wrapper classnames
		$wrapper_classnames = array(
			'sae-gallery-wrapper',
			"sae-gallery-layout-{$this->props['layout']}",
			"sae-gallery-caption-{$this->props['caption_position']}"
		);

		// Wrapper data attributes
		$wrapper_data_attrs = array();

		// Column classnames & data attribute
		if ( in_array( $this->props['layout'], array( 'masonry' ) ) ) {
			array_push( $wrapper_classnames, "sae-gallery-column-{$this->props['column']}" );

			$wrapper_data_attrs['column'] = $this->props['column'];
		}

		// Set styles
		$this->sae_set_css( $render_slug );

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
			et_core_sanitized_previously( $rendered_data_attrs ),
			et_core_sanitized_previously( $this->content )
		);
	}
}

new SAE_Gallery;
