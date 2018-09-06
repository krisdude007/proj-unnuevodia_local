<?php
// change the following paths if necessary
$yii='/var/www/yii/framework/yii.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

Yii::setPathOfAlias('client',dirname(__FILE__).'/protected');
Yii::setPathOfAlias('core',dirname(__FILE__).'/core/protected');

$config = dirname(__FILE__).'/protected/config/console.php';

$app = Yii::createConsoleApplication($config);

$app->run();
