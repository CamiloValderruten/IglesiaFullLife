<?php

define('DB_NAME', 'fulllifechurch');

define('DB_USER', 'iglesiafulllife');

define('DB_PASSWORD', 'sf93mM0aoAU2IvOsH7F8');

define('DB_HOST', 'fulllifechurch.cevfojaxcfyj.us-east-1.rds.amazonaws.com');

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

define('FORCE_SSL_ADMIN', false);

define('WP_HOME','https://beta.fulllifeministry.org');

define('WP_SITEURL','https://beta.fulllifeministry.org');

define('AUTH_KEY',         'c5d04af51a8785c77cfcaae7d0bbfe49772c2aa7');
define('SECURE_AUTH_KEY',  '21efe544100dda2365638fa2c2106c312fe5fe71');
define('LOGGED_IN_KEY',    '2d6a306b68ca40ce42f3cf03acdd2d87b76c97e0');
define('NONCE_KEY',        '94cb6dcc0bde48acb4c3abda635f3c3420296dab');
define('AUTH_SALT',        '9cc40246b00636a9a5f6fcfbc9112bca41a0681a');
define('SECURE_AUTH_SALT', '6a9d6fbcc5179cee93eaac5d5cb728c46982c507');
define('LOGGED_IN_SALT',   '119a7fbb86afc3228effdf17a779299dbcd5466d');
define('NONCE_SALT',       '8a350be1dc4f70c12adbbc36ac5364d39ee68a26');

$table_prefix  = 'wp_';

define('WP_DEBUG', false);

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');