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
			'content' => array(
				// UI
				'label'           => esc_html__( 'Caption', 'sae' ),
				'description'     => esc_html__( '', 'sae' ),

				// Settings
				'type'            => 'tiny_mce',

				// Category & Location
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',

				// Visibility
				'show_if_not'     => array(
					'src' => '',
				),
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
		$src     = $this->props['src'];
		$content = '' === $this->content ? '' : sprintf(
			'<div class="sae-gallery-item-caption">%1$s</div>',
			et_sanitized_previously( $this->props['content'] )
		);

		return sprintf(
			'<div class="sae-gallery-item-wrapper">
				<img src="%1$s" alt="%2$s" />
				%3$s
			</div>',
			esc_attr( $src ),
			esc_attr( $this->props['content'] ),
			'' === $this->props['content'] ? '' : et_sanitized_previously( $content )
		);
	}
}

new SAE_GalleryItem;
