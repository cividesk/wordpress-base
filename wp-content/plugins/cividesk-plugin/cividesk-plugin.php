<?php
/*
Plugin Name: CiviDesk Plugin
Description: This plugin is created by Cividesk to handle the operation for all there customers
Version:      1.0
Author: Sachin Doijad
*/

// Disable the Nag of PHP upgrade
function wcs_disable_php_upgrade_warning() {
    remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'wcs_disable_php_upgrade_warning' );

?>
