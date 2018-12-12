# scorpiotek-acf-protected-uploads
This plugin will protect the ACF file uploads that your specify, requires a bit of configuration.

# Instructions

## Securing WordPress ACF Uploads

1. Install ACF
2. Get a copy of the plugin: https://github.com/csaborio001/scorpiotek-acf-protected-uploads
3. Activate the plugin.
4. Create the following entry in your .htaccess file:

``` apacheconf
# Protect all files within the specified folder folder
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} ^(.*?/?)wp-content/lmE8DHbI3sxrdONFj/.* [NC]
    RewriteCond %{REQUEST_URI} !orbisius_media_protector [NC]
    RewriteRule . %1/?orbisius_media_protector=%{REQUEST_URI} [L,QSA]
</IfModule>
```

Make sure you replace wp-content/SECRET_FOLDER_NAME/ with the name of the folder that you wish to protect.

5. Inside your functions.php file write the following code that will make sure that only logged-in users will be able to access any file inside the secret folder:

``` php
use ScorpioTek\WordPress\Util\Security\MediaUploadProtector;
use ScorpioTek\WordPress\Util\Security\ACFUploadProtector;
// Use your preferred secret folder name below, must match the same name as the one on .htaccess file.
$secret_folder_name = 'lmE8DHbI3sxrdONFj';

 if ( class_exists( MediaUploadProtector::class ) ) {
	$secret_folder_path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $secret_folder_name;
	$prot_obj = new MediaUploadProtector ( $secret_folder_path );
	add_action( 'init', [ $prot_obj, 'protect_uploads' ], 0 );
 }
```

6. Use the following code to specify which ACF fields will be protected:

``` php
if ( class_exists( ACFUploadProtector::class ) ) {
	$acf_upload_protector = new ACFUploadProtector( $secret_folder_name, WP_CONTENT_DIR, WP_CONTENT_URL );
// name = find the field by field name, 	my_upload_file = your ACF field name.
$acf_upload_protector->protect_upload( 'name', 'my_upload_file' );
// Keep adding all fields you want protected using the previous line as an example.
}

```

8. Upload a file using the ACF file url.
9. Copy the file’s URL.
10. Try to access it from a private browser window, you will be redirected to the web’s home page.

## Version History

1.0.1 - December 12, 2018
-- 
* Changed constructor of the orbisius_wp_media_uploads_protector class so that it accepts the directory path that needs to be protected.
* Changed the code structure so that the MediaUploadProtector no longer needs to be inside mu-plugins.
* Changed class names and function names to make them more descriptive.

1.0
--
* Initial version, cleaned up code and made it more versatile as to not depend on hard coded paths.


