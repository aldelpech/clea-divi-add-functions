<?php
/*
 * Plugin Name: CLEA Divi Add-On
 * Description: Add useful functions to the Divi theme or child theme
 * Plugin URI: https://github.com/aldelpech/clea-divi-add-functions
 * Author: Anne-Laure Delpech 
 * Author URI: https://knowledge.parcours-performance.com/
 * Version: 1.0
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Tags: divi, divi theme, 
 * Text Domain: clea-divi-add-functions
*/

/****
 this plugin is based on the "Gravity Forms Divi Styling Add-On" by Divi Space (http://www.DiviSpace.com). The original code may be found on https://github.com/DiviSpace/gf-divi
****/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Localization
function cdaf_divi_init() {
	load_plugin_textdomain( 'clea-divi-add-functions', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'cdaf_divi_init' );

/*----------------------------------------------------------------------------*
 * Path to files
 * @since 1.0.0
 *----------------------------------------------------------------------------*/

	define( 'CDAF_MAIN_FILE', __FILE__ );
	define( 'CDAF_BASENAME', plugin_basename( CDAF_MAIN_FILE ));
	define( 'CDAF_DIR_PATH', plugin_dir_path( CDAF_MAIN_FILE ));
	define( 'CDAF_DIR_URL', plugin_dir_url( CDAF_MAIN_FILE ));


	
/********************************************************************************
* Require other files
* @since 0.1
********************************************************************************/	
	/* main source of the code 
	* http://www.jeremycookson.com/how-to-add-scrolling-animations-in-wordpress/
	*/
	
	// charger des fonctions utiles à l'extension
	require_once CDAF_DIR_PATH . 'includes/cdaf-utilities.php'; 
	
	// charger des styles, fonts ou scripts correctement
	require_once CDAF_DIR_PATH . 'includes/cdaf-enqueues.php'; 

	// fonctions pour modifier des caractéristiques de l'éditeur
	require_once CDAF_DIR_PATH . 'includes/cdaf-editor.php'; 

	// générer un style en ligne pour certaines classes ou identifiants
	require_once CDAF_DIR_PATH . 'includes/cdaf-inline-style.php';
	
// Enqueue the css file
function cdaf_divi_enqueue_scripts() {
	if ( wp_basename( get_bloginfo( 'template_directory' ) ) == 'Divi' ) {
		wp_enqueue_style( 'cdaf-styles', plugins_url( '', __FILE__ ) . '/css/gf-divi.css' );

		$accent_color = esc_html( et_get_option( 'accent_color', '#2ea3f2' ) );
		$all_buttons_font_size = esc_html( et_get_option( 'all_buttons_font_size', '20' ) );
		$all_buttons_text_color = esc_html( et_get_option( 'all_buttons_text_color', $accent_color ) );
		$all_buttons_text_color_hover = esc_html( et_get_option( 'all_buttons_text_color_hover', $accent_color ) );
		$all_buttons_bg_color = esc_html( et_get_option( 'all_buttons_bg_color', '#fff' ) );
		$all_buttons_bg_color_hover = esc_html( et_get_option( 'all_buttons_bg_color_hover', 'rgba(0,0,0,.05)' ) );
		$all_buttons_border_width = esc_html( et_get_option( 'all_buttons_border_width', '2' ) );
		$all_buttons_border_color = esc_html( et_get_option( 'all_buttons_border_color', $accent_color ) );
		$all_buttons_border_color_hover = esc_html( et_get_option( 'all_buttons_border_color_hover', 'transparent' ) );
		$all_buttons_border_radius = esc_html( et_get_option( 'all_buttons_border_radius', '3' ) );
		$all_buttons_border_radius_hover = esc_html( et_get_option( 'all_buttons_border_radius_hover', '3' ) );
		$all_buttons_spacing = esc_html( et_get_option( 'all_buttons_spacing', '0' ) );
		$all_buttons_spacing_hover = esc_html( et_get_option( 'all_buttons_spacing_hover', '0' ) );
		$all_buttons_font_style = esc_html( et_get_option( 'all_buttons_font_style', '', '', true ) );
		$button_text_style = '';
		if ( $all_buttons_font_style !== '' )
			$button_text_style = et_pb_print_font_style( $all_buttons_font_style );
		$all_buttons_font = esc_html( et_get_option( 'all_buttons_font', 'inherit' ) );
		$al_accent_color = et_get_option( 'accent_color', '#2ea3f2' );
		$al_link_color = et_get_option( 'link_color', $accent_color );
		
		$custom_css = "#left-area .post-meta a[rel='category tag'] {color: {$al_link_color};}body .gform_wrapper .gform_footer input.button,body .gform_wrapper .gform_page_footer input.button{background-color:{$all_buttons_bg_color};color:{$all_buttons_text_color};border-width:{$all_buttons_border_width}px;border-color:{$all_buttons_border_color};border-radius:{$all_buttons_border_radius}px;font-family:{$all_buttons_font};font-size:{$all_buttons_font_size}px;letter-spacing:{$all_buttons_spacing}px;{$button_text_style}}body .gform_wrapper .gform_footer input.button:hover,body .gform_wrapper .gform_page_footer input.button:hover{background-color:{$all_buttons_bg_color_hover};color:{$all_buttons_text_color_hover};border-color:{$all_buttons_border_color_hover};border-radius:{$all_buttons_border_radius_hover}px;letter-spacing:{$all_buttons_spacing_hover}px;}}";
		wp_add_inline_style( 'cdaf-styles', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'cdaf_divi_enqueue_scripts' );



/* add custom colors to the editor */
// add_filter('tiny_mce_before_init', 'cdaf_custom_colors_mce4_options');

function cdaf_custom_colors_mce4_options($init) {

	$cdaf_colors = cdaf_read_color_palette() ; 
	$cdaf_nb_color = count( $cdaf_colors ) ;
	$index = 1 ;
	$custom_colours =  "'";
/*	
	foreach ( $cdaf_colors as $color ) {
		
		// remove # in color code
		$color = ltrim( $color, "#" ) ;
		// met en majuscule le code
		$color = strtoupper( $color );
		
		if ( ($index < 7 ) && ( $index <= $cdaf_nb_color ) ) {
			
			if ( !( $color == "FFFFFF" ) ) {
				
				$custom_colours .=  '"' . $color . '", "Color ' . $index . '",' . '\r\n';
				$index++ ;
			}
			
		} else if ( ($index == 7 ) && ( $index <= $cdaf_nb_color ) ){

			// pas de , à la fin 
			$custom_colours .=  '"' . $color . '", "Color ' . $index . '"' . '\r\n';
			$index++ ;

		} else {
			// on ne met pas plus de couleurs que 7 ou que ce qui a été défini dans la palette par défaut de divi
			break ; // exit foreach loop
		}
			
							
	}
	
	$custom_colours .=  "'";

	
*/ 
// Le format doit être '"color HEX", "color-name", \r\n
$custom_colours = '
        "3366FF", "Color 1 name",
        "CCFFCC", "Color 2 name",
        "FFFF00", "Color 3 name",
        "99CC00", "Color 4 name",
        "FF0000", "Color 5 name",
        "FF99CC", "Color 6 name",
        "CCFFFF", "Color 7 name"
    ';	

$custom_colours = '
  "e8541e", "Orange1", "f39c2c", "Orange2", "c0f000", "Vert", "ffffff", "Blanc", "000000", "Noir"
  ';
 $default_colors = '
    "000000", "Black",        "993300", "Burnt orange", "333300", "Dark olive",   "003300", "Dark green",   "003366", "Dark azure",   "000080", "Navy Blue",      "333399", "Indigo",       "333333", "Very dark gray", 
    "800000", "Maroon",       "FF6600", "Orange",       "808000", "Olive",        "008000", "Green",        "008080", "Teal",         "0000FF", "Blue",           "666699", "Grayish blue", "808080", "Gray", 
    "FF0000", "Red",          "FF9900", "Amber",        "99CC00", "Yellow green", "339966", "Sea green",    "33CCCC", "Turquoise",    "3366FF", "Royal blue",     "800080", "Purple",       "999999", "Medium gray", 
    "FF00FF", "Magenta",      "FFCC00", "Gold",         "FFFF00", "Yellow",       "00FF00", "Lime",         "00FFFF", "Aqua",         "00CCFF", "Sky blue",       "993366", "Brown",        "C0C0C0", "Silver", 
    "FF99CC", "Pink",         "FFCC99", "Peach",        "FFFF99", "Light yellow", "CCFFCC", "Pale green",   "CCFFFF", "Pale cyan",    "99CCFF", "Light sky blue", "CC99FF", "Plum",         "FFFFFF", "White"
    ';
	// build colour grid custom colors
	// see https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
	$init['textcolor_map'] = '['.$custom_colours.']';
	$init['textcolor_map'] = '['.$custom_colors.','.$default_colors.']';
	
	// debug 
	echo "<p>" . $custom_colours . "</p>" ;
	// enable 6th row for custom colours in grid
	$init['textcolor_rows'] = 6;

	return $init;
}	


function cdaf_editor_colors($init) {

	// https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
    $custom_colours = '
        "3366FF", "Color 1 name",
        "CCFFCC", "Color 2 name",
        "FFFF00", "Color 3 name",
        "99CC00", "Color 4 name",
        "FF0000", "Color 5 name",
        "FF99CC", "Color 6 name",
        "CCFFFF", "Color 7 name"
    ';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 1;

    return $init;
}
add_filter('tiny_mce_before_init', 'cdaf_editor_colors');

/**
 * Remove the Color Picker plugin from tinyMCE. This will
 * prevent users from adding custom colors. Note, the default color
 * palette is still available (and customizable by developers) via
 * textcolor_map using the tiny_mce_before_init hook.
 * 
 * @param array $plugins An array of default TinyMCE plugins.
 */
add_filter( 'tiny_mce_plugins', 'cdaf_tiny_mce_remove_custom_colors' );

function cdaf_tiny_mce_remove_custom_colors( $plugins ) {       

	// https://wordpress.stackexchange.com/questions/272120/remove-custom-option-in-tinymce-colour-swatch
    foreach ( $plugins as $key => $plugin_name ) {
        if ( 'colorpicker' === $plugin_name ) {
            unset( $plugins[ $key ] );
            return $plugins;            
        }
    }

    return $plugins;            
}


/**
 *  Remove the h1 tag from the WordPress editor.
 *
 *  @param   array  $settings  The array of editor settings
 *  @return  array             The modified edit settings
 */
function cdaf_remove_h1_from_editor( $settings ) {
	// https://gist.github.com/kjbrum/da4eb508be09b9c336a9
    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
    return $settings;
}
add_filter('tiny_mce_before_init', 'cdaf_remove_h1_from_editor');
?>


