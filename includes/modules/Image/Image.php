<?php

class SAE_Image extends SAE_Builder_Module {
	public $slug             = 'sae_image';
	public $vb_support       = 'on';
	public $main_css_element = '%%order_class%%';

	protected $module_credits = array(
		'module_uri' => 'https://github.com/fikrirasyid/sae',
		'author'     => 'Fikri Rasyid',
		'author_uri' => 'http://fikrirasy.id',
	);

	public function init() {
		$this->name                   = esc_html__( 'Sae Image', 'sae' );
		$this->plural                 = esc_html__( 'Sae Images', 'sae' );
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'    => esc_html__( 'Image', 'sae' ),
						'priority' => 10,
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'caption' => array(
						'title'    => esc_html__( 'Caption', 'sae' ),
						'priority' => 50,
					),
				),
			),
		);
		$this->advanced_fields        = array(
			'fonts' => array(
				'module' => array(
					'label'       => esc_html__( 'Caption', 'custom_module' ),
					'toggle_slug' => 'caption',
					'css'   => array(
						'main' => "{$this->main_css_element} .sae-image-caption"
					),
				),
			),
		);
	}

	public function get_fields() {
		$fields = array(
			// GENERAL
			'src' => array(
				// UI
				'label'              => esc_html__( 'Image', 'sae' ),
				'description'        => esc_html__( 'Set url of image.', 'sae' ),

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
				'description'     => esc_html__( 'Set caption of image.', 'sae' ),

				// Settings
				'type'            => 'text',

				// Category & Location
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),

			// ADVANCED
			'caption_position' => array(
				// UI
				'label'           => esc_html__( 'Caption Position', 'sae' ),
				'description'     => esc_html__( 'Set position of the image caption.', 'sae' ),

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
				'description'       => esc_html__( 'Set background of image.', 'sae' ),

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
				'description'     => esc_html__( 'Set padding of image.', 'sae' ),

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
			'caption_margin'     => array(
				// UI
				'label'           => esc_html__( 'Caption Margin', 'sae' ),
				'description'     => esc_html__( 'Set margin of image.', 'sae' ),

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
	 * @since 0.2
	 *
	 * @param string $render_slug
	 */
	public function sae_set_css( $render_slug ) {
		// SELECTORS
		$image_caption_selector = "{$this->main_css_element} .sae-image-caption";


		// CAPTION
		// CAPTION - Background
		$this->sae_set_field_css(
			$render_slug,
			'background',
			'caption_background',
			$image_caption_selector,
			'',
			false
		);

		// CAPTION - Margin
		$this->sae_set_field_css(
			$render_slug,
			'margin',
			'caption',
			$image_caption_selector,
			'',
			false
		);

		// CAPTION - Padding
		$this->sae_set_field_css(
			$render_slug,
			'padding',
			'caption',
			$image_caption_selector,
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

		$caption_position = $this->props['caption_position'];

		// Wrapper classnames
		$wrapper_classnames = array(
			'sae-image-wrapper',
			"sae-image-wrapper--caption-{$caption_position}"
		);

		$rendered_wrapper_classnames = implode( ' ', $wrapper_classnames );
		$rendered_image_classnames   = implode( ' ', $image_classnames );

		// Caption configuration
		$caption = '' === $this->props['caption'] ? '' : sprintf(
			'<figcaption class="sae-image-caption">%1$s</figcaption>',
			et_core_sanitized_previously( $this->props['caption'] )
		);

		// Set styles
		$this->sae_set_css( $render_slug );

		return sprintf(
			'<div class="%3$s">
				<figure>
					<div class="sae-image-wrapper">
						<img src="%1$s" alt="%2$s" class="%4$s"%5$s />
					</div>
					%6$s
				</figure>
			</div>',
			esc_attr( $src ),
			esc_attr( $this->props['caption'] ),
			esc_attr( $rendered_wrapper_classnames ),
			esc_attr( $rendered_image_classnames ),
			et_core_sanitized_previously( $rendered_image_data_attrs ),
			et_core_sanitized_previously( $caption )
		);
	}
}

new SAE_Image;
