<?php
/*
Plugin Name: Sae
Plugin URI:
Description: Experimental gallery and progressive image modules for Divi that spark joy
Version:     1.0.0
Author:      Fikri Rasyid
Author URI:  http://fikrirasy.id
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: sae-sae
Domain Path: /languages

Sae is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Sae is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Sae. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'sae_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function sae_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Sae.php';
}
add_action( 'divi_extensions_init', 'sae_initialize_extension' );
endif;
