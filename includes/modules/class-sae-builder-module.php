<?php
/**
 * Base class for Sae modules. ET_Builder_Module with additional method to simplify style rendering
 *
 * @since 0.1
 */
class SAE_Builder_Module extends ET_Builder_Module {
	public $device_media_queries = array(
		'desktop_only' => 'min_width_981',
		'tablet'       => 'max_width_980',
		'phone'        => 'max_width_767',
	);

	/**
	 * Automatically process fields data into CSS settings
	 *
	 * @since 0.1
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
	public function sae_set_field_css( $render_slug, $field_type, $base_attr_name, $selector, $css_property = '', $add_browser_property = false ) {
		switch ( $field_type ) {
			case 'range':
				$this->sae_set_responsive_style(
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

						$this->sae_set_spacing_declaration(
							$field_type,
							$render_slug,
							$spacing_selector,
							$spacing_breakpoint,
							$breakpoint
						);
					}
				} else {
					$this->sae_set_spacing_declaration(
						$field_type,
						$render_slug,
						$spacing_selector,
						$spacing['desktop']
					);
				}
				break;
			case 'column_flex_grid':
				$column = array(
					'desktop' => self::$_->array_get( $this->props, $base_attr_name, '' ),
					'tablet'  => self::$_->array_get( $this->props, "{$base_attr_name}_tablet", '' ),
					'phone'   => self::$_->array_get( $this->props, "{$base_attr_name}_phone", '' ),
				);

				// Check responsive status
				$is_column_responsive = et_pb_get_responsive_status( self::$_->array_get(
					$this->props,
					"{$base_attr_name}_last_edited",
					''
				) );

				$is_column_gutter_responsive = et_pb_get_responsive_status( self::$_->array_get(
					$this->props,
					"column_gutter_width_last_edited",
					''
				) );

				foreach ( $column as $device => $value ) {
					if ( '' === $value || ! $is_column_responsive && 'desktop' !== $device ) {
						continue;
					}

					$column_gutter_width_attr = 'desktop' === $device || ! $is_column_gutter_responsive ?
						'column_gutter_width' : "column_gutter_width_{$device}";
					$column_gutter_width      = self::$_->array_get(
						$this->props,
						$column_gutter_width_attr,
						'0px'
					);
					$width                    = $column_gutter_width ?
						"calc( ( 100% / {$value} ) - {$column_gutter_width} )" :
						"calc( 100% / {$value} )";
					$declaration              = sprintf(
						'width: %1$s; margin-left: calc( %2$s / 2 ); margin-right: calc( %2$s / 2 );',
						esc_html( $width ),
						esc_html( $column_gutter_width )
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

				break;
			default:
				break;
		}
	}

	/**
	 * Set responsive style based on known responsive attribute structure
	 *
	 * @since 0.1
	 *
	 * @param string $render_slug
	 * @param string $base_attr
	 * @param string $selector
	 * @param string $property
	 * @param bool   $render_browser_vendor_prefix
	 */
	public function sae_set_responsive_style( $render_slug, $base_attr, $selector, $property, $render_browser_vendor_prefix = false ) {
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
	 * @since 0.1
	 *
	 * @param string      $type
	 * @param string      $render_slug
	 * @param string      $selector
	 * @param string      $attr_value
	 * @param string|bool $breakpoint
	 */
	public function sae_set_spacing_declaration( $type = 'margin', $render_slug, $selector, $attr_value, $breakpoint = false ) {
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
}
