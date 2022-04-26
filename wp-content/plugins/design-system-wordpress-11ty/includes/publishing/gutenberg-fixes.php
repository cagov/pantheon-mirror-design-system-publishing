<?php

// https://github.com/WordPress/gutenberg/issues/38127
remove_filter( 'render_block', 'wp_render_layout_support_flag' );

add_filter( 'render_block', function( $block_content, $block ) {
	if ( $block['blockName'] === 'core/group' ) {
		return $block_content;
	}

    if ( $block['blockName'] === 'core/buttons' ) {
		return $block_content;
	}
	
	return wp_render_layout_support_flag( $block_content, $block );
}, 10, 2 );