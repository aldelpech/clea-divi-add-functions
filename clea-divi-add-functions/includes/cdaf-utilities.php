<?php

/************************************************************************
*
* Read the color palette set in the Divi Options Menu (General Tab)
* Returns an array with the colors 
*
************************************************************************/

<?php
defined( 'ABSPATH' ) || exit;

/**
 * Récupère la palette de couleurs Divi sous forme de tableau
 */
function cdaf_read_color_palette() {
    // On utilise esc_html pour s'assurer que la chaîne récupérée est saine
    $palette_string = esc_html( et_get_option( 'divi_color_palette', '' ) );
    if ( empty( $palette_string ) ) {
        return [];
    }
    // Transforme la chaîne "color1|color2|..." en tableau
    return explode( '|', $palette_string );
}
