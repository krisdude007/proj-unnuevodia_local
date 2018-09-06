<?php 
/* @var $this Controller */
$cs = Yii::app()->getClientScript();
$cs->registerCssFile('/webassets/css/reset.css');
$cs->registerCssFile('/webassets/css/jquery.jscrollpane.css');
$cs->registerCssFile('/webassets/css/client.css');
$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/client.js', CClientScript::POS_END);
$cs->registerScript('twitter','!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");',CClientScript::POS_END);
$cs->registerScript('google',"(function(){var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();",CClientScript::POS_END);
Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="shortcut icon" href="/webassets/images/logo.png">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!--[if lt IE 9]><script src="/webassets/vendor/RGraph/excanvas/excanvas.original.js"></script><![endif]-->        
    </head>
    <body>
        <div id="fb-root"></div>
        <div class="main">
                <div class="nav">
                    <div class="navMessage">Please fill out the following information to create your account.</div>
                </div>     
                <div id="content">
                <?php echo $content; ?>                
                </div>
                <div id="footer">
                    Youtoo Technologies, US Pat. No. 8,311,382 and/or patents pending                    
                </div>                
        </div>
    </body>
</html>