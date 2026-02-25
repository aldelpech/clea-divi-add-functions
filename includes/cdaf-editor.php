<?php
defined( 'ABSPATH' ) || exit;

/**
 * Shortcode pour la date de mise à jour (Affichage conditionnel)
 */
function cdaf_last_modified_date() {
    $u_time = get_the_time('U'); 
    $u_modified_time = get_the_modified_time('U'); 

    if ($u_modified_time > $u_time) {
        // esc_html sécurise la chaîne de caractères avant l'affichage
        return ' | ' . esc_html__( 'Mis à jour le', 'cdaf' ) . ' ' . esc_html(get_the_modified_date('j F Y'));
    }
    
    return ''; // renvoie vide si pas de mise à jour
}
add_shortcode('date_maj', 'cdaf_last_modified_date');

/**
 * Support de la palette Divi dans Gutenberg
 */
function cdaf_gutenberg_colors() {
    $colors = cdaf_read_color_palette();
    if (empty($colors)) return;

    $editor_palette = [];
    foreach ($colors as $index => $hex) {
        $editor_palette[] = [
            'name'  => 'Divi Color ' . ($index + 1),
            'slug'  => 'divi-color-' . ($index + 1),
            'color' => $hex,
        ];
    }
    add_theme_support('editor-color-palette', $editor_palette);
}
add_action('after_setup_theme', 'cdaf_gutenberg_colors');

/**
 * Nettoyage des formats de titre (Suppression H1)
 */
function cdaf_remove_h1_from_editor( $settings ) {
    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
    return $settings;
}
add_filter('tiny_mce_before_init', 'cdaf_remove_h1_from_editor');
