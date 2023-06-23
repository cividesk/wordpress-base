<?php
/*
Plugin Name: CiviDesk Plugin
Description: This plugin integrates a WordPress website in the Cividesk environment
Version: 1.0
Authors: (c) IT Bliss, LLC ; 2019
*/

$uploaddir = wp_upload_dir();
$mailerlog = $uploaddir['path'] . '/phpmailer_log';

function cividesk_settings() {
  // Disable the Nag of PHP upgrade
  remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'cividesk_settings' );

// Send emails through the Cividesk mailer
function cividesk_mailer( &$phpmailer ) {
  file_put_contents($mailerlog, "Hook called" . PHP_EOL, FILE_APPEND);
  $phpmailer->isSMTP();
  $phpmailer->Host       = $_SERVER['SMTP_HOST'];
  $phpmailer->Port       = $_SERVER['SMTP_PORT'];
  $phpmailer->SMTPAuth   = true;  // Force it to use Username and Password to authenticate
  $phpmailer->Username   = $_SERVER['SMTP_USER'];
  $phpmailer->Password   = $_SERVER['SMTP_PASS'];
  $phpmailer->From       = isset($_SERVER['SMTP_FROM']) ? $_SERVER['SMTP_FROM'] : $_SERVER['SMTP_USER'];
  $phpmailer->FromName   = "Website Communications";
  $phpmailer->SetFrom( $phpmailer->From, $phpmailer->FromName );
  $phpmailer->SMTPAutoTLS = false;

  $phpmailer->Debugoutput = function($str, $level) {
    file_put_contents($mailerlog, "$level: $str", FILE_APPEND);
  };
  $phpmailer->SMTPDebug = 1;
}
add_action( 'phpmailer_init', 'cividesk_mailer', 999 );
file_put_contents($mailerlog, "Hook loaded" . PHP_EOL, FILE_APPEND);
