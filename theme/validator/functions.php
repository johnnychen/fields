<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
*/


function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'fields2rules',
		'from' => 'field',
		'to' => 'rule',
		'fields' => array(

			'params' => array(
				'title' => '参数',
				'type' => 'text',
				// 'default_cb' => 'default_cb_zh_tw'
			)
		)
	) );
}
add_action( 'p2p_init', 'my_connection_types' );


/**
 * Define default terms for custom taxonomies in WordPress 3.0.1
 *
 * @author    Michael Fields     http://wordpress.mfields.org/
 * @props     John P. Bloch      http://www.johnpbloch.com/
 * @props     Evan Mulins        http://circlecube.com/
 *
 * @since     2010-09-13
 * @alter     2013-01-31
 *
 * @license   GPLv2
 */

function mfields_set_default_object_terms( $post_id, $post ) {
    if ( 'publish' === $post->post_status) {
        $defaults = array(
            'field_category' => array( 'uncategorized' ),
            'field_tag' => array( 'untaged' ),
            'field_type' => array( 'untyped' ),
			'rule_type' => array( 'untyped')
        );
        $taxonomies = get_object_taxonomies( $post->post_type );

        foreach ( (array) $taxonomies as $taxonomy ) {
		
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
    }
}

add_action( 'save_post', 'mfields_set_default_object_terms', 100, 2 );



require_once dirname( __FILE__ ) . '/functions/adminbar.php';
require_once dirname( __FILE__ ) . '/functions/utils.php';
require_once dirname( __FILE__ ) . '/functions/ajax-save-form-page.php';
require_once dirname( __FILE__ ) . '/functions/i18n.php';
require_once dirname( __FILE__ ) . '/functions/rule.php';
require_once dirname( __FILE__ ) . '/functions/field.php';
require_once dirname( __FILE__ ) . '/functions/form-page.php';

// require_once dirname( __FILE__ ) . '/functions/duoshuo.php';

?>