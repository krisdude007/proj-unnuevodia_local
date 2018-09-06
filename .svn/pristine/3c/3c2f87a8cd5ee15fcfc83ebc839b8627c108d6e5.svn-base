<?php
$cs = Yii::app()->getClientScript();
$cs->scriptMap=array('jquery.min.js'=>false);
$cs->coreScriptPosition = CClientScript::POS_END;
//$cs->registerCoreScript('jquery.yiiactiveform.js');
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/mobile/javascripts/vendor.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/mobile/javascripts/app.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/mobile/javascripts/main.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/mobile/javascripts/client.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/webassets/js/client.js', CClientScript::POS_END);
$cs->registerScript('googleanalytics', "var _gaq=_gaq||[];_gaq.push(['_setAccount', 'UA-25950024-1']);_gaq.push(['_setDomainName', 'youtoo.com']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();", CClientScript::POS_END);
?>
<!DOCTYPE html>
<html>
    <!--<![endif]-->
    <head>
        <!-- @todo figure out a way to automatically change this base href for deployments -->
        <!-- <base href="http://localhost:8888/univision/public/" /> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo Yii::app()->name; ?></title>
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/webassets/mobile/stylesheets/app.css">
        <link rel="stylesheet" href="/webassets/mobile/stylesheets/client.css">
        <?php
        Yii::app()->facebook->initJs($output);
        ?>
    </head>
    <body id="<?php echo Yii::app()->controller->id . '-' . Yii::app()->controller->action->id; ?>">
        <?php
        $flashMessages = Yii::app()->user->getFlashes();
        ?>
        <div id="popupWrap" <?php echo ($flashMessages) ? "style='display:table'" : ''; ?>>
            <div style="display: table-cell;vertical-align: middle;">
                <div class="flashMobile">
                    <div class="flashMobileContents">
                        <?php foreach ($flashMessages as $key => $message): ?>
                            <div class="flash-<?php echo($key) ?>"><?php echo($message) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <p id="fabmob_login-divider" style="border-bottom:grey solid 1px;"></p>
                    <div class="flashMobileButton">
                        <div class='okButton' onclick="$('#popupWrap').toggle();">Ok</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popupConfirm">
            <div style="display: table-cell;vertical-align: middle;">
                <div class="flashMobile">
                    <h3 id="flashMobileHeader"></h3>
                    <div class="flashMobileContents">
                        <div id="popupMessage"></div>
                    </div>
                    <p id="fabmob_login-divider" style="border-bottom:grey solid 1px;"></p>
                    <div class="flashMobileButton">
                        <div class='left-fillbutton' id="contentOk" name="" onclick="flagContent(this);$('#popupConfirm').hide();">Ok</div>
                        <div class='center-fillline'></div>
                        <div class='right-fillbutton' onclick="$('#popupConfirm').hide();">Cancel</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="spinerWrap" style="display: none;">
            <img src="/core/webassets/images/socialSearch/ajaxSpinner.gif" class="spinner">
        </div>
        <div class="snap-drawers">
            <div class="snap-drawer snap-drawer-left">
                <ul id="nav">
                    <li class="userImage" style="background-color: #cbcbcb;"><a style='border-top: 1px solid #cbcbcb;' href="<?php echo Yii::app()->createUrl('you/recent'); ?>"><img class='userAvatarXS' src="<?php echo UserUtility::getAvatar($this->user); ?>" /><span style="color:black;"><?php echo empty($this->user->first_name) ? '' : $this->user->first_name; ?> <?php echo empty($this->user->last_name) ? '' : $this->user->last_name; ?></span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><div class="homeimage"></div><span>Inicio</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('poll/index'); ?>"><div class="pollimage"></div><span>Votación</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('ticker/index'); ?>"><div class="tickerimage"></div><span>Actividad Social</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('questions/'); ?>"><div class="uploadvideo"></div><span>Sube un Video</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('videos/recent'); ?>"><div class="videosimage"></div><span>Vídeos</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('upload/'); ?>"><div class="uploadimage"></div><span>Sube una Foto</span></a></li>
                    <li class="sidebar"><a href="<?php echo Yii::app()->createUrl('images/recent'); ?>"><div class="photosimage"></div><span>Fotos</span></a></li>
                    <li class="sidebar white"><a href="<?php echo Yii::app()->createUrl('site/help'); ?>"><div class="helpimage"></div><span class="graylink">Ayuda</span></a></li>
                    <li class="sidebar white"><a href="<?php echo Yii::app()->createUrl('site/legallinks'); ?>"><div class="legalimage"></div><span class="graylink">Términos y Condiciones</span></a></li>
                    <li class="sidebar white"><a href="<?php echo Yii::app()->createUrl('user/settingLinks'); ?>"><div class="settingimage"></div><span class="graylink">Configuración</span></a></li>
                </ul>
                <?php if (Yii::app()->user->isGuest): ?>
                    <a id="snap-drawer-login-btn" class="btn fabmob_auth-flow-btn" href="/login">Empezar</a>
                <?php else: ?>
                    <a id="snap-drawer-logout-btn" class="btn fabmob_auth-flow-btn" href="/logout">Cerrar la sesión</a>
                <?php endif; ?>
            </div>
        </div>
        <div id="content-container" class="snap-content">
            <div id="toolbar" style="position:relative;">
                <?php if ($this->id == "site"): ?>
                    <?php if ($this->action->id == "aboutlinks"): ?>
                        <a id="open-left" >&nbsp;</a>
                        <h3 class="graylink vertical-middle">Ayuda</h3>
                    <?php elseif ($this->action->id == "legallinks"): ?>
                        <a id="open-left" >&nbsp;</a>
                        <h3 class="graylink vertical-middle">Términos y Condiciones</h3>
                    <?php elseif ($this->action->id == "helplinks"): ?>
                        <a id="open-left" >&nbsp;</a>
                        <h3 class="graylink vertical-middle">Ayuda</h3>
                    <?php elseif ($this->action->id == "about"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Acerca de Youtoo</h3>
                    <?php elseif ($this->action->id == "contact"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Contáctanos</h3>
                    <?php elseif ($this->action->id == "FAQ"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">FAQ</h3>
                    <?php elseif ($this->action->id == "help"): ?>
                        <a id="open-left" >&nbsp;</a>
                        <h3 class="graylink vertical-middle">¿Necesitas ayuda?</h3>
                    <?php elseif ($this->action->id == "more"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Más Información</h3>
                    <?php elseif ($this->action->id == "privacy"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php elseif ($this->action->id == "patents"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php //elseif ($this->action->id == "schedule"): ?>
<!--                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Schedule</h3>-->
                    <?php //elseif ($this->action->id == "show"): ?>
<!--                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Shows</h3>-->
                    <?php elseif ($this->action->id == "terms"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php // elseif ($this->action->id == "watch"): ?>
<!--                        <a id="back-left" onclick='history.go(-1);'></a>
                        <h3 class="graylink vertical-middle">Where to Watch</h3>-->
                    <?php else: ?>
                        <a id="open-left" >&nbsp;</a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php endif; ?>
                <?php elseif ($this->id == "user"): ?>
                    <?php if ($this->action->id == "settingLinks"): ?>
                        <a id="open-left" >&nbsp;</a>
                        <h3 class="graylink vertical-middle"><?php echo Yii::t('youtoo','Configuración de perfil'); ?></h3>
                    <?php elseif ($this->action->id == "profile"): ?>
                        <a id="back-left" href='<?php echo Yii::app()->createUrl('user/settingLinks') ?>'></a>
                        <h3 class="graylink vertical-middle">Información Básica</h3>
                    <?php elseif ($this->action->id == "connections"): ?>
                        <a id="back-left" href='<?php echo Yii::app()->createUrl('user/settingLinks') ?>'></a>
                        <h3 class="graylink vertical-middle">Conéctarte</h3>
                    <?php elseif ($this->action->id == "password"): ?>
                        <a id="back-left" href='<?php echo Yii::app()->createUrl('user/settingLinks') ?>'></a>
                        <h3 class="graylink vertical-middle">Contraseña</h3>
                   <?php elseif ($this->action->id == "photo"): ?>
                        <a id="back-left" href='<?php echo Yii::app()->createUrl('user/settingLinks') ?>'></a>
                        <h3 class="graylink vertical-middle">Foto</h3>
                    <?php else: ?>
                        <a id="open-left" >&nbsp;</a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php endif; ?>
                <?php elseif ($this->id == "video"): ?>
                    <?php if ($this->action->id == "play"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php else: ?>
                        <a id="open-left" >&nbsp;</a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php endif; ?>
                <?php elseif ($this->id == "image"): ?>
                    <?php if ($this->action->id == "view"): ?>
                        <a id="back-left" onclick='history.go(-1);'></a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php else: ?>
                        <a id="open-left" >&nbsp;</a>
                        <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                    <?php endif; ?>
                <?php else: ?>
                    <a id="open-left" >&nbsp;</a>
                    <img src="/webassets/mobile/images/Image_Logo_Header.png" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'"/>
                <?php endif; ?>
            </div>
            <div id="fabmob_view-container" <?php echo (($this->id == "question" && $this->action->id == 'index') || $this->action->id == 'videoupload' || $this->action->id == 'finishUpload') ? 'style="background-color: #d8512b"' : (($this->id == 'poll' && $this->action->id == 'index') ? 'style="background-color: #ec992e"' : ($this->action->id == 'upload' || ($this->id == 'image' && $this->action->id == 'thanks') ? 'style="background-color: #d60000"' : '')); ?>>
                <?php echo $content; ?>
            </div>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        <?php $this->renderPartial('/csrf/_csrfToken'); ?>
    </body>
</html>
