<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package MyLife
 * @subpackage Functions
 * @version 0.3.0
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2011 - 2013, Justin Tadlock
 * @link http://themehybrid.com/themes/my-life
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'my_life_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function my_life_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply', 'drop-downs' ) );
	add_theme_support( 'hybrid-core-styles', array( 'style' ) );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for framework extensions. */
	add_theme_support( 
		'theme-layouts', 
		array( '1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c' ),
		array( 'default' => '2c-l', 'customize' => true )
	);

	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'dev-stylesheet' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'cleaner-caption' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) );

	/* Add support for a custom background. */
	add_theme_support( 
		'custom-background',
		array(
			'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/bg.png',
		)
	);

	/* Add support for a custom header image. */
	add_theme_support(
		'custom-header',
		array(
			'default-image' => 'remove-header',
			'width' => 1000,
			'height' => 200,
			'header-text' => false,
			'wp-head-callback'       => '__return_false',
			'admin-head-callback'    => '__return_false',
		)
	);

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'my_life_embed_defaults' );

	/* Set content width. */
	hybrid_set_content_width( 600 );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'my_life_disable_sidebars' );
	add_action( 'template_redirect', 'my_life_one_column' );

	/* Add classes to the comments pagination. */
	add_filter( 'previous_comments_link_attributes', 'my_life_previous_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'my_life_next_comments_link_attributes' );

	/* Add custom image sizes. */
	add_action( 'init', 'my_life_add_image_sizes' );

	/* Filter the header image on singular views. */
	add_filter( 'theme_mod_header_image', 'my_life_header_image' );

	/* Filters the image/gallery post format archive galleries. */
	add_filter( "{$prefix}_post_format_archive_gallery_columns", 'my_life_archive_gallery_columns' );
}

/**
 * Sets the number of columns to show on image and gallery post format archives pages based on the 
 * layout that is currently being used.
 *
 * @since 0.1.0
 * @param int $columns Number of gallery columns to display.
 * @return int $columns
 */
function my_life_archive_gallery_columns( $columns ) {

	/* Only run the code if the theme supports the 'theme-layouts' feature. */
	if ( current_theme_supports( 'theme-layouts' ) ) {

		/* Get the current theme layout. */
		$layout = theme_layouts_get_layout();

		if ( 'layout-1c' == $layout )
			$columns = 4;

		elseif ( in_array( $layout, array( 'layout-3c-l', 'layout-3c-r', 'layout-3c-c' ) ) )
			$columns = 2;
	}

	return $columns;
}

/**
 * Filter for the "theme_mod_header_image" hook, which returns the header image URL.  This allows the user 
 * to change the header image on a per-post basis by uploading a feature image large enough to display as a
 * header image.
 *
 * @since 0.1.0
 * @param string $url The URL of the current header image.
 * @return string $url
 */
function my_life_header_image( $url ) {

	if ( is_singular() && 'remove-header' !== $url ) {

		$post_id = get_queried_object_id();

		if ( is_attachment() && wp_attachment_is_image( $post_id ) )
			$thumbnail_id = $post_id;

		elseif ( has_post_thumbnail( $post_id ) )
			$thumbnail_id = get_post_thumbnail_id( $post_id );

		if ( !empty( $thumbnail_id ) ) {

			$image = wp_get_attachment_image_src( $thumbnail_id, 'header' );

			if ( $image[1] >= HEADER_IMAGE_WIDTH && $image[2] >= HEADER_IMAGE_HEIGHT )
				$url = $image[0];
		}
	}

	return $url;
}

/**
 * Adds custom image sizes for featured images.  The 'feature' image size is used for sticky posts.
 *
 * @since 0.1.0
 */
function my_life_add_image_sizes() {
	add_image_size( 'header', 1000, 200, true );
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 0.1.0
 */
function my_life_one_column() {

	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		add_filter( 'theme_mod_theme_layout', 'my_life_theme_layout_one_column' );

	elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
		add_filter( 'theme_mod_theme_layout', 'my_life_theme_layout_one_column' );
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since 0.1.0
 * @param string $layout The layout of the current page.
 * @return string
 */
function my_life_theme_layout_one_column( $layout ) {
	return '1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 * @param array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function my_life_disable_sidebars( $sidebars_widgets ) {

	if ( current_theme_supports( 'theme-layouts' ) && !is_admin() ) {

		if ( 'layout-1c' == theme_layouts_get_layout() ) {
			$sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
		}
	}

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function my_life_embed_defaults( $args ) {

	$args['width'] = 600;

	if ( current_theme_supports( 'theme-layouts' ) ) {

		$layout = theme_layouts_get_layout();

		if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
			$args['width'] = 470;
		elseif ( 'layout-1c' == $layout )
			$args['width'] = 808;
	}

	return $args;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 0.1.0
 * @param string $attributes The previous comments link attributes.
 * @return string
 */
function my_life_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 0.1.0
 * @param string $attributes The next comments link attributes.
 * @return string
 */
function my_life_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}


/**
 * Returns a set of image attachment links based on size.
 *
 * @since 0.1.0
 * @return string Links to various image sizes for the image attachment.
 */
function my_life_get_image_size_links() {

	/* If not viewing an image attachment page, return. */
	if ( !wp_attachment_is_image( get_the_ID() ) )
		return;

	/* Set up an empty array for the links. */
	$links = array();

	/* Get the intermediate image sizes and add the full size to the array. */
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	/* Loop through each of the image sizes. */
	foreach ( $sizes as $size ) {

		/* Get the image source, width, height, and whether it's intermediate. */
		$image = wp_get_attachment_image_src( get_the_ID(), $size );

		/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
		if ( !empty( $image ) && ( true === $image[3] || 'full' == $size ) )
			$links[] = "<a class='image-size-link' href='" . esc_url( $image[0] ) . "'>{$image[1]} &times; {$image[2]}</a>";
	}

	/* Join the links in a string and return. */
	return join( ' <span class="sep">/</span> ', $links );
}


/**
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_custom_background_callback() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
	_custom_background_cb();
}

/**
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_body_class() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * Removes 'post-format-' from the taxonomy template name for post formats.
 *
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_taxonomy_template( $template ) {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_clean_post_format_slug() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_register_shortcodes() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_post_format_link_shortcode() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * Returns the output of the [entry-permalink] shortcode.
 *
 * @since 0.1.0
 * @deprecated 0.2.0
 */
function my_life_entry_permalink_shortcode() {
	_deprecated_function( __FUNCTION__, '0.2.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.3.0
 */
function my_life_quote_content() {
	_deprecated_function( __FUNCTION__, '0.3.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.3.0
 */
function my_life_image_content() {
	_deprecated_function( __FUNCTION__, '0.3.0' );
}

/**
 * @since 0.1.0
 * @deprecated 0.3.0
 */
function my_life_get_image_attachment_count() {
	_deprecated_function( __FUNCTION__, '0.3.0', 'post_format_tools_get_image_attachment_count' );
	post_format_tools_get_image_attachment_count();
}

/**
 * @since 0.1.0
 * @deprecated 0.3.0
 */
function my_life_url_grabber() {
	_deprecated_function( __FUNCTION__, '0.3.0', 'post_format_tools_url_grabber' );
	post_format_tools_url_grabber();
}

?>