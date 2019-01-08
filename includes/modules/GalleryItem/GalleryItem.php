<?php

class SAE_GalleryItem extends ET_Builder_Module {

	public $slug                     = 'sae_gallery_item';
	public $type                     = 'child';
	public $child_title_var          = 'title';
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
					'main_content' => esc_html__( 'Content', 'sae' ),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'src' => array(
				'label'              => esc_html__( 'Image', 'sae' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'sae' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'sae' ),
				'update_text'        => esc_attr__( 'Set As Image', 'sae' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'title',
					'content',
				),
				'description'        => esc_html__( '', 'sae' ),
				'toggle_slug'        => 'main_content',
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'sae' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( '', 'sae' ),
				'toggle_slug'     => 'main_content',
			),
			'content' => array(
				'label'           => esc_html__( 'Content', 'sae' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( '', 'sae' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$title   = $this->props['title'];
		$src     = $this->props['src'];
		$content = '' === $this->content ? '' : sprintf(
			'<div class="sae-gallery-item-description">%1$s</div>',
			et_sanitized_previously( $this->props['content'] )
		);

		return sprintf(
			'<div class="sae-gallery-item-wrapper">
				<img src="%1$s" alt="%2$s" />
				<h4 class="sae-gallery-item-title">%3$s</h4>
				%4$s
			</div>',
			esc_attr( $src ),
			esc_attr( $title ),
			esc_html( $title ),
			'' === $this->props['content'] ? '' : et_sanitized_previously( $content )
		);

		return $this->_render_module_wrapper( et_sanitized_previously( $this->content ), $render_slug );
	}
}

new SAE_GalleryItem;
