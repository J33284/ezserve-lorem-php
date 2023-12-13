<?php

if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

define('AUTH_ID', 'userID');
define('AUTH_NAME', 'username');
define('AUTH_TYPE', 'usertype');
define('AUTH_TOKEN', 'token');

define('LOGIN_REDIRECT', '?page=email_verify');

$restricted_pages['client']['access'] = ['default', 'client_profile'];
$restricted_pages['client']['default_page'] = 'default';

$restricted_pages['business owner']['access'] = ['default', 'owner_business', 'owner_profile'];
$restricted_pages['business owner']['default_page'] = 'default';

$restricted_pages['admin']['access'] = ['default', 'admin_profile'];
$restricted_pages['admin']['default_page'] = 'default';

$restricted_pages['default']['access'] = ['default', 'login', 'register'];
$restricted_pages['default']['default_page'] = 'default';

has_access(true);

?>



