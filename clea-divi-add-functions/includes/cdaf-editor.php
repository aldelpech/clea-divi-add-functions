<?php



/*	
	$cdaf_colors = cdaf_read_color_palette() ; 
	$cdaf_nb_color = count( $cdaf_colors ) ;
	$index = 1 ;
	$custom_colours =  "'";

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


function cdaf_editor_colors($init) {

	// https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
    /* $custom_colours = '
        "3366FF", "Color 1 name",
        "CCFFCC", "Color 2 name",
        "FFFF00", "Color 3 name",
        "99CC00", "Color 4 name",
        "FF0000", "Color 5 name",
        "FF99CC", "Color 6 name",
        "CCFFFF", "Color 7 name"
    ';
*/


	$cdaf_colors = cdaf_read_color_palette() ; 
	$cdaf_nb_color = count( $cdaf_colors ) ;
	$index = 0 ;
	$default_colors =  array();

	foreach ( $cdaf_colors as $color ) {
		
		// remove # in color code
		$color = ltrim( $color, "#" ) ;
		// met en majuscule le code HEX
		$color = strtoupper( $color );
		$default_colors[] = array( $color, 'color ' . $index  )  ;
		
		$index++ ; 						
	}
	
$custom_colours = wp_json_encode( $default_colors ) ;
$replace = array( "[", "]") ; // we don't want these in the final string
$custom_colours = str_replace($replace, "", $custom_colours );
// $custom_colours = "'" . $custom_colours . "'" ;


$custom_colours_a = '"423432","color 0","FFFFFF","color 1","4C858D","color 2","ED693B","color 3","F28A2B","color 4","FAC079","color 5","F6DB6B","color 6","A60F65","color 7"' ;

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 1;

	// debug 
	echo "<p>" . $custom_colours . "</p>" ;
	echo "<p>A " . $custom_colours_a . "</p>" ;
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