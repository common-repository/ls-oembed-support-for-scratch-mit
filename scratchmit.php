<?php

/*
  Plugin Name: LS oEmbed support for Scratch Mit
  Plugin URI:
  Description:  Add oEmbed support for https://scratch.mit.edu projects in WordPress posts, pages and custom post types.
  Tags: scratch, scratch mit, education
  Version: 2.0
  Requires at least: WordPress  4.0
  Tested up to: WordPress 6.1
  Author: lenasterg, NTS on CTI.gr
  Author URI:
  Text Domain: ls_scratch
  Domain Path: /languages/
  Last Updated: October 24, 2022
  License: GNU/GPL 3
 */

add_action( 'plugins_loaded', 'ls_scratch_i18n_init' );

function ls_scratch_i18n_init() {
    load_plugin_textdomain('ls_scratch', false, plugin_basename(dirname(__FILE__)) . '/languages/');
}

/**
 * Add scratch support
 * @version 1, stergatu
 */
wp_embed_register_handler( 'ls_scratch', '/^(http|https):\/\/scratch.mit.edu\/projects\/(\w+)/', 'ls_wp_embed_handler_scratch' );

function ls_wp_embed_handler_scratch( $matches, $attr, $url, $rawattr ) {
    $args = wp_embed_defaults() ;
   	if ($args['width'] >=485 )
	{
		$width='485';
		$height ='402';
	}
	else {
		$width=$args['width'] ;
		$height = round( $width * 402 / 485 );
	}
 
	$embed = '<div align="center">
		<iframe allowtransparency="true" width="' . $width . '" height="' . $height . '" src="//scratch.mit.edu/projects/embed/' . $matches[2] . '/?autostart=false" '
	    . 'scrolling="no" frameborder="0" '
            . 'allowtransparency="true" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>'
	    . '	<br/><a href="' . $url . '">' . __('View it at scratch.mit.edu', 'ls_scratch') . '</a>
		</div>';
		    return apply_filters( 'ls_embed_scratch', $embed, $matches, $attr, $url, $rawattr );
}

