<?php

class SAE_Gallery extends ET_Builder_Module {

	public $slug                 = 'sae_gallery';
	public $vb_support           = 'on';
	public $device_media_queries = array(
		'desktop_only' => 'min_width_981',
		'tablet'       => 'max_width_980',
		'phone'        => 'max_width_767',
	);

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
				'caption' => array(
					// UI
					'label_prefix'    => esc_html__( 'Caption', 'sae' ),

					// CSS
					'css'             => array(
						'main' => array(
							'border_radii'        => "%%order_class%% .sae-gallery-item-caption",
							'border_styles'       => "%%order_class%% .sae-gallery-item-caption",
							'border_styles_hover' => "%%order_class%% .sae-gallery-item-caption:hover",
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
						'main'        => '%%order_class%% .sae_gallery_item',
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
						'main' => '%%order_class%% .sae-gallery-item-caption',
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
						'main' => "%%order_class%% .sae-gallery-item-caption"
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
			'item_background_color' => array(
				// UI
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

			// Caption
			'caption_background_color' => array(
				// UI
				'label'             => esc_html__( 'Caption Background', 'sae' ),
				'description'       => esc_html__( '', 'sae' ),

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
				'description'     => esc_html__( '', 'sae' ),

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
				'description'     => esc_html__( '', 'sae' ),

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

	public function set_css( $render_slug ) {
		$has_column_gutter_width = '' !== $this->props['column_gutter_width'];
		$column                  = intval( $this->props['column'] );

		// SELECTORS
		$gallery_wrapper_selector = '%%order_class%% .sae-gallery-wrapper';
		$gallery_item_selector    = '%%order_class%% .sae_gallery_item';
		$gallery_caption_selector = '%%order_class%% .sae-gallery-item-caption';

		// GALLERY WRAPPER
		// Masonry layout style
		if ( 'masonry' === $this->props['layout'] ) {
			// GALLERY WRAPPER - Column
			$this->set_field_css(
				$render_slug,
				'range',
				'column',
				$gallery_wrapper_selector,
				'column-count',
				true
			);

			// GALLERY WRAPPER - Column Gap / Gutter Width
			$this->set_field_css(
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
		$this->set_field_css(
			$render_slug,
			'background',
			'item_background',
			$gallery_item_selector,
			'',
			false
		);

		// GALLERY ITEM - Margin
		$this->set_field_css(
			$render_slug,
			'margin',
			'item',
			$gallery_item_selector,
			'',
			false
		);

		// GALLERY ITEM - Padding
		$this->set_field_css(
			$render_slug,
			'padding',
			'item',
			$gallery_item_selector,
			'',
			false
		);

		// CAPTION
		// CAPTION - Background
		$this->set_field_css(
			$render_slug,
			'background',
			'caption_background',
			$gallery_caption_selector,
			'',
			false
		);

		// CAPTION - Margin
		$this->set_field_css(
			$render_slug,
			'margin',
			'caption',
			$gallery_caption_selector,
			'',
			false
		);

		// CAPTION - Padding
		$this->set_field_css(
			$render_slug,
			'padding',
			'caption',
			$gallery_caption_selector,
			'',
			false
		);
	}

	/**
	 * Automatically process fields data into CSS settings
	 *
	 * @since ??
	 *
	 * @param string $render_slug
	 * @param string $field_type
	 * @param string $base_attr_name
	 * @param string $selector
	 * @param string $css_property
	 * @param string $add_browser_property
	 *
	 * @return void
	 */
	public function set_field_css( $render_slug, $field_type, $base_attr_name, $selector, $css_property = '', $add_browser_property = false ) {
		switch ( $field_type ) {
			case 'range':
				$this->set_responsive_style(
					$render_slug,
					$base_attr_name,
					$selector,
					$css_property,
					true
				);
				break;

			case 'background':
				$background_color        = self::$_->array_get( $this->props, "{$base_attr_name}_color" );
				$background_gradient_use = self::$_->array_get( $this->props, "{$base_attr_name}_use_color_gradient", 'off' );
				$background_image        = self::$_->array_get( $this->props, "{$base_attr_name}_image" );
				$background_images       = array();

				// Background color
				if ($background_color) {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $selector,
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $background_color )
						),
					) );
				}

				// Prepare gallery item background gradient styles
				if ( 'on' === $background_gradient_use ) {
					$background_images[] = $this->get_gradient( array(
						'type'             => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_type" ),
						'direction'        => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_direction" ),
						'radial_direction' => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_direction_radial" ),
						'color_start'      => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_start" ),
						'color_end'        => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_end" ),
						'start_position'   => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_start_position" ),
						'end_position'     => self::$_->array_get( $this->props, "{$base_attr_name}_color_gradient_end_position" ),
					) );
				}

				// Prepare & add gallery item background image styles
				if ( $background_image ) {
					$background_images[] = "url({$background_image})";

					$background_size     = self::$_->array_get( $this->props, "{$base_attr_name}_size" );
					$background_position = self::$_->array_get( $this->props, "{$base_attr_name}_position", '' );
					$background_repeat   = self::$_->array_get( $this->props, "{$base_attr_name}_repeat" );
					$background_blend    = self::$_->array_get( $this->props, "{$base_attr_name}_blend" );

					if ($background_size) {
						ET_Builder_Element::set_style( $render_slug, array(
							'selector'    => $selector,
							'declaration' => sprintf(
								'background-size: %1$s; ',
								esc_html( $background_size )
							),
						) );
					}

					if ($background_position) {
						ET_Builder_Element::set_style( $render_slug, array(
							'selector'    => $selector,
							'declaration' => sprintf(
								'background-position: %1$s; ',
								esc_html( str_replace( '_', ' ', $background_position ) )
							),
						) );
					}

					if ($background_repeat) {
						ET_Builder_Element::set_style( $render_slug, array(
							'selector'    => $selector,
							'declaration' => sprintf(
								'background-repeat: %1$s; ',
								esc_html( $background_repeat )
							),
						) );
					}

					if ($background_blend) {
						ET_Builder_Element::set_style( $render_slug, array(
							'selector'    => $selector,
							'declaration' => sprintf(
								'background-blend-mode: %1$s; ',
								esc_html( $background_blend )
							),
						) );
					}

					// Background image and gradient exist
					if ( count( $background_images ) > 1 && $background_blend && 'normal' !== $background_blend ) {
						ET_Builder_Element::set_style( $render_slug, array(
							'selector'    => $selector,
							'declaration' => 'background-color: initial; ',
						) );
					}
				}

				// Add gallery item background gradient and image styles (both uses background-image property)
				if ( ! empty( $background_images ) ) {
					if ('on' !== self::$_->array_get( $this->props, "${base_attr_name}_color_gradient_overlays_image" ) ) {
						array_reverse( $background_images );
					}

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $selector,
						'declaration' => sprintf(
							'background-image: %1$s; ',
							esc_html( join( ', ', $background_images ) )
						),
					) );
				}
				break;

			case 'margin':
			case 'padding':
				$spacing_selector = 'margin' === $field_type ? ".et_pb_gutter .et_pb_column {$selector}" : $selector;

				$spacing = array(
					'desktop' => self::$_->array_get( $this->props, "{$base_attr_name}_{$field_type}", '' ),
					'tablet'  => self::$_->array_get( $this->props, "{$base_attr_name}_{$field_type}_tablet", '' ),
					'phone'   => self::$_->array_get( $this->props, "{$base_attr_name}_{$field_type}_phone", '' ),
				);

				// Check responsive status
				$is_spacing_responsive = et_pb_get_responsive_status( self::$_->array_get(
					$this->props,
					"{$base_attr_name}_{$field_type}_last_edited",
					''
				) );

				if ( $is_spacing_responsive ) {
					foreach ( $spacing as $breakpoint => $spacing_breakpoint ) {
						if ( ! $spacing_breakpoint || '||||' === substr( $spacing_breakpoint, 0, 4 ) ) {
							continue;
						}

						$this->set_spacing_declaration(
							$field_type,
							$render_slug,
							$spacing_selector,
							$spacing_breakpoint,
							$breakpoint
						);
					}
				} else {
					$this->set_spacing_declaration(
						$field_type,
						$render_slug,
						$spacing_selector,
						$spacing['desktop']
					);
				}
				break;

			default:
				break;
		}
	}

	/**
	 * Set responsive style based on known responsive attribute structure
	 *
	 * @since ??
	 *
	 * @param string $render_slug
	 * @param string $base_attr
	 * @param string $selector
	 * @param string $property
	 * @param bool   $render_browser_vendor_prefix
	 */
	public function set_responsive_style( $render_slug, $base_attr, $selector, $property, $render_browser_vendor_prefix = false ) {
		$last_edited   = self::$_->array_get( $this->props, "{$base_attr}_last_edited", '' );
		$is_responsive = et_pb_get_responsive_status( $last_edited );
		$values        = array(
			'desktop' => self::$_->array_get( $this->props, $base_attr, '' ),
			'tablet'  => $is_responsive ? self::$_->array_get( $this->props, "{$base_attr}_tablet", '' ) : '',
			'phone'   => $is_responsive ? self::$_->array_get( $this->props, "{$base_attr}_phone", '' ) : '',
		);

		// Loop the responsive values
		foreach ( $values as $device => $value ) {
			if ( '' === $value ) {
				continue;
			}

			// Concatenate style declaration
			$declaration = '';

			// Browser's vendor prefix based style has to come first
			if ( $render_browser_vendor_prefix ) {
				$declaration .= sprintf( '-webkit-%1$s: %2$s;-moz-%1$s: %2$s;',
					$property,
					$value
				);
			}

			$declaration .= sprintf( '%1$s: %2$s;',
				$property,
				$value
			);

			// Prepare the style
			$style = array(
				'selector'    => $selector,
				'declaration' => $declaration,
			);

			// If related media query related to current device is found, use it
			if ( isset( $this->device_media_queries[ $device ] ) ) {
				$style['media_query'] = ET_Builder_Element::get_media_query( $this->device_media_queries[ $device ] );
			}

			ET_Builder_Element::set_style( $render_slug, $style );
		}
	}

	/**
	 * Set margin/padding declaration based on attribute values
	 *
	 * @since ??
	 *
	 * @param string      $type
	 * @param string      $render_slug
	 * @param string      $selector
	 * @param string      $attr_value
	 * @param string|bool $breakpoint
	 */
	public function set_spacing_declaration( $type = 'margin', $render_slug, $selector, $attr_value, $breakpoint = false ) {
		$values        = explode( '|', $attr_value );
		$corners       = array( 'top', 'right', 'bottom', 'left' );

		if ( ! empty( $values ) ) {
			foreach ( $values as $index => $value ) {
				// Corners value are defined on first - fourth attributes
				if ( ! isset( $value ) || '' === $value || $index > 3 ) {
					continue;
				}

				$styles = array(
					'selector'    => $selector,
					'declaration' => sprintf(
						'%1$s-%2$s: %3$s;',
						esc_attr( $type ),
						esc_attr( $corners[ $index ] ),
						esc_html( $value )
					),
				);

				if ( $breakpoint && isset( $this->device_media_queries[ $breakpoint ] ) ) {
					$media_query = $this->device_media_queries[ $breakpoint ];
					$styles['media_query'] = ET_Builder_Element::get_media_query( $media_query );
				}

				ET_Builder_Element::set_style( $render_slug, $styles );
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
			et_core_sanitized_previously( $rendered_data_attrs ),
			et_core_sanitized_previously( $this->content )
		);
	}
}

new SAE_Gallery;
