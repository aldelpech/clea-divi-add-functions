<?php

add_action( 'wp_enqueue_scripts', 'cdaf_divi_inline_style' );


// create inline style
function cdaf_divi_inline_style() {
	if ( wp_basename( get_bloginfo( 'template_directory' ) ) == 'Divi' ) {
		
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



