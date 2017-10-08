<?php


function cdaf_editor_colors($init) {

	// heavily modified code coming from https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
	
	$cdaf_colors = cdaf_read_color_palette() ; // an array of hex codes beginning with #
	$index = 0 ;
	$default_colors =  array();
	
	// what is the link color for text ?
	$accent_color = esc_html( et_get_option( 'accent_color', '#2ea3f2' ) );
	$link_color = et_get_option( 'link_color', $accent_color );
	// remove # in color code
	$link_color = ltrim( $link_color, "#" ) ;
	// met en majuscule le code HEX
	$link_color = strtoupper( $link_color );		

	// transformer en array avec code hex sans # et nom sous forme "color n"
	foreach ( $cdaf_colors as $color ) {

		// remove # in color code
		$color = ltrim( $color, "#" ) ;
		// met en majuscule le code HEX
		$color = strtoupper( $color );	

		if ( !( $link_color == $color ) ) {

			// the text color palette should not include the link color
			$default_colors[] = array( $color, 'color ' . $index  )  ;
			
			$index++ ; 			
		
		}
					
	}
	
	// the only way I found to have a string which works....
	// the string shoulr be like this : '"423432","color 0","FFFFFF","color 1","4C858D","color 2","ED693B","color 3","F28A2B","color 4","FAC079","color 5","F6DB6B","color 6","A60F65","color 7"' 
	$custom_colours = wp_json_encode( $default_colors ) ;
	$replace = array( "[", "]") ; // we don't want these in the final string
	$custom_colours = str_replace($replace, "", $custom_colours );

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 1;

	// debug will echo in the footer of the editor ! 
	//echo "<p>" . $custom_colours . "</p>" ;

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