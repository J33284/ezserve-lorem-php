<?php 
	error_reporting(E_ALL);
	session_start();
	define( 'ROOT_DIR', realpath(dirname(__FILE__)) ); 	
	define( 'DIR', ( ( dirname( $_SERVER[ 'PHP_SELF' ] ) == "/" ) ? "" : dirname( $_SERVER['PHP_SELF']) ) ); // directory name
	define( 'SITE_URL', ( isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : "http://") . $_SERVER['SERVER_NAME'] . ( isset( $_SERVER[ 'SERVER_PORT' ] ) ? ":" . $_SERVER[ 'SERVER_PORT' ] : "") . DIR ); 
	define('DS', DIRECTORY_SEPARATOR);
	define( 'ACCESS', true );		
	
	
	require 'config.php';	
	require 'init.php';
	require 'functions.php';	
	require 'authentication.php';	
	require 'actions.php';			
	require 'page.php';
	
	if( $DB )
	$DB->close();

?>

	