<?php
/*
  Plugin Name: Banking Plugin
  Description: Custom registration and fund transfer form using shortcode and script as well
  Version: 1.x
  Author: Daniel Mabadeje
  Author URI: https://danielmabadeje.netlify.app
 */


 






if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}



require_once('config/config.php');
require_once('model/Database.php');
// require_once('model/User.php');
require_once('helpers/helper.php');


require_once('admin/editUser.php');
require_once('admin/getUser.php');

require_once('user/register.php');
require_once('user/login.php');
require_once('user/transfer.php');
require_once('user/transactionhistory.php');





