<?php

class SAE_Sae extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	public $gettext_domain = 'sae';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	public $name = 'sae';

	/**
	 * The extension's version
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	public $version = '0.1';

	/**
	 * SAE_Sae constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'sae', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new SAE_Sae;
