<?php

if ( ! function_exists( 'one_page_express_parse_eff' ) ) {
	function one_page_express_parse_eff( $text ) {
		if ( is_customize_preview() ) {
			return $text;
		}

		$matches = array();

		preg_match_all( '/\{([^\}]+)\}/i', $text, $matches );

		$alternative_texts = get_theme_mod( "one_page_express_header_text_morph_alternatives", "" );
		$alternative_texts = preg_split( "/[\r\n]+/", $alternative_texts );

		for ( $i = 0; $i < count( $matches[1] ); $i ++ ) {
			$orig    = $matches[0][ $i ];
			$str     = $matches[1][ $i ];
			$strings = explode( "|", $str );
			if ( count( $alternative_texts ) ) {
				$str = json_encode( array_merge( $strings, $alternative_texts ) );
			}
			$text = str_replace( $orig, '<span data-text-effect="' . esc_attr( $str ) . '">' . $strings[0] . '</span>', $text );
		}

		return $text;
	}
}