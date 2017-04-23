<?php
add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {
    // Start with an underscore to hide fields from custom fields list
    $prefix = '_cristy_meta_';
    /**
     * Initiate the metabox
     */
	$cmb_th = new_cmb2_box( array(
	    'id'           => 'template_header',
	    'title'        => 'Template Header',
	    'object_types' => array( 'page', 'post' ), // post type
	    'context'      => 'side', //  'normal', 'advanced', or 'side'
	    'priority'     => 'high',  //  'high', 'core', 'default' or 'low'
	    'show_names'   => true, // Show field names on the left
	) );
	$cmb_th->add_field( array(
		'name'    => 'Style',
		'id'      => 'header_style',
		'type'    => 'radio_inline',
		'options' => array(
			'none' => __( 'None', 'cmb2' ),
			'page-header-1'   => __( 'Style 1', 'cmb2' ),
			'page-header-2'     => __( 'Style 2', 'cmb2' ),
		),
		'default' => 'page-header-1',
	) );
	$cmb_th->add_field( array(
		'name'    => 'Background',
		'id'      => 'header_bg',
		'type'    => 'radio_inline',
		'options' => array(
			'none' => __( 'None', 'cmb2' ),
			'color'   => __( 'Color ', 'cmb2' ),
			'image'     => __( 'Image', 'cmb2' ),
			'video'     => __( 'Video', 'cmb2' ),
		),
		'default' => 'none',
		'attributes'       => array(
			'required'       => 'required',
		),
	) );
	$cmb_th->add_field( array(
		'name'       => 'Background color',
		'id'         => 'header_bg_color',
		'type'    => 'radio_inline',
		'options' => array(
			'light'   => __( 'Light ', 'cmb2' ),
			'med-light'     => __( 'Medium Light', 'cmb2' ),
			'mid-dark'     => __( 'Medium Dark', 'cmb2' ),
			'dark'     => __( 'Dark', 'cmb2' ),
		),
		'attributes' => array(
			'data-conditional-id'    => 'header_bg',
			'data-conditional-value' => 'color',
		),
		'default' => 'none',
	) );
	$cmb_th->add_field( array(
		'name'       => 'Background image',
		'id'         => 'header_bg_image',
		'type'       => 'file',
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'header_bg',
			'data-conditional-value' => 'image',
		),
		'options' => array(
			'url' => false, 
		),
	) );
	$cmb_th->add_field( array(
		'name'       => 'Background video',
		'id'         => 'header_bg_video',
		'type'       => 'file_list',
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'header_bg',
			'data-conditional-value' => 'video',
		)
	) );
	$cmb_th->add_field( array(
		'name'       => 'Background overlay',
		'id'         => 'header_bg_overlay',
		'type'    => 'radio_inline',
		'options' => array(
			'light'   => __( 'Light ', 'cmb2' ),
			'med-light'     => __( 'Medium Light', 'cmb2' ),
			'mid-dark'     => __( 'Medium Dark', 'cmb2' ),
			'dark'     => __( 'Dark', 'cmb2' ),
		),
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'header_bg',
			'data-conditional-value' => wp_json_encode( array( 'image', 'video' ) ),
		),
		'default' => 'none',
	) );

	$cmb_th->add_field( array(
		'name'             => 'Parallax',
		'id'               => 'parallax',
		'type'             => 'radio_inline',
		'show_option_none' => false,
		'options'          => array(
			'on' => __( 'On', 'cmb2' ),
			'off'   => __( 'Off', 'cmb2' ),
		),
		'default' => 'off',
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'header_bg',
			'data-conditional-value' => wp_json_encode( array( 'image', 'video' ) ),
		)
	) );
	$cmb_th->add_field( array(
		'name'       => 'Parallax Fraction',
		'id'         => 'parallax_frac',
		'type'       => 'text',
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'parallax',
			'data-conditional-value' => 'on',
		)
	) );
	$cmb_th->add_field( array(
		'name'       => 'Parallax Direction',
		'id'         => 'parallax_direction',
		'type'       => 'text',
		'attributes' => array(
			//'required' => true, 
			'data-conditional-id'    => 'parallax',
			'data-conditional-value' => 'on',
		)
	) );

	$cmb = new_cmb2_box( array(
	    'id'           => 'sidebar_metabox',
	    'title'        => 'Template Layout',
	    'object_types' => array( 'page', 'post' ), // post type
	    'context'      => 'side', //  'normal', 'advanced', or 'side'
	    'priority'     => 'high',  //  'high', 'core', 'default' or 'low'
	    'show_names'   => true, // Show field names on the left
	) );
	$cmb->add_field( array(
		'name'    => 'Template',
		'id'      => 'template_layout',
		'type'    => 'radio_inline',
		'options' => array(
			'full' => __( 'Full width', 'cmb2' ),
			'container'   => __( 'Container', 'cmb2' ),
			'box'     => __( 'Container box', 'cmb2' ),
		),
		'default' => 'container',
	) );
	$cmb->add_field( array(
		'name'    => 'Sidebar',
		'id'      => 'sidebar',
		'type'    => 'radio_inline',
		'options' => array(
			'none' => __( 'No sidebar', 'cmb2' ),
			'left'   => __( 'Left Sidebar', 'cmb2' ),
			'right'     => __( 'Right Sidebar', 'cmb2' ),
			'left-dual'   => __( 'Left 2 Sidebar', 'cmb2' ),
			'right-dual'     => __( 'Right 2 Sidebar', 'cmb2' ),
			'left-right'     => __( 'Left + Right Sidebar', 'cmb2' ),
		),
		'default' => 'right',
	) );
	$cmb->add_field( array(
	    'name'             => 'Sidebar Left',
	    'id'               => 'sidebar_left',
	    'type'             => 'select',
	    'default'          => 'sidebar-left',
    	'options_cb' => 'show_cat_or_dog_options',
	) );
	$cmb->add_field( array(
	    'name'             => 'Sidebar Right',
	    'id'               => 'sidebar_right',
	    'type'             => 'select',
	    'default'          => 'sidebar-right',
    	'options_cb' => 'show_cat_or_dog_options',
	) );










}
// Callback function
function show_cat_or_dog_options( $field ) {
	$sidebars = array();
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$sidebars[$sidebar['id']] = $sidebar['name'];
	}
	return $sidebars;
}