<?php
/**
 * Plugin Name: Fixed Bottom Menu
 * Plugin URI:  https://wordpress.org/plugins/fixed-bottom-menu/
 * Description: Add fixed bottom menu.
 * Version:     1.16
 * Author:      Katsushi Kawamori
 * Author URI:  https://riverforest-wp.info/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fixed-bottom-menu
 *
 * @package Fixed Bottom Menu
 */

/*
	Copyright (c) 2019- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

add_action( 'plugins_loaded', 'fixed_bottom_menu_load_textdomain' );
/** ==================================================
 * i18n
 *
 * @since 1.00
 */
function fixed_bottom_menu_load_textdomain() {
	load_plugin_textdomain( 'fixed-bottom-menu' );
}

if ( ! class_exists( 'FixedBottomMenu' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/class-fixedbottommenu.php' );
}

if ( ! class_exists( 'FixedBottomMenuAdmin' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/class-fixedbottommenuadmin.php' );
}


