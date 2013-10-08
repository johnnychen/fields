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

function form_custom_post_types(){
	
	register_post_type('i18n', array(
						'public'=>true,
						'labels' => array('name'=>'I18ns', 'singular_name'=>'I18n')
						));
	register_post_type('rule', array(
						'public'=>true,
						'labels' => array('name'=>'Rules', 'singular_name'=>'Rule')
						));
	register_post_type('field', array(
						'public'=>true,
						'labels' => array('name'=>'Fields', 'singular_name'=>'Field')
						));
	register_post_type('form-page', array(
						'public'=>true,
						'labels' => array('name'=>'Form Pages', 'singular_name'=>'Form Page')
						));
	
	register_taxonomy(
		'rule_tag','rule',
		array(
			'show_admin_column' => true,
			'labels' => array(
				'name'                       => 'Rule Tags',
				'singular_name'              => 'Rule Tag'
			)
		)
	);
	register_taxonomy(
		'rule_type','rule',
		array(
			'show_admin_column' => true,
			'labels' => array(
				'name'                       => 'Rule Types',
				'singular_name'              => 'Rule Type'
			)
		)
	);
	register_taxonomy(
		'field_tag','field',
		array(
			'show_admin_column' => true,
			'labels' => array(
				'name'                       => 'Field Tags',
				'singular_name'              => 'Field Tag'
			)
		)
	);
	register_taxonomy(
		'field_type','field',
		array(
			'show_admin_column' => true,
			'labels' => array(
				'name'                       => 'Field Types',
				'singular_name'              => 'Field Type'
			)
		)
	);
	
}
add_action('init', 'form_custom_post_types');

function form_connection_types() {
	
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
add_action( 'p2p_init', 'form_connection_types' );


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