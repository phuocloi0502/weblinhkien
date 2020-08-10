<?php
/**
 * Fixed Bottom Menu
 *
 * @package    Fixed Bottom Menu
 * @subpackage FixedBottomMenuAdmin Management screen
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

$fixedbottommenuadmin = new FixedBottomMenuAdmin();

/** ==================================================
 * Management screen
 */
class FixedBottomMenuAdmin {

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ) );
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );

	}

	/** ==================================================
	 * Add a "Settings" link to the plugins page
	 *
	 * @param  array  $links  links array.
	 * @param  string $file   file.
	 * @return array  $links  links array.
	 * @since 1.00
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty( $this_plugin ) ) {
			$this_plugin = 'fixed-bottom-menu/fixedbottommenu.php';
		}
		if ( $file === $this_plugin ) {
			$links[] = '<a href="' . admin_url( 'options-general.php?page=fixedbottommenu' ) . '">' . __( 'Settings' ) . '</a>';
		}
			return $links;
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_menu() {
		add_options_page( 'Fixed Bottom Menu Options', 'Fixed Bottom Menu', 'manage_options', 'fixedbottommenu', array( $this, 'plugin_options' ) );
	}

	/** ==================================================
	 * Add Css and Script
	 *
	 * @since 1.00
	 */
	public function load_custom_wp_admin_style() {
		if ( $this->is_my_plugin_screen() ) {
			wp_enqueue_style( 'jquery-responsiveTabs', plugin_dir_url( __DIR__ ) . 'css/responsive-tabs.css', array(), '1.4.0' );
			wp_enqueue_style( 'jquery-responsiveTabs-style', plugin_dir_url( __DIR__ ) . 'css/style.css', array(), '1.4.0' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-responsiveTabs', plugin_dir_url( __DIR__ ) . 'js/jquery.responsiveTabs.min.js', array(), '1.4.0', false );
			wp_enqueue_script( 'jquery-jscolor', plugin_dir_url( __DIR__ ) . 'js/jscolor.min.js', array(), '2.0.5', false );
			wp_enqueue_script( 'fixedbottommenu-admin-js', plugin_dir_url( __DIR__ ) . 'js/jquery.fixedbottommenu.admin.js', array( 'jquery' ), '1.0.0', false );
		}
	}

	/** ==================================================
	 * For only admin style
	 *
	 * @since 1.00
	 */
	private function is_my_plugin_screen() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'settings_page_fixedbottommenu' === $screen->id ) {
			return true;
		} else {
			return false;
		}
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_options() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		$this->options_updated();
		do_action( 'fbm_icon_update' );

		$icon_type = 'dash';
		$addonicon = array();
		if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
			$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
			$icon_type = $addonicon['type'];
		}

		$scriptname = admin_url( 'options-general.php?page=fixedbottommenu' );

		$fixedbottommenu_settings = get_option( 'fixedbottommenu_settings' );

		?>

		<div class="wrap">
		<h2>Fixed Bottom Menu</h2>

			<div id="fixedbottommenu-admin-tabs">
				<ul>
					<li><a href="#fixedbottommenu-admin-tabs-1"><?php esc_html_e( 'Settings' ); ?></a></li>
					<li><a href="#fixedbottommenu-admin-tabs-2"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></a></li>
				</ul>

				<div id="fixedbottommenu-admin-tabs-1">
					<div class="wrap">
						<h2><?php esc_html_e( 'Settings' ); ?></h2>	

						<div style="margin: 5px; padding: 5px;">
							<p class="description">
							<div><?php esc_html_e( 'If the footer is overlaid on the menu and it is difficult to see, go to Appearance->Customize->Additional CSS and add a CSS like the following to make it move. The class (.site-info in the following cases) depends on the theme you are using, so please change it accordingly.', 'fixed-bottom-menu' ); ?></div>

							<div><?php esc_html_e( 'Example', 'fixed-bottom-menu' ); ?> : <code>.site-info{margin-bottom:2rem;}</code>&nbsp;
							<?php
							/* translators: menu height */
							echo esc_html( sprintf( __( '* The menu is anchored to the %s.', 'fixed-bottom-menu' ), '2rem' ) );
							?>
							</div>
							</p>
							<?php
							if ( empty( $addonicon ) ) {
								?>
								<details style="margin-bottom: 5px;">
								<summary style="cursor: pointer; padding: 10px; border: 1px solid #ddd; background: #f4f4f4; color: #000;"><?php esc_html_e( 'Add on', 'fixed-bottom-menu' ); ?></summary>
								<h3>Fixed Bottom Menu Add On Icon</h3>
								<p class="description">
								<?php
								esc_html_e( 'Sell add-ons that add the following icons.', 'fixed-bottom-menu' );
								?>
								<div style="padding: 5px;">
								<a href="https://fontawesome.com/" target="_blank" rel="noopener noreferrer" class="page-title-action">Font Awesome</a>
								<a href="https://material.io/resources/icons/" target="_blank" rel="noopener noreferrer" class="page-title-action">Google Material Icons</a>
								</div>
								</p>
								<div style="margin: 0 100px 10px; ">
								<a href="<?php echo esc_url( __( 'https://shop.riverforest-wp.info/fixed-bottom-menu-add-on-icon/', 'fixed-bottom-menu' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php submit_button( __( 'BUY', 'fixed-bottom-menu' ), 'primary', 'buylink', false ); ?></a>
								</div>
								</details>
								<?php
							} else {
								do_action( 'fbm_icon_type' );
							}
							?>
							<form method="post" action="<?php echo esc_url( $scriptname ); ?>">
							<?php wp_nonce_field( 'fbm_set', 'fixedbottommenu_set' ); ?>
							<details style="margin-bottom: 5px;">
							<summary style="cursor: pointer; padding: 10px; border: 1px solid #ddd; background: #f4f4f4; color: #000;"><?php esc_html_e( 'Column Count' ); ?></summary>
							<?php
							for ( $i = 3; $i <= 5; $i++ ) {
								?>
								<div style="padding: 5px;">
								<input type="radio" name="menu_col" value="<?php echo esc_attr( $i ); ?>" 
								<?php
								if ( get_option( 'fixedbottommenu_settings_col', 5 ) == $i ) {
									echo 'checked';
								}
								?>
								>
								<?php
								/* translators: menu column */
								echo esc_html( sprintf( __( '%1$d : 1 to %1$d', 'fixed-bottom-menu' ), $i ) );
								?>
								</div>
								<?php
							}
							?>
							</details>
							<?php
							for ( $i = 1; $i <= 5; $i++ ) {
								?>
								<details style="margin-bottom: 5px;">
								<summary style="cursor: pointer; padding: 10px; border: 1px solid #ddd; background: #f4f4f4; color: #000;"><?php echo esc_html( $i ); ?></summary>
								<?php
								if ( 'dash' === $icon_type ) {
									?>
									<div style="padding: 5px;">
									<a style="text-decoration: none;" href="https://developer.wordpress.org/resource/dashicons/" target="_blank" rel="noopener noreferrer"><strong><?php esc_html_e( 'Dashicon' ); ?></strong></a> : 
									<input type="text" name="dash<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $fixedbottommenu_settings[ 'dash' . $i ] ); ?>">
									</div>
									<?php
								} else {
									do_action( 'fbm_icon_name', $i );
								}
								?>
								<div style="padding: 5px;">
								<strong><?php esc_html_e( 'URL' ); ?></strong> : 
								<input type="text" name="url<?php echo esc_attr( $i ); ?>" style="width: 80%;" value="<?php echo esc_url( $fixedbottommenu_settings[ 'url' . $i ] ); ?>">
								</div>
								<div style="padding: 5px;">
								<strong><?php esc_html_e( 'Text' ); ?></strong> : 
								<input type="text" name="text<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $fixedbottommenu_settings[ 'text' . $i ] ); ?>">
								</div>
								</details>
								<?php
							}
							?>
							<details style="margin-bottom: 5px;">
							<summary style="cursor: pointer; padding: 10px; border: 1px solid #ddd; background: #f4f4f4; color: #000;"><?php echo esc_html( __( 'Font Sizes' ) . ' & ' . __( 'Color' ) . ' & ' . __( 'Max Width' ) ); ?></summary>
							<div style="display: block;padding:5px 15px">
								<strong><?php esc_html_e( 'Font Sizes' ); ?> : </strong>
								<input type="range" id="font_size_bar" style="vertical-align:middle;" step="1" min="8" max="12" name="font_size" value="<?php echo esc_attr( $fixedbottommenu_settings['font_size'] ); ?>" /><span id="font_size_range"></span>
							</div>
							<div style="display: block;padding:5px 15px">
								<strong><?php esc_html_e( 'Background color' ); ?> : </strong>
								<input type="text" class="jscolor" name="back_color" value="<?php echo esc_attr( $fixedbottommenu_settings['back_color'] ); ?>" size="10" />
							</div>
							<div style="display: block;padding:5px 15px">
								<strong><?php esc_html_e( 'Text color' ); ?> : </strong>
								<input type="text" class="jscolor" name="color" value="<?php echo esc_attr( $fixedbottommenu_settings['color'] ); ?>" size="10" />
							</div>
							<div style="display: block;padding:5px 15px">
								<strong><?php esc_html_e( 'Overlay Color', 'fixed-bottom-menu' ); ?> : </strong>
								<input type="text" class="jscolor" name="over_color" value="<?php echo esc_attr( $fixedbottommenu_settings['over_color'] ); ?>" size="10" />
							</div>
							<div style="display: block;padding:5px 15px">
								<strong><?php esc_html_e( 'Max Width' ); ?> : </strong>
								<input type="number" step="1" min="768" name="min_width" value="<?php echo esc_attr( $fixedbottommenu_settings['min_width'] ); ?>" />
							</div>
							</details>
							<details style="margin-bottom: 5px;">
							<summary style="cursor: pointer; padding: 10px; border: 1px solid #ddd; background: #f4f4f4; color: #000;"><?php esc_html_e( 'Old setting', 'fixed-bottom-menu' ); ?></summary>
							<div style="padding: 5px;">
								<p class="description">
								<ul style="list-style-type: disc; margin: 0px 15px;">
								<li>
								<?php esc_html_e( 'This is the setting up to version 1.01. You can use this setting by checking the box if you are having problems latest version. Some of the latest themes, such as Twenty Twenty, may have glitches at this setting.', 'fixed-bottom-menu' ); ?>
								</li>
								<li>
								<?php esc_html_e( 'If you experience any problems with the latest version, please contact the support forum. In this case, please specify the browser and device you are using. CSS hacks would be much appreciated.', 'fixed-bottom-menu' ); ?>
								</li>
								</ul>
								</p>
								<div style="display: block;padding:5px 15px">
								<a href="https://wordpress.org/support/plugin/fixed-bottom-menu" target="_blank" rel="noopener noreferrer" class="page-title-action"><?php esc_html_e( 'Support Forums', 'fixed-bottom-menu' ); ?></a>
								</div>
								<div style="display: block;padding:5px 15px">
								<?php esc_html_e( 'Example of footer settings', 'fixed-bottom-menu' ); ?> : <code>.site-info{margin-bottom:45px;}</code>&nbsp;
								<?php
								/* translators: menu height */
								echo esc_html( sprintf( __( '* The menu is anchored to the %s.', 'fixed-bottom-menu' ), '45px' ) );
								?>
								</div>
								<div style="display: block;padding:5px 15px">
								<input type="checkbox" name="old_set" value="1" <?php checked( get_option( 'fixedbottommenu_settings_old' ), true ); ?>/><?php esc_html_e( 'Apply old setting', 'fixed-bottom-menu' ); ?>
								</div>
							</div>
							</details>
							<div class="submit">
							<?php submit_button( __( 'Save Changes' ), 'large', 'Manageset', false ); ?>
							<?php submit_button( __( 'Default' ), 'large', 'Defaultset', false ); ?>
							</div>

							</form>

						</div>
					</div>
				</div>

				<div id="fixedbottommenu-admin-tabs-2">
					<div class="wrap">
					<?php $this->credit(); ?>
					</div>
				</div>

			</div>

		</div>
		<?php
	}

	/** ==================================================
	 * Credit
	 *
	 * @since 1.00
	 */
	private function credit() {

		$plugin_name    = null;
		$plugin_ver_num = null;
		$plugin_path    = plugin_dir_path( __DIR__ );
		$plugin_dir     = untrailingslashit( $plugin_path );
		$slugs          = explode( '/', $plugin_dir );
		$slug           = end( $slugs );
		$files          = scandir( $plugin_dir );
		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file || is_dir( $plugin_path . $file ) ) {
				continue;
			} else {
				$exts = explode( '.', $file );
				$ext  = strtolower( end( $exts ) );
				if ( 'php' === $ext ) {
					$plugin_datas = get_file_data(
						$plugin_path . $file,
						array(
							'name'    => 'Plugin Name',
							'version' => 'Version',
						)
					);
					if ( array_key_exists( 'name', $plugin_datas ) && ! empty( $plugin_datas['name'] ) && array_key_exists( 'version', $plugin_datas ) && ! empty( $plugin_datas['version'] ) ) {
						$plugin_name    = $plugin_datas['name'];
						$plugin_ver_num = $plugin_datas['version'];
						break;
					}
				}
			}
		}
		$plugin_version = __( 'Version:' ) . ' ' . $plugin_ver_num;
		/* translators: FAQ Link & Slug */
		$faq       = sprintf( esc_html__( 'https://wordpress.org/plugins/%s/faq', '%s' ), $slug );
		$support   = 'https://wordpress.org/support/plugin/' . $slug;
		$review    = 'https://wordpress.org/support/view/plugin-reviews/' . $slug;
		$translate = 'https://translate.wordpress.org/projects/wp-plugins/' . $slug;
		$facebook  = 'https://www.facebook.com/katsushikawamori/';
		$twitter   = 'https://twitter.com/dodesyo312';
		$youtube   = 'https://www.youtube.com/channel/UC5zTLeyROkvZm86OgNRcb_w';
		$donate    = sprintf( esc_html__( 'https://shop.riverforest-wp.info/donate/', '%s' ), $slug );

		?>
		<span style="font-weight: bold;">
		<div>
		<?php echo esc_html( $plugin_version ); ?> | 
		<a style="text-decoration: none;" href="<?php echo esc_url( $faq ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'FAQ' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $support ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Support Forums' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $review ); ?>" target="_blank" rel="noopener noreferrer"><?php sprintf( esc_html_e( 'Reviews', '%s' ), $slug ); ?></a>
		</div>
		<div>
		<a style="text-decoration: none;" href="<?php echo esc_url( $translate ); ?>" target="_blank" rel="noopener noreferrer">
		<?php
		/* translators: Plugin translation link */
		echo sprintf( esc_html__( 'Translations for %s' ), esc_html( $plugin_name ) );
		?>
		</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-facebook"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-twitter"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-video-alt3"></span></a>
		</div>
		</span>

		<div style="width: 250px; height: 180px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
		<h3><?php sprintf( esc_html_e( 'Please make a donation if you like my work or would like to further the development of this plugin.', '%s' ), $slug ); ?></h3>
		<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
		<button type="button" style="margin: 5px; padding: 5px;" onclick="window.open('<?php echo esc_url( $donate ); ?>')"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></button>
		</div>

		<?php

	}

	/** ==================================================
	 * Update wp_options table.
	 *
	 * @since 1.00
	 */
	private function options_updated() {

		if ( isset( $_POST['Manageset'] ) && ! empty( $_POST['Manageset'] ) ) {
			if ( check_admin_referer( 'fbm_set', 'fixedbottommenu_set' ) ) {
				$icon_type = 'dash';
				$addonicon = array();
				if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
					$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
					$icon_type = $addonicon['type'];
				}
				$fixedbottommenu_settings = get_option( 'fixedbottommenu_settings' );
				if ( 'dash' === $icon_type ) {
					if ( ! empty( $_POST['dash1'] ) ) {
						$fixedbottommenu_settings['dash1'] = sanitize_text_field( wp_unslash( $_POST['dash1'] ) );
					} else {
						$fixedbottommenu_settings['dash1'] = null;
					}
					if ( ! empty( $_POST['dash2'] ) ) {
						$fixedbottommenu_settings['dash2'] = sanitize_text_field( wp_unslash( $_POST['dash2'] ) );
					} else {
						$fixedbottommenu_settings['dash2'] = null;
					}
					if ( ! empty( $_POST['dash3'] ) ) {
						$fixedbottommenu_settings['dash3'] = sanitize_text_field( wp_unslash( $_POST['dash3'] ) );
					} else {
						$fixedbottommenu_settings['dash3'] = null;
					}
					if ( ! empty( $_POST['dash4'] ) ) {
						$fixedbottommenu_settings['dash4'] = sanitize_text_field( wp_unslash( $_POST['dash4'] ) );
					} else {
						$fixedbottommenu_settings['dash4'] = null;
					}
					if ( ! empty( $_POST['dash5'] ) ) {
						$fixedbottommenu_settings['dash5'] = sanitize_text_field( wp_unslash( $_POST['dash5'] ) );
					} else {
						$fixedbottommenu_settings['dash5'] = null;
					}
				}
				if ( ! empty( $_POST['url1'] ) ) {
					$fixedbottommenu_settings['url1'] = esc_url_raw( wp_unslash( $_POST['url1'] ) );
				} else {
					$fixedbottommenu_settings['url1'] = null;
				}
				if ( ! empty( $_POST['text1'] ) ) {
					$fixedbottommenu_settings['text1'] = sanitize_text_field( wp_unslash( $_POST['text1'] ) );
				} else {
					$fixedbottommenu_settings['text1'] = null;
				}
				if ( ! empty( $_POST['url2'] ) ) {
					$fixedbottommenu_settings['url2'] = esc_url_raw( wp_unslash( $_POST['url2'] ) );
				} else {
					$fixedbottommenu_settings['url2'] = null;
				}
				if ( ! empty( $_POST['text2'] ) ) {
					$fixedbottommenu_settings['text2'] = sanitize_text_field( wp_unslash( $_POST['text2'] ) );
				} else {
					$fixedbottommenu_settings['text2'] = null;
				}
				if ( ! empty( $_POST['url3'] ) ) {
					$fixedbottommenu_settings['url3'] = esc_url_raw( wp_unslash( $_POST['url3'] ) );
				} else {
					$fixedbottommenu_settings['url3'] = null;
				}
				if ( ! empty( $_POST['text3'] ) ) {
					$fixedbottommenu_settings['text3'] = sanitize_text_field( wp_unslash( $_POST['text3'] ) );
				} else {
					$fixedbottommenu_settings['text3'] = null;
				}
				if ( ! empty( $_POST['url4'] ) ) {
					$fixedbottommenu_settings['url4'] = esc_url_raw( wp_unslash( $_POST['url4'] ) );
				} else {
					$fixedbottommenu_settings['url4'] = null;
				}
				if ( ! empty( $_POST['text4'] ) ) {
					$fixedbottommenu_settings['text4'] = sanitize_text_field( wp_unslash( $_POST['text4'] ) );
				} else {
					$fixedbottommenu_settings['text4'] = null;
				}
				if ( ! empty( $_POST['url5'] ) ) {
					$fixedbottommenu_settings['url5'] = esc_url_raw( wp_unslash( $_POST['url5'] ) );
				} else {
					$fixedbottommenu_settings['url5'] = null;
				}
				if ( ! empty( $_POST['text5'] ) ) {
					$fixedbottommenu_settings['text5'] = sanitize_text_field( wp_unslash( $_POST['text5'] ) );
				} else {
					$fixedbottommenu_settings['text5'] = null;
				}
				if ( isset( $_POST['font_size'] ) && ! empty( $_POST['font_size'] ) ) {
					$fixedbottommenu_settings['font_size'] = intval( $_POST['font_size'] );
				}
				if ( isset( $_POST['back_color'] ) && ! empty( $_POST['back_color'] ) ) {
					$fixedbottommenu_settings['back_color'] = '#' . sanitize_text_field( wp_unslash( $_POST['back_color'] ) );
				}
				if ( isset( $_POST['color'] ) && ! empty( $_POST['color'] ) ) {
					$fixedbottommenu_settings['color'] = '#' . sanitize_text_field( wp_unslash( $_POST['color'] ) );
				}
				if ( isset( $_POST['over_color'] ) && ! empty( $_POST['over_color'] ) ) {
					$fixedbottommenu_settings['over_color'] = '#' . sanitize_text_field( wp_unslash( $_POST['over_color'] ) );
				}
				if ( isset( $_POST['min_width'] ) && ! empty( $_POST['min_width'] ) ) {
					$fixedbottommenu_settings['min_width'] = intval( $_POST['min_width'] );
				}
				if ( ! empty( $_POST['old_set'] ) ) {
					update_option( 'fixedbottommenu_settings_old', true );
				} else {
					delete_option( 'fixedbottommenu_settings_old' );
				}
				if ( ! empty( $_POST['menu_col'] ) ) {
					update_option( 'fixedbottommenu_settings_col', intval( $_POST['menu_col'] ) );
				}
				update_option( 'fixedbottommenu_settings', $fixedbottommenu_settings );
				echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html__( 'Settings' ) . ' --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
			}
		}

		if ( isset( $_POST['Defaultset'] ) && ! empty( $_POST['Defaultset'] ) ) {
			if ( check_admin_referer( 'fbm_set', 'fixedbottommenu_set' ) ) {
				$fixedbottommenu_tbl = array(
					'dash1'      => 'admin-home',
					'dash2'      => 'calendar',
					'dash3'      => 'edit',
					'dash4'      => 'playlist-video',
					'dash5'      => 'location',
					'url1'       => home_url(),
					'text1'      => 'Home',
					'url2'       => null,
					'text2'      => 'Calendar',
					'url3'       => null,
					'text3'      => 'Blog',
					'url4'       => null,
					'text4'      => 'Gallery',
					'url5'       => null,
					'text5'      => 'Address',
					'font_size'  => 10,
					'back_color' => '#7db4e6',
					'color'      => '#ffffff',
					'over_color' => '#0000ff',
					'min_width'  => '1300',
				);
				update_option( 'fixedbottommenu_settings', $fixedbottommenu_tbl );
				echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html__( 'Settings' ) . ' --> ' . esc_html__( 'Default' ) . '</li></ul></div>';
				delete_option( 'fixedbottommenu_settings_old' );
				delete_option( 'fixedbottommenu_settings_col' );
			}
		}

	}

	/** ==================================================
	 * Settings register
	 *
	 * @since 1.00
	 */
	public function register_settings() {

		if ( ! get_option( 'fixedbottommenu_settings' ) ) {
			$fixedbottommenu_tbl = array(
				'dash1'      => 'admin-home',
				'dash2'      => 'calendar',
				'dash3'      => 'edit',
				'dash4'      => 'playlist-video',
				'dash5'      => 'location',
				'url1'       => home_url(),
				'text1'      => 'Home',
				'url2'       => null,
				'text2'      => 'Calendar',
				'url3'       => null,
				'text3'      => 'Blog',
				'url4'       => null,
				'text4'      => 'Gallery',
				'url5'       => null,
				'text5'      => 'Address',
				'font_size'  => 10,
				'back_color' => '#7db4e6',
				'color'      => '#ffffff',
				'over_color' => '#0000ff',
				'min_width'  => '1300',
			);
			update_option( 'fixedbottommenu_settings', $fixedbottommenu_tbl );
		}

	}

}


