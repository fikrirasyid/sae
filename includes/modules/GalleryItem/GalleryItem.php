<?php

class SAE_GalleryItem extends SAE_Builder_Module {
	public $slug                     = 'sae_gallery_item';
	public $type                     = 'child';
	public $child_title_var          = 'caption';
	public $child_title_fallback_var = 'admin_label';
	public $vb_support               = 'on';
	public $main_css_element         = '.sae_gallery .sae_gallery_item%%order_class%%';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Fikri Rasyid',
		'author_uri' => 'http://fikrirasy.id',
	);

	public function init() {
		$this->name                        = esc_html__( 'Sae Gallery Item', 'sae' );
		$this->plural                      = esc_html__( 'Sae Gallery Items', 'sae' );
		$this->advanced_setting_title_text = esc_html__( 'Image', 'sae' );
		$this->settings_modal_toggles      = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'    => esc_html__( 'Content', 'sae' ),
						'priority' => 10,
					),
					'admin_label' => array(
						'title'    => esc_html__( 'Admin Label', 'sae' ),
						'priority' => 100,
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'caption' => array(
						'title'    => esc_html__( 'Caption', 'sae' ),
						'priority' => 40,
					),
				),
			),
		);
		$this->advanced_fields         = array(
			'borders'     => array(
				'default' => array(),
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
			'box_shadow'  => array(
				'default' => array(),
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
			'fonts'       => array(
				'caption' => array(
					'label' => esc_html__( 'Title', 'et_builder' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .sae-gallery-item-caption"
					),
				),
			),
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
			// GENERAL
			'src' => array(
				// UI
				'label'              => esc_html__( 'Image', 'sae' ),
				'description'        => esc_html__( '', 'sae' ),

				// Settings
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sae' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sae' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sae' ),
				'hide_metadata'      => true,

				// Category & Location
				'option_category'    => 'basic_option',
				'tab_slug'           => 'general',
				'toggle_slug'        => 'main_content',
			),
			'caption' => array(
				// UI
				'label'           => esc_html__( 'Caption', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'text',

				// Category & Location
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'admin_title' => array(
				// UI
				'label'           => esc_html__( 'Admin Label', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'text',

				// Category & Location
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'admin_label',
			),

			// ADVANCED
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
			),
		);

		// background-field's fields need to be manually added as `skip` type of field so its value
		// can be properly saved and fetched
		$fields = array_merge(
			$fields,
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
	 * @since ??
	 *
	 * @param string $render_slug
	 */
	public function sae_set_css( $render_slug ) {
		// SELECTORS
		$gallery_caption_selector = "{$this->main_css_element} .sae-gallery-item-caption";


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
		// Image configuration
		$src                       = $this->props['src'];
		$image_id                  = attachment_url_to_postid( $src ) ;
		$image_classnames          = array();
		$rendered_image_data_attrs = '';
		$is_placeholder            = false;

		// Populate progressive image attributes if attachment id is found
		if ( $image_id ) {
			$sae_images_metadata = wp_get_attachment_metadata( $image_id );
			$sae_image_url       = wp_get_attachment_url( $image_id );
			$sae_image_basename  = wp_basename( $sae_image_url );
			$sae_image_sizes     = array();

			foreach ( $sae_images_metadata['sizes'] as $image_size_name => $image_size ) {
				// Only deal with sae-defined image sizes
				if ( 'sae_' !== substr( $image_size_name, 0, 4 ) ) {
					continue;
				}

				$image_size_width = (string) $image_size['width'];
				$image_size_url   = str_replace( $sae_image_basename, $image_size['file'], $sae_image_url );

				// Replace rendered image src with placeholder URL
				if ( 'sae_placeholder' === $image_size_name ) {
					// Append original size as 10000 (similar to how height 10000 is used for "auto" height)
					$rendered_image_data_attrs .= sprintf(
						' data-sae-src-width-10000="%1$s"',
						esc_attr( $src )
					);

					$sae_image_sizes[] = '10000';

					// Replace src attribute with placeholder size
					$src            = $image_size_url;
					$is_placeholder = true;

					// No need to add 150 size (placeholder) image into tag data attributes
					continue;
				}

				// Add image URL as data attribute
				$rendered_image_data_attrs .= sprintf(
					' data-sae-src-width-%1$s="%2$s"',
					esc_attr( $image_size_width ),
					esc_attr( $image_size_url )
				);

				$sae_image_sizes[] = $image_size_width;
			}

			// Append image sizes data attribute
			if ( ! empty( $sae_image_sizes ) ) {
				$rendered_image_data_attrs .= sprintf(
					' data-sae-image-width="%1$s"',
					esc_attr( implode( ',', $sae_image_sizes ) )
				);
			}
		}

		if ( $is_placeholder ) {
			$image_classnames[] = 'sae-image--placeholder';

			// Make sure placeholder fill the wrapper as soon as it can
			$rendered_image_data_attrs .= ' style="width: 100%;"';
		} else {
			$image_classnames[] = 'sae-image';
		}

		$rendered_image_classnames = implode( ' ', $image_classnames );

		// Caption configuration
		$caption = '' === $this->props['caption'] ? '' : sprintf(
			'<figcaption class="sae-gallery-item-caption">%1$s</figcaption>',
			et_core_sanitized_previously( $this->props['caption'] )
		);

		// Set styles
		$this->sae_set_css( $render_slug );

		return sprintf(
			'<div class="sae-gallery-item-wrapper">
				<figure>
					<div class="sae-gallery-item-image-wrapper">
						<img src="%1$s" alt="%2$s" class="%3$s"%4$s />
					</div>
					%5$s
				</figure>
			</div>',
			esc_attr( $src ),
			esc_attr( $this->props['caption'] ),
			esc_attr( $rendered_image_classnames ),
			et_core_sanitized_previously( $rendered_image_data_attrs ),
			et_core_sanitized_previously( $caption )
		);
	}
}

new SAE_GalleryItem;
