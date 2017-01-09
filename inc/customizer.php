<?php

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function identityexperts_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'identityexperts_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'identityexperts_customize_partial_blogdescription',
	) );

	/**
	 * Theme options.
	 */
	$wp_customize->add_section( 'theme_options', array(
		'title'    => __( 'Theme Options', 'identityexperts' ),
		'priority' => 130, // Before Additional CSS.
	) );


	$wp_customize->add_setting( 'contact_number', array(
		'default'           => '03333 444950',
		'sanitize_callback' => 'identityexperts_sanitize_contact_number',
		'transport'         => 'postMessage',
	) );


	$wp_customize->add_control( 'contact_number', array(
		'label'       => __( 'Contact Number', 'identityexperts' ),
		'section'     => 'theme_options',
		'type'        => 'text',
		'description' => __( 'Contact phone number.', 'identityexperts' ),
		'active_callback' => 'identityexperts_contact_number_option',
	) );

	$wp_customize->add_setting( 'contact_email', array(
		'default'           => 'info@identityexperts.co.uk',
		'sanitize_callback' => 'identityexperts_sanitize_contact_email',
		'transport'         => 'postMessage',
	) );


	$wp_customize->add_control( 'contact_email', array(
		'label'       => __( 'Contact Email', 'identityexperts' ),
		'section'     => 'theme_options',
		'type'        => 'text',
		'description' => __( 'Contact email address.', 'identityexperts' ),
		'active_callback' => 'identityexperts_contact_email_option',
	) );

	$wp_customize->add_setting( 'contact_address', array(
		'default'           => 'Identity Experts, Media Centre, Huddersfield, HD1 1RL',
		'sanitize_callback' => 'identityexperts_sanitize_contact_address',
		'transport'         => 'postMessage',
	) );


	$wp_customize->add_control( 'contact_address', array(
		'label'       => __( 'Contact Address', 'identityexperts' ),
		'section'     => 'theme_options',
		'type'        => 'textarea',
		'description' => __( 'Contact Address.', 'identityexperts' ),
		'active_callback' => 'identityexperts_contact_address_option',
	) );

}
add_action( 'customize_register', 'identityexperts_customize_register' );


function identityexperts_sanitize_contact_number( $input ) {
	return esc_html($input);
}

function identityexperts_sanitize_contact_email( $input ) {
	return esc_html($input);
}
function identityexperts_sanitize_contact_address( $input ) {
	return esc_html($input);
}


function identityexperts_customize_partial_blogname() {
	bloginfo( 'name' );
}

function identityexperts_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function identityexperts_contact_number_option() {
	return '';
}

function identityexperts_contact_email_option() {
	return '';
}
function identityexperts_contact_address_option() {
	return true;
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function identityexperts_customize_preview_js() {
	wp_enqueue_script( 'identityexperts-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'identityexperts_customize_preview_js' );
