<?php

class SAE_GalleryItem extends ET_Builder_Module {

	public $slug                     = 'sae_gallery_item';
	public $type                     = 'child';
	public $child_title_var          = 'admin_label';
	public $child_title_fallback_var = 'admin_label';
	public $vb_support               = 'on';

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
		);
	}

	public function get_fields() {
		return array(
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
