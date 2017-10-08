<?php


// générer un style en ligne pour certaines classes ou identifiants
require_once CDAF_DIR_PATH . 'includes/cdaf-inline-style.php';

add_action( 'wp_enqueue_scripts', 'cdaf_divi_enqueue_scripts' );

function cdaf_divi_enqueue_scripts() {
	
	if ( wp_basename( get_bloginfo( 'template_directory' ) ) == 'Divi' ) {
		wp_enqueue_style( 'cdaf-styles', plugins_url( '', __FILE__ ) . '/css/clea-divi-add-functions.css' );

	}
}

?>