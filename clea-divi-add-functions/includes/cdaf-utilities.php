<?php

/************************************************************************
*
* Read the color palette set in the Divi Options Menu (General Tab)
* Returns an array with the colors 
*
************************************************************************/

function cdaf_read_color_palette() {
	
	$cdaf_color_palette = et_get_option( 'divi_color_palette', false ) ; 
	$return = explode("|", $cdaf_color_palette);
	return $return ;
	
}
