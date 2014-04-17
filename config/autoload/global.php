<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

// Used for table prefix with Doctrine
//define('PREFIX', (string) 'mbo_');
define('PREFIX', (string) '');

//Force the server to use this timezone
date_default_timezone_set('Europe/Paris');  

return array(
    'service_manager' => array(
	    'factories' => array(
	        'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
	    ),
	)
);
