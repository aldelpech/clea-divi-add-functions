<?php
/*
 * Plugin Name: CLEA Divi Add-On
 * Description: Add useful functions to the Divi theme or child theme
 * Plugin URI: https://github.com/aldelpech/clea-divi-add-functions
 * Author: Anne-Laure Delpech 
 * Author URI: https://knowledge.parcours-performance.com/
 * Version: 1.2
 
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Tags: divi, divi theme 
 * Text Domain: clea-divi-add-functions
 * Domain Path:  /languages
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

/******************************************************************************
* Actions à réaliser à l'initialisation et l'activation du plugin
* @since 1.0
******************************************************************************/

	function cdaf_activation() {
		

	}

	register_activation_hook(__FILE__, 'cdaf_activation');  
	
/********************************************************************************
* Require other files
* @since 1.0
********************************************************************************/	
	
	// charger des fonctions utiles à l'extension
	require_once CDAF_DIR_PATH . 'includes/cdaf-utilities.php'; 
	
	// charger des styles, fonts ou scripts correctement
	require_once CDAF_DIR_PATH . 'includes/cdaf-enqueues.php'; 

	// fonctions pour modifier des caractéristiques de l'éditeur
	require_once CDAF_DIR_PATH . 'includes/cdaf-editor.php'; 


/*----------------------------------------------------------------------------*
 * deactivation and uninstall
 * * @since 1.0
 *----------------------------------------------------------------------------*/
	/* upon deactivation, wordpress also needs to rewrite the rules */
	register_deactivation_hook(__FILE__, 'cdaf_deactivation');

	function cdaf_deactivation() {
		// flush_rewrite_rules(); // pour remettre à 0 les permaliens
	}
	
	// register uninstaller
	register_uninstall_hook(__FILE__, 'cdaf_uninstall');
	
	function cdaf_uninstall() {    
		// actions to perform once on plugin uninstall go here
		// remove all options and custom tables
	}	

?>
