<?php
/* @var $this Controller */
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseurl . '/webassets/css/reset.css');
$cs->registerCssFile(Yii::app()->request->baseurl . '/webassets/css/jquery.jscrollpane.css');
$cs->registerCssFile(Yii::app()->request->baseurl . '/webassets/css/client.css');
$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/js/client.js', CClientScript::POS_END);
$cs->registerScript('twitter', '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");', CClientScript::POS_END);
$cs->registerScript('google', "(function(){var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();", CClientScript::POS_END);
$cs->registerScript('googleanalytics',"var _gaq=_gaq||[];_gaq.push(['_setAccount', 'UA-25950024-1']);_gaq.push(['_setDomainName', 'youtoo.com']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();", CClientScript::POS_END);
if(!Yii::app()->user->isGuest){
    $cs->registerScript('crawlInterval','crawl = setInterval(crawler,'.(Yii::app()->params['ticker']['sleepTime']*1000).');',CClientScript::POS_READY);
}
Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
FacebookUtility::setOGTags($this);
Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
if (Yii::app()->params['twitter']['renderTwitterMetaTags']):
TwitterUtility::renderCardMetaTags($this); // this renders the twitter tags
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo defined('HTML_DIR')?"dir='".HTML_DIR."'":'' ?> <?php echo "lang='".Yii::app()->language."'" ?>>
    <head>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseurl; ?>/webassets/images/logo.png">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="language" content="en" />
             <title><?php echo CHtml::encode($this->pageTitle); ?></title>
            <!--[if lt IE 9]><script src="/webassets/vendor/RGraph/excanvas/excanvas.original.js"></script><![endif]-->
    </head>
    <body id="<?php echo Yii::app()->controller->id.'-'.Yii::app()->controller->action->id; ?>">
         <div id="fb-root"></div>

            <?php $flashMessages = Yii::app()->user->getFlashes();?>
        <div id="popupWrap" <?php echo ($flashMessages) ? "style='display:block'" : '';?>>
            <div class="flashes">
                <div id="popupClose">x</div>
                <?php
                if ($flashMessages) {
                    $messageFormat = '<div class="flash-%s">%s</div></div>';
                    foreach($flashMessages as $key => $message) {
                        echo sprintf($messageFormat,$key,$message);
                    }
                }
                ?>
            </div>
        </div>
        <div class="main">
                <!--<div id="userHeader">
                    <div id="userHeaderData">
                        <div id="userHeaderRight">
                            <div id="userHeaderTicker">
                                <div id="userHeaderTickerBox">
                                    <div style="float:left; padding-right:14px;">
                                        <img id="tickerCrawlImage" style="height:35px;width:35px;" src="" />
                                    </div>
                                    <div style="float:left">
                                        <div id="tickerCrawlId" style="font-weight:bold; margin-right: 10px;"></div>
                                        <div id="tickerCrawlText" style="font-size:15px;float: left;text-align:left;text-overflow:ellipsis;padding-right:10px;"></div>
                                    </div>
                                </div>
                                <div id="<?php //echo (!Yii::app()->user->isGuest) ? showTickerFormTrigger : showTickerFormLogin;?>" style="width:58px; height:58px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->


            <?php if (!Yii::app()->user->isGuest): ?>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'ticker-form',
                    'enableAjaxValidation' => false,
                    'action' => Yii::app()->createUrl('/ticker/save'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'validateOnType' => false,
                    ),
                        ));
                ?>

                <div id="userHeaderTickerForm" style="display: none">
                    <div id="userHeaderTickerAnimation">
                        <div style="float:left;">
                            <?php echo $form->textField($this->ticker, 'ticker', array('id' => 'tickerTextField')); ?>
                            <?php echo $form->error($this->ticker, 'ticker'); ?>
                        </div>
                        <div class="right" style="float:left; margin-top:16px; margin-left:5px; margin-right:10px;">
                            <?php echo CHtml::submitButton('ENVIAR', array('id' => 'addTickerTrigger')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            <?php endif; ?>

            <div id="header"></div>
            <div id="nav">
                <div class="tabs" style="margin-top:-1px">
                    <div class="tabHolder" id="homeTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/">
                            <h4 class="navText"><img style="overflow:visible; padding-right:10px;" src="<?php echo Yii::app()->request->baseurl; ?>/webassets/images/Icon_Home.png" />inicio</h4>
                        </a>
                    </div>
                    <div class="tabHolder" id="recordTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/questions">
                            <h4 class="navText">graba</h4>
                        </a>
                    </div>
                    <div class="tabHolder" id="tickerTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/ticker">
                            <h4 class="navText">actividad social</h4>
                        </a>
                    </div>
                    <div class="tabHolder" id="videosTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/videos/recent">
                            <h4 class="navText">videos</h4>
                        </a>
                    </div>
                    <div class="tabHolder" id="photosTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/images/recent">
                            <h4 class="navText">fotos</h4>
                        </a>
                    </div>
                    <div class="tabHolder" id="pollTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/vote">
                            <h4 class="navText">votacíon</h4>
                        </a>
                    </div>
                    <div class="tabHolder" style="border:0px;" id="youTab">
                        <a class="tab" href="<?php echo Yii::app()->request->baseurl; ?>/you/recent">
                            <h4 class="navText">mi cuenta</h4>
                        </a>
                    </div>
                    <div class="clearFix"></div>
                </div>
            </div>
            <?php echo $content; ?>
            <div id="footer">
                <div style="font-size:9px">YOUTOO
                <a href="<?php echo Yii::app()->request->baseurl; ?>/youtooterms">TERMS OF USE</a>
                &amp;
                <a href="<?php echo Yii::app()->request->baseurl; ?>/youtooprivacy">PRIVACY POLICY</a>
                &copy; <?php echo date('Y'); ?> Youtoo Technologies, LLC. <a href="http://www.youtootech.com/patentes" target="_blank">youtootech.com/patents</a></div>
            </div>

        </div>
        <?php $this->renderPartial('/csrf/_csrfToken'); ?>
    </body>
</html>