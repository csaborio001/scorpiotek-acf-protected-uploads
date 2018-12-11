<?php
/*
Plugin Name: ScorpioTek ACF Protected Uploads
Description: Protects uploads by saving them to custom directories and encrypting the uploads
Plugin URI:  https://www.scorpiotek.com/plugins/scorpiotek-acf-protected-uploads/
Author:      Christian Saborío
Version:     1.0
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
*/

/* Sources
 * https://www.ractoon.com/2016/08/wordpress-acf-pro-files-field-custom-upload-directory/
 * https://orbisius.com/blog/restrict-access-wordpress-uploads-folder-logged-users-p3662
 * https://www.codediesel.com/php/encrypting-uploaded-files-in-php/
 */


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define('UPLOADS', '/secure-folder');

add_filter( 'acf/upload_prefilter/name=cesaa_upload_file', 'secure_upload_prefilter' );
add_filter( 'acf/load_value/name=cesaa_upload_file', 'secure_files_field_display' );
add_filter( 'acf/prepare_field/name=cesaa_upload_file', 'secure_files_field_display' );

function secure_upload_prefilter( $errors ) {
    add_filter( 'upload_dir', 'secure_upload_directory' );
    return $errors;
}

// add_filter( 'upload_dir', 'secure_upload_directory' );
function secure_upload_directory( $param ) {
        $folder = '/s2member-files';
    
        $param['path'] = WP_PLUGIN_DIR . $folder;
        $param['url'] = WP_PLUGIN_URL . $folder;
        $param['subdir'] = $folder;
        $param['basedir'] = WP_PLUGIN_DIR;
        $param['baseurl'] = WP_PLUGIN_URL;
  
    return $param;
  }

  function secure_files_field_display( $field ) {
    // update paths accordingly before displaying link to file
    add_filter( 'upload_dir', 'secure_upload_directory' );
    return $field;
  }
  








?>