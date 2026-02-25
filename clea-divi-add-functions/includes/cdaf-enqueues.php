<?php


// générer un style en ligne pour certaines classes ou identifiants
// require_once CDAF_DIR_PATH . 'includes/cdaf-inline-style.php';

add_action( 'wp_enqueue_scripts', 'cdaf_divi_enqueue_scripts' );

function cdaf_divi_enqueue_scripts() {
	
	if ( wp_basename( get_bloginfo( 'template_directory' ) ) == 'Divi' ) {
		/* wp_enqueue_style( 'gf-divi-styles', plugins_url( '', __FILE__ ) . '/css/gf-divi.css' ); */
		wp_enqueue_style( 'cdaf-stylesheet', CDAF_DIR_URL . 'css/clea-divi-add-functions.css' );
		
		$accent_color = esc_html( et_get_option( 'accent_color', '#2ea3f2' ) );
		// sanitize_hex_color vérifie que la valeur ressemble bien à #FFFFFF.
		$link_color = sanitize_hex_color( et_get_option( 'link_color', '#2ea3f2' ) );
		
		// there must be an extra } at the end of the custom_css string...
		$custom_css = "#left-area .post-meta a[rel='category tag'] { color: {$link_color} !important; }"; 
		wp_add_inline_style( 'cdaf-stylesheet', wp_strip_all_tags( $custom_css ) );
	}
}
?>
