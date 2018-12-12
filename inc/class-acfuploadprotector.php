<?php

namespace ScorpioTek\WordPress\Util\Security;

class ACFUploadProtector {

    private $folder;
    private $base_directory;
    private $base_url;

    public function __construct( $protected_upload_directory_name, $base_directory, $base_url ) {
        $this->folder = $protected_upload_directory_name;
        $this->base_directory = $base_directory;
        $this->base_url = $base_url;
    }

    public function protect_upload( $field_protection_type, $field_identifier ) {
        switch ( $field_protection_type ) {
            case 'name':
                add_filter( 'acf/upload_prefilter/name=' . $field_identifier, array( $this, 'secure_upload_prefilter' ) );
                add_filter( 'acf/load_value/name=' . $field_identifier, array( $this, 'secure_files_field_display' ) );
                add_filter( 'acf/prepare_field/name=' . $field_identifier, array( $this, 'secure_files_field_display' ) );
                break;
            
            default:
                # code...
                break;
        }

    }

    public function secure_upload_prefilter( $errors ) {
        add_filter( 'upload_dir', array( $this, 'secure_upload_directory' ) );
        return $errors;
    }

    public function secure_files_field_display( $field ) {
        // update paths accordingly before displaying link to file
        add_filter( 'upload_dir', array( $this, 'secure_upload_directory' ) );
        return $field;
    }    

    public function secure_upload_directory( $param ) {
        $folder = $this->get_folder();
        $param['path'] = $this->get_base_directory() . '/' . $folder;
        $param['url'] = $this->get_base_url() . '/' . $folder;
        $param['subdir'] = $folder;
        $param['basedir'] = $this->get_base_directory();
        $param['baseurl'] = $this->get_base_url();
        return $param;
    }    

    public function set_folder($folder) {
        $this->_folder = $folder;
    }
    public function get_folder() {
            return $this->folder;
    }

    public function set_base_directory($base_directory) {
        $this->_base_directory = $base_directory;
    }
    public function get_base_directory() {
            return $this->base_directory;
    }

    public function set_base_url($base_url) {
        $this->_base_url = $base_url;
    }
    public function get_base_url() {
            return $this->base_url;
    }
}




