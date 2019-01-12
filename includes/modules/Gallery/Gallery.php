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
					'main_content' => esc_html__( 'Content', 'sae' ),
					'elements'     => esc_html__( 'Elements', 'sae' ),
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
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
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
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
				'show_if'         => array(
					'layout'      => array(
						'grid',
						'masonry',
					),
				),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf(
			'<div class="sae-gallery-wrapper">%1$s</div>',
			et_sanitized_previously( $this->content )
		);
	}
}

new SAE_Gallery;
