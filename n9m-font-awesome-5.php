<?php
/*
Plugin Name: Iconic Awesome Fonts For Menus
Plugin URI: https://github.com/cogdog/font-awesome-5-menus
Description: Easily add Font Awesome 5.0 icons to your WordPress menus and anywhere else on your site! This is an update to original version 4.7.0 plugin by New Nine Media. Apparently one cannpt use Font Awesome in the plugin name!
Version: 5.3
Author: CogDog
Author URI: https://cog.dog/
License: GPLv2 or later
*/

/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class FontAwesomeFive {

    public static $defaults = array(
        'fa5_location' => 'https://use.fontawesome.com/releases/v5.12.0/css/all.css',
        'spacing' => 1,
        'stylesheet' => 'local',
        'version' => '5.2'
    );

    function __construct(){
        global $wp_version;

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

        add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_css_class' ) );
        add_filter( 'walker_nav_menu_start_el', array( $this, 'walker_nav_menu_start_el' ), 10, 4 );
        
        $plugin = plugin_basename(__FILE__); 
        add_filter( "plugin_action_links_$plugin", array( $this, 'fa5menu_settings_link') );

        add_shortcode( 'fa', array( $this, 'shortcode_icon' ) );
        add_shortcode( 'fa-stack', array( $this, 'shortcode_stack' ) );        
        
    }

    function admin_enqueue_scripts( $hook ){
        if( 'settings_page_n9m-font-awesome-5-menus' == $hook ){
            wp_enqueue_style( 'n9m-admin-font-awesome-5', plugins_url( 'css/all.min.css', __FILE__ ), false, self::$defaults[ 'version' ] );
        }
    }

    function admin_menu(){
        add_submenu_page( 'options-general.php', 'Font Awesome 5 Menus', 'Font Awesome 5 Menus', 'edit_theme_options', 'n9m-font-awesome-5-menus', array( $this, 'admin_menu_cb' ) );
    }
    
	function fa5menu_settings_link( $links ) {
		// add settings link		
    	$settings_link = '<a href="options-general.php?page=n9m-font-awesome-5-menus">' . __( 'Settings' ) . '</a>';
    	array_push( $links, $settings_link );
    	return $links;		
	}  
	
    function admin_menu_cb(){
        if( $_POST && check_admin_referer( 'n9m-fa' ) ){
            $settings = array();
            switch( $_POST[ 'n9m_location' ] ){
                case 'local':
                case 'fa5':
                case 'none':
                    $settings[ 'stylesheet' ] = $_POST[ 'n9m_location' ];
                    break;
                case 'other':
                    $settings[ 'stylesheet' ] = 'other';
                    $settings[ 'stylesheet_location' ] = sanitize_text_field( $_POST[ 'n9m_location-other-location' ] );
                    break;
            }
            if( isset( $_POST[ 'n9m_text_spacing' ] ) ){
                $settings[ 'spacing' ] = 1;
            } else {
                $settings[ 'spacing' ] = 0;
            }
            update_option( 'n9m-font-awesome-5-menus', $settings );
            print '<div class="updated"><p>Your settings have been saved!</p></div>';
        }
        $settings = get_option( 'n9m-font-awesome-5-menus', self::$defaults );
        print ' <div class="wrap">
                    <h2><i class="fas fa-dog"></i> ' . get_admin_page_title() . ' by @cogdog</h2>
                    <form action="' . admin_url( 'options-general.php?page=n9m-font-awesome-5-menus' ) . '" method="post">
                        <h3>Font Awesome Stylesheet</h3>
                        <p>Select how you want Font Awesome\'s stylesheet loaded on your site (if at all) While this plugin includes Font Awesome 5, you can use a newer version with the custom location option below:</p>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row">Load Font Awesome From:</th>
                                    <td>
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Load Font Awesome From</span></legend>
                                            <label for="n9m_location-local"><input type="radio" name="n9m_location" id="n9m_location-local" value="local"' . ( 'local' == $settings[ 'stylesheet' ] ? ' checked' : false ) . '> Local plugin folder (default, version ' . self::$defaults[ 'version' ] . ')</label>
                                            <br />
                                            <label for="n9m_location-fa5"><input type="radio" name="n9m_location" id="n9m_location-fa5" value="fa5"' . ( 'fa5' == $settings[ 'stylesheet' ] ? ' checked' : false ) . '> Official Font Awesome CDN <span class="description">(<a href="https://fontawesome.com" target="_blank">Font Awesome Itself</a>)</span></label>
                                            <br />
                                            <label for="n9m_location-other"><input type="radio" name="n9m_location" id="n9m_location-other" value="other"' . ( 'other' == $settings[ 'stylesheet' ] ? ' checked' : false ) . '> A custom location:</label> <input type="text" name="n9m_location-other-location" id="n9m_location-other-location" placeholder="Enter full url here" class="regular-text" value="' . ( isset( $settings[ 'stylesheet_location' ] ) ? $settings[ 'stylesheet_location' ] : '' ) . '">
                                            <br />
                                            <label for="n9m_location-none"><input type="radio" name="n9m_location" id="n9m_location-none" value="none"' . ( 'none' == $settings[ 'stylesheet' ] ? ' checked' : false ) . '> Don&#8217;t load Font Awesome 5&#8217;s stylesheet <span class="description">(use this if you load Font Awesome elsewhere on your site)</span></label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>Icon Spacing</h3>
                        <p>By default, Font Awesome 5 Menus adds a space before or after the icon in your menu. Uncheck the box below to remove this space and give you finer control over your custom styling.</p>
                        <p><label for="n9m_text_spacing"><input type="checkbox" name="n9m_text_spacing" id="n9m_text_spacing" value="1"' . ( 1 == $settings[ 'spacing' ] ? ' checked' : false ) . '> Keep the space between my text and my icons <span class="description">(default is checked)</span></label>
                        <p>' . wp_nonce_field( 'n9m-fa' ) . '<button type="submit" class="button button-primary">Save Settings</button></p>
                    </form>
                </div>';
    }

    function nav_menu_css_class( $classes ){
        if( is_array( $classes ) ){
            $tmp_classes = preg_grep( '/^(fa|fas|far|fal|fad|fab)(-\S+)?$/i', $classes );
            if( !empty( $tmp_classes ) ){
                $classes = array_values( array_diff( $classes, $tmp_classes ) );
            }
        }
        return $classes;
    }

    public static function register_uninstall_hook(){
        if( current_user_can( 'delete_plugins' ) ){
            delete_option( 'n9m-font-awesome-5-menus' );
            $users_with_meta = get_users( array(
                'meta_key' => 'n9m-font-awesome-5-notice-hide',
                'meta_value' => 1
            ) );
            foreach( $users_with_meta as $user_with_meta ){
                delete_user_meta( $user_with_meta->ID, 'n9m-font-awesome-5-notice-hide' );
            }
        }
    }

    protected function replace_item( $item_output, $classes ){
        $settings = get_option( 'n9m-font-awesome-5-menus', FontAwesomeFive::$defaults );
        $spacer = 1 == $settings[ 'spacing' ] ? ' ' : '';

        $before = true;
        if( in_array( 'fa-after', $classes ) ){
            $classes = array_values( array_diff( $classes, array( 'fa-after' ) ) );
            $before = false;
        }

        $icon = '<span class="' . implode( ' ', $classes ) . '"></span>';

        preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );
        if( 4 === count( $matches ) ){
            $item_output = $matches[1];
            if( $before ){
                $item_output .= $icon . '<span class="fontawesome-text">' . $spacer . $matches[2] . '</span>';
            } else {
                $item_output .= '<span class="fontawesome-text">' . $matches[2] . $spacer . '</span>' . $icon;
            }
            $item_output .= $matches[3];
        }
        return $item_output;
    }
    
    function walker_nav_menu_start_el( $item_output, $item, $depth, $args ){
        if( is_array( $item->classes ) ){
            $classes = preg_grep( '/^(fa|fas|far|fal|fad|fab)(-\S+)?$/i', $item->classes );
            if( !empty( $classes ) ){
                $item_output = $this->replace_item( $item_output, $classes );
            }
        }
        return $item_output;
    }

    function wp_enqueue_scripts(){
        $settings = get_option( 'n9m-font-awesome-5-menus', self::$defaults );
        switch( $settings[ 'stylesheet' ] ){
            case 'local':
                wp_register_style( 'font-awesome-five', plugins_url( 'css/all.min.css', __FILE__ ), array(), self::$defaults[ 'version' ], 'all' );
                wp_enqueue_style( 'font-awesome-five' );
                break;
            case 'fa5':
                wp_register_style( 'font-awesome-five', self::$defaults[ 'fa5_location' ], array(), self::$defaults[ 'version' ], 'all' );
                wp_enqueue_style( 'font-awesome-five' );
                break;
            case 'none':
                break;
            case 'other':
                wp_register_style( 'font-awesome-five', $settings[ 'stylesheet_location' ], array(), self::$defaults[ 'version' ], 'all' );
                wp_enqueue_style( 'font-awesome-five' );
                break;
        }
    }


    function shortcode_icon( $atts ){
        $a = shortcode_atts( array(
            'class' => ''
        ), $atts );
        if( !empty( $a[ 'class' ] ) ){
            $class_array = explode( ' ', $a[ 'class' ] );
            return '<i class="' . implode( ' ', $class_array ) . '"></i>';
        }
    }
    
    function shortcode_stack( $atts, $content = null ){
        $a = shortcode_atts( array(
            'class' => ''
        ), $atts );
        $class_array = array();
        if( empty( $a[ 'class' ] ) ){
            $class_array = array( 'fa-stack' );
        } else {
            $class_array = explode( ' ', $a[ 'class' ] );
            if( !in_array( 'fa-stack', $class_array ) ){
                $class_array[] = 'fa-stack';
            }
        }
        return '<span class="' . implode( ' ', $class_array ) . '">' . do_shortcode( $content ) . '</span>';
    }
    
    public static function write_log( $log ){
        if( is_array( $log ) || is_object( $log ) ){
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
    
}
$n9m_font_awesome_five = new FontAwesomeFive();

register_uninstall_hook( __FILE__, array( 'FontAwesomeFive', 'register_uninstall_hook' ) );
