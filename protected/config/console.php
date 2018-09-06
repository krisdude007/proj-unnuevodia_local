<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
require('constants.php');

//require(Yii::getPathOfAlias('core') . '/config/constants.php');
$docroot = dirname(dirname(dirname(__FILE__)));
$config = require_once "env_manager.php";

$client = basename($docroot);
$dev =  '';
if (getenv('YOUTOO_ENVIRONMENT') == "aws-development") {
    $dev = basename(dirname($docroot));
}

return array(
    'commandPath' => Yii::getPathOfAlias('core').'/commands',
    'import' => array(
        'core.models.*',
        'core.components.*',
        'core.components.utilities.*',
        'client.models.*',
    ),
    //'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => ucfirst($client),
    // preloading 'log' component
    'preload' => array('log'),
    'timeZone' => 'America/New_York',
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => "mysql:host={$config->db_host};dbname={$config->db_name}",
            'schemaCachingDuration' => 3600,
            'emulatePrepare' => true,
            'username' => $config->db_user,
            'password' => $config->db_pass,
            'charset' => 'utf8',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'docroot' => $docroot,
        'paths' => array(
            'video' => $docroot. '/uservideos',
        ),
        'video' => array(
            'postExt' => '.mp4',
            'useExtendedFilters' => true,
        ),
        'dev' => $dev,
        'client' => $client,
        'ticker' => array(
            'sleepTime' => 10,
        ),
    ),
);