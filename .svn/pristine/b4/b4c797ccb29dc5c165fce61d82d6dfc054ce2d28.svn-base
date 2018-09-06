<?php
error_reporting(E_ERROR);
// change the following paths if necessary
$yii='framework/yii.php';
//Required for php-fpm
set_include_path('/var/www/yii');
require_once($yii);
require('core/protected/YttCore.php');
Yii::setPathOfAlias('client',$_SERVER["DOCUMENT_ROOT"].'/protected');
Yii::setPathOfAlias('core',$_SERVER["DOCUMENT_ROOT"].'/core/protected');
$config = CMap::mergeArray(
    require(dirname(__FILE__).'/core/protected/config/main.php'),
    require(dirname(__FILE__).'/protected/config/main.php')
);
require_once('core/protected/vendor/getid3/getid3.php');
$app = Yii::createApplication('YttCore',$config);
$app->run();