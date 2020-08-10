<?php
/**
 * Fixed Bottom Menu
 *
 * @package    Fixed Bottom Menu
 * @subpackage Fixed Bottom Menu Main function
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

$fixedbottommenu = new FixedBottomMenu();

/** ==================================================
 * Main Functions
 */
class FixedBottomMenu {

	/** ==================================================
	 * Settings
	 *
	 * @var $fixedbottommenu_settings  fixedbottommenu_settings.
	 */
	private $fixedbottommenu_settings;

	/** ==================================================
	 * Columun
	 *
	 * @var $fixedbottommenu_settings_col  fixedbottommenu_settings_col.
	 */
	private $fixedbottommenu_settings_col;

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		$this->fixedbottommenu_settings = get_option( 'fixedbottommenu_settings' );
		$this->fixedbottommenu_settings_col = 100 / get_option( 'fixedbottommenu_settings_col', 5 );

		add_action( 'wp_enqueue_scripts', array( $this, 'dashicon_show_load_dashicons' ) );
		if ( get_option( 'fixedbottommenu_settings_old' ) ) {
			add_action( 'wp_footer', array( $this, 'load_localize_styles_old' ) );
			add_action( 'wp_footer', array( $this, 'bottom_menu_old' ) );
		} else {
			add_action( 'wp_footer', array( $this, 'load_localize_styles' ) );
			add_action( 'wp_footer', array( $this, 'bottom_menu' ) );
		}

		add_action( 'wp_head', array( $this, 'safe_area' ) );

	}

	/** ==================================================
	 * Menu
	 *
	 * @since 1.02
	 */
	public function bottom_menu() {

		$icon_type = 'dash';
		if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
			$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
			$icon_type = $addonicon['type'];
		}

		?>
		<div id="fixed-bottom-menu">
			<div class="fixed-bottom-menu-container">
				<?php
				for ( $i = 1; $i <= get_option( 'fixedbottommenu_settings_col', 5 ); $i++ ) {
					?>
					<div class="fixed-bottom-menu-item">
						<a href="<?php echo esc_url( $this->fixedbottommenu_settings[ 'url' . $i ] ); ?>">
						<?php
						if ( 'dash' === $icon_type ) {
							?>
							<span class="dashicons dashicons-<?php echo esc_attr( $this->fixedbottommenu_settings[ 'dash' . $i ] ); ?>"></span>
							<?php
						} else {
							do_action( 'fbm_icon_view', $addonicon[ $icon_type ][ 'icon' . $i ], $icon_type );
						}
						?>
						<br>
						<span class="fixed-bottom-menu-text"><?php echo esc_html( $this->fixedbottommenu_settings[ 'text' . $i ] ); ?></span>
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php

	}

	/** ==================================================
	 * Load Localize Style
	 *
	 * @since 1.02
	 */
	public function load_localize_styles() {

		wp_enqueue_style( 'fixed-bottom-menu', plugin_dir_url( __DIR__ ) . 'css/fixedbottommenu.css', array(), '1.00' );

		$css = '.fixed-bottom-menu-text{ font-size:' . $this->fixedbottommenu_settings['font_size'] . 'px; }';
		$css .= '.fixed-bottom-menu-container { background-color: ' . $this->fixedbottommenu_settings['back_color'] . '; }';
		$css .= '.fixed-bottom-menu-item { -webkit-flex-basis: ' . $this->fixedbottommenu_settings_col . '%; -ms-flex-preferred-size: ' . $this->fixedbottommenu_settings_col . '%; flex-basis: ' . $this->fixedbottommenu_settings_col . '%; }';
		$css .= '.fixed-bottom-menu-item a { color: ' . $this->fixedbottommenu_settings['color'] . '; }';
		$css .= '.fixed-bottom-menu-item a:hover { color: ' . $this->fixedbottommenu_settings['over_color'] . '; }';
		$css .= '@media( min-width: ' . $this->fixedbottommenu_settings['min_width'] . 'px ) { #fixed-bottom-menu{ display: none; }';
		wp_add_inline_style( 'fixed-bottom-menu', $css );

	}

	/** ==================================================
	 * Menu old
	 *
	 * @since 1.00
	 */
	public function bottom_menu_old() {

		$icon_type = 'dash';
		if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
			$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
			$icon_type = $addonicon['type'];
		}

		?>
		<ul class="fixed-bottom-menu">
			<?php
			for ( $i = 1; $i <= get_option( 'fixedbottommenu_settings_col', 5 ); $i++ ) {
				?>
				<li>
					<a href="<?php echo esc_url( $this->fixedbottommenu_settings[ 'url' . $i ] ); ?>">
					<?php
					if ( 'dash' === $icon_type ) {
						?>
						<span class="dashicons dashicons-<?php echo esc_attr( $this->fixedbottommenu_settings[ 'dash' . $i ] ); ?>"></span>
						<?php
					} else {
						do_action( 'fbm_icon_view', $addonicon[ $icon_type ][ 'icon' . $i ], $icon_type );
					}
					?>
					<br>
					<span class="fixed-bottom-menu-text"><?php echo esc_html( $this->fixedbottommenu_settings[ 'text' . $i ] ); ?></span>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php

	}

	/** ==================================================
	 * Load Localize Style old
	 *
	 * @since 1.00
	 */
	public function load_localize_styles_old() {

		wp_enqueue_style( 'fixed-bottom-menu', plugin_dir_url( __DIR__ ) . 'css/fixedbottommenu_old.css', array(), '1.00' );

		$css = '.fixed-bottom-menu-text{ font-size:' . $this->fixedbottommenu_settings['font_size'] . 'px; }';
		$css .= 'ul.fixed-bottom-menu { background-color: ' . $this->fixedbottommenu_settings['back_color'] . '; }';
		$css .= 'ul.fixed-bottom-menu li { width: ' . $this->fixedbottommenu_settings_col . '%; }';
		$css .= '.fixed-bottom-menu li a { color: ' . $this->fixedbottommenu_settings['color'] . '; }';
		$css .= '.fixed-bottom-menu li a:hover { color: ' . $this->fixedbottommenu_settings['over_color'] . '; }';
		$css .= '@media( min-width: ' . $this->fixedbottommenu_settings['min_width'] . 'px ) { .fixed-bottom-menu{ display: none; }';

		wp_add_inline_style( 'fixed-bottom-menu', $css );

	}

	/** ==================================================
	 * Dashicon
	 *
	 * @since 1.00
	 */
	public function dashicon_show_load_dashicons() {

		$icon_type = 'dash';
		if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
			$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
			$icon_type = $addonicon['type'];
		}

		if ( 'dash' === $icon_type ) {
			wp_enqueue_style( 'dashicons' );
		}

	}

	/** ==================================================
	 * Meta tag for Viewport
	 *
	 * @since 1.16
	 */
	public function safe_area() {

		$insert = '<meta name="viewport" content="initial-scale=1, viewport-fit=cover">' . "\n";
		$allowed_insert_html = array(
			'meta'  => array(
				'name' => array(),
				'content' => array(
					'initial-scale' => array(),
					'viewport-fit'  => array(),
				),
			),
		);
		echo wp_kses( $insert, $allowed_insert_html );

	}

}


