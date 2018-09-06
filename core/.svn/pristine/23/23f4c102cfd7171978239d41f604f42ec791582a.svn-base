<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/_admin.js');
$cs->registerCssFile('/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile('/core/webassets/css/_flashes.css');
$cs->registerScriptFile('/core/webassets/js/jquery.tools.min.js', CClientScript::POS_END);
$cs->registerScript('googleanalytics', "var _gaq=_gaq||[];_gaq.push(['_setAccount', 'UA-25950024-1']);_gaq.push(['_setDomainName', 'youtoo.com']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();", CClientScript::POS_END);
Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/metro.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/bootstrap-responsive.min.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/font-awesome.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/style.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/fab-style.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/style_responsive.css" rel="stylesheet"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/css/style_default.css" rel="stylesheet" id="style_color"/>

        <title>Youtoo Technologies - <?php echo $this->pageTitle; ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <style>
            html, body, #fullheight {
                min-height: 100% !important;
                height: 100%;
            }
        </style>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="fab-fixed-top">
        <!-- BEGIN HEADER -->
        <div style="background-image:url('/core/webassets/images/big-nav-expanded.jpg');height: 100%; width:107px; position:fixed; z-index:-1"></div>
        <div class="fab-header fav-navbar fab-navbar-inverse fab-navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="fab-navbar-inner">
                <div class="fab-container-fluid">
                    <!-- BEGIN LOGO -->
                    <div id="fab-logo" class="fab-left">
                        <a href="/" title="<?php echo Yii::app()->name; ?>">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/webassets/images/logo.png" alt="<?php echo Yii::app()->name; ?>" style="height: 33px; width: 100px;">
                        </a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="fab-btn-navbar fab-collapsed" data-toggle="collapse" data-target=".fab-nav-collapse">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/menu-toggler.png" alt=""/>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <ul class="fab-nav fab-pull-right">
                        <!-- BEGIN search DROPDOWN -->

                        <!--
                        <li class="fab-dropdown" id="fab-search_bar">
                            <a href="#" class="fab-dropdown-toggle" data-toggle="dropdown">
                                <div class="fab-search-dropdown"></div>
                            </a>
                            <ul class="fab-dropdown-menu fab-tasks">
                                <li>
                                    <div class="fab-top8">
                                        <form>
                                            <input type="text" class="fab-search-input" placeholder="Search..."/>
                                            <input type="submit" class="fab-seach-submit" value=""/>
                                        </form>
                                    </div>
                                </li>

                            </ul>
                        </li>
                        -->

                        <?php if (count($this->notification) > 0): ?>
                            <audio><source src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/audio/notification.mp3" type="audio/mpeg"></audio>
                            <li id="fab-header_notification_bar" class="fab-dropdown">
                                <a data-toggle="dropdown" class="fab-dropdown-toggle" href="#">
                                    <span id="notificationCount" style="left: 3px; position: relative; top: -9px; font-weight: bold; color: #fff;"><?php echo count($this->notification); ?></span>
                                    <div class="fab-notifications"></div>
                                </a>

                                <ul class="fab-dropdown-menu fab-extended fab-notification">
                                    <?php foreach ($this->notification as $notification) : ?>
                                        <li>
                                            <a href="/admin/loadNotificationUrl/<?php echo $notification->id; ?>">
                                                <div style="font-weight: bold;">&raquo; <?php echo CHtml::encode($notification->message); ?></div>
                                                <div class="fab-time"><?php echo DateTimeUtility::niceTime(strtotime($notification->created_on)); ?></div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            </li>
                        <?php endif; ?>

                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="fab-dropdown fab-user" style="top: 6px;">
                            <a href="#" class="fab-dropdown-toggle" data-toggle="dropdown">
                                <!--<img style="width: 30px; height: 30px;" alt="<?php echo $this->user->first_name; ?> <?php echo $this->user->last_name; ?>" src="<?php echo UserUtility::getAvatar($this->user); ?>"/>-->
                                <span class="fab-username"><?php echo $this->user->first_name; ?> <?php echo $this->user->last_name; ?></span>
                                <i class="icon-angle-down"></i>
                            </a>
                            <ul class="fab-dropdown-menu">
                                <li><?php echo CHtml::link('<i class="icon-user"></i> Settings', '/admin/setting', array()); ?></li>
                                <li class="fab-divider"></li>
                                <li><?php echo CHtml::link('<i class="icon-key"></i> Logout', '/admin/logout', array()); ?></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="fab-page-container fab-row-fluid">
            <!-- BEGIN SIDEBAR -->
            <div class="fab-nav-collapse fab-collapse" style="position:absolute;">
                <ul id="adminNav">
                    <li <?php echo (Yii::app()->controller->id == 'adminDashboard') ? 'class="on"' : ''; ?>>
                        <a href="/admin/dashboard">
                            <div style="background-image:url('/core/webassets/images/adminnav/dashboard-transparent.png');">
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>
                    <?php if (in_array('HAS_VIDEO', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminvideo'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminVideo') ? 'class="on"' : ''; ?>>
                            <a href="/admin/video">
                                <div style="background-image:url('/core/webassets/images/adminnav/video-transparent.png');">
                                    <span>Video Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_IMAGE', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminimage'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminImage') ? 'class="on"' : ''; ?>>
                            <a href="/admin/image">
                                <div style="background-image:url('/core/webassets/images/adminnav/photo-transparent.png');">
                                    <span>Image Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_TICKER', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminticker'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminTicker') ? 'class="on"' : ''; ?>>
                            <a href="/admin/ticker">
                                <div style="background-image:url('/core/webassets/images/adminnav/ticker-transparent.png');">
                                    <span>Ticker Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_ENTITY', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminentity'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminEntity') ? 'class="on"' : ''; ?>>
                            <?php if (Yii::app()->params['entityContestant']) : ?>
                                <a href="/admin/entity/contest">
                                    <div style="background-image:url('/core/webassets/images/adminnav/ticker-transparent.png');">
                                        <span>Contest Admin</span>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a href="/admin/entity">
                                    <div style="background-image:url('/core/webassets/images/adminnav/ticker-transparent.png');">
                                        <span style="font-size: 12px;">Advertiser Admin</span>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_VOTING', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminvoting'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminVoting') ? 'class="on"' : ''; ?>>
                            <a href="/admin/voting">
                                <div style="background-image:url('/core/webassets/images/adminnav/voting-transparent.png');">
                                    <span>Voting Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_QUESTION_VIDEO', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminquestion'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminQuestion' && Yii::app()->request->getParam('q_type') == 'video') ? 'class="on"' : ''; ?>>
                            <a href="/admin/question?q_type=video">
                                <div style="background-image:url('/core/webassets/images/adminnav/videoquestion-transparent.png');">
                                    <span style="font-size: 13px; bottom:4px; line-height: 100%;">Video Question Editor</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_QUESTION_TICKER', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminquestion'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminQuestion' && Yii::app()->request->getParam('q_type') == 'ticker') ? 'class="on"' : ''; ?>>
                            <a href="/admin/question?q_type=ticker">
                                <div style="background-image:url('/core/webassets/images/adminnav/videoquestion-transparent.png');">
                                    <span style="font-size: 13px; bottom:4px;  line-height: 100%;">Ticker Question Editor</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_SOCIALSEARCH', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminsocialsearch'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminSocialSearch') ? 'class="on"' : ''; ?>>
                            <a href="/admin/socialsearch">
                                <div style="background-image:url('/core/webassets/images/adminnav/socialsearch-transparent.png');">
                                    <span>Social Search</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_SOCIALSTREAM', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminsocialstream'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminSocialStream') ? 'class="on"' : ''; ?>>
                            <a href="/admin/socialstream">
                                <div style="background-image:url('/core/webassets/images/adminnav/socialstream-transparent.png');">
                                    <span>Social Stream</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_GAME', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('admingame'))): ?>

                        <?php
                        if (in_array('HAS_GAME_MULTIPLE_CHOICE', Yii::app()->params['features']) && !in_array('HAS_GAME_HOT_OR_NOT', Yii::app()->params['features']) && !in_array('HAS_GAME_CELEBRITY_REVEAL', Yii::app()->params['features'])) {
                            $gameURL = "/admin/gamechoice/multiple";
                        } else {
                            $gameURL = "/admin/game";
                        }
                        ?>

                        <li <?php echo (Yii::app()->controller->id == 'adminGame') ? 'class="on"' : ''; ?>>
                            <a href="<?php echo $gameURL; ?>">
                                <div style="background-image:url('/core/webassets/images/adminnav/socialstream-transparent.png');">
                                    <span>Game Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_PRIZES', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminprize'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminPrize') ? 'class="on"' : ''; ?>>
                            <a href="/admin/prize">
                                <div style="background-image:url('/core/webassets/images/adminnav/socialstream-transparent.png');">
                                    <span>Store Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_LANGUAGE', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminlanguage'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminLanguage') ? 'class="on"' : ''; ?>>
                            <a href="/admin/language">
                                <div style="background-image:url('/core/webassets/images/adminnav/language-transparent.png');">
                                    <span>Language Filter</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_BANNER', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminbanner'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminBanner') ? 'class="on"' : ''; ?>>
                            <a href="/adminBanner">
                                <div style="background-image:url('/core/webassets/images/adminnav/photo-transparent.png');">
                                    <span>Banner Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_REPORT', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminreport'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminReport' && Yii::app()->controller->action->id == 'index') ? 'class="on"' : ''; ?>>
                            <a href="/admin/report">
                                <div style="background-image:url('/core/webassets/images/adminnav/reports-transparent.png');">
                                    <span>Prem. Reports</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_DAILY_REPORT', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminreport'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminReport' && Yii::app()->controller->action->id == 'weeklyReport') ? 'class="on"' : ''; ?>>
                            <a href="/adminReport/weeklyReport">
                                <div style="background-image:url('/core/webassets/images/adminnav/reports-transparent.png');">
                                    <span>Daily Reports</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_TRAINING', Yii::app()->params['features'])): ?>
                        <li <?php echo (Yii::app()->controller->action->id == 'training') ? 'class="on"' : ''; ?>>
                            <a href="/admin/training">
                                <div style="background-image:url('/core/webassets/images/adminnav/training-transparent.png');">
                                    <span>Training</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_FAQ', Yii::app()->params['features'])): ?>
                        <li <?php echo (Yii::app()->controller->action->id == 'faq') ? 'class="on"' : ''; ?>>
                            <a href="/admin/faq">
                                <div style="background-image:url('/core/webassets/images/adminnav/faq-transparent.png');">
                                    <span>FAQ</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li <?php echo (Yii::app()->controller->action->id == 'contact') ? 'class="on"' : ''; ?>>
                        <a href="/admin/contact">
                            <div style="background-image:url('/core/webassets/images/adminnav/contact-transparent.png');">
                                <span>Contact</span>
                            </div>
                        </a>
                    </li>
                    <?php if (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminsetting')): ?>
                        <li <?php echo (Yii::app()->controller->action->id == 'setting') ? 'class="on"' : ''; ?>>
                            <a href="/admin/setting">
                                <div style="background-image:url('/core/webassets/images/adminnav/settings-transparent.png');">
                                    <span>Settings</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_AUDIT', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->hasPermission('adminaudit'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminAudit') ? 'class="on"' : ''; ?>>
                            <a href="/admin/audit">
                                <div style="background-image:url('/core/webassets/images/adminnav/voting-transparent.png');">
                                    <span>Audit Trail</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('HAS_USER', Yii::app()->params['features']) && (Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission('adminuser'))): ?>
                        <li <?php echo (Yii::app()->controller->id == 'adminUser') ? 'class="on"' : ''; ?>>
                            <a href="/admin/user">
                                <div style="background-image:url('/core/webassets/images/adminnav/socialstream-transparent.png');">
                                    <span>User Admin</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!--end navigation -->
            </div>
            <div class="fab-clear"></div>
            <!-- BEGIN PAGE -->
            <?php echo $content; ?>
            <!-- END PAGE -->
        </div>

        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="fab-footer">
            <div id="fab-footer-logo" class="fab-left">
                <a href="#" title="Youtoo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/footer-logo.png" width="" alt="Azteca"></a>
            </div>
            <div class="fab-right">
                <ul id="fab-footer-nav">
                    <li><a href="#">home</a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">faq</a></li>
                    <li><a href="#">policy</a></li>
                    <li><a href="#">contact us</a></li>
                    <li><a href="#">site map</a></li>
                </ul>
            </div>
        </div>
        <!-- END FOOTER -->
        <!-- BEGIN JAVASCRIPTS -->
        <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/js/excanvas.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/js/respond.js"></script>
        <![endif]-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/js/_global.js"></script>
        <!-- END JAVASCRIPTS -->
        <div style="display: none;" id="numNotifications"><?php echo count($this->notification); ?></div>
        <div style="display: none;" id="sessionDuration"><?php echo Yii::app()->params['session']['duration']; ?></div>
        <div style="display: none;" id="sessionDurationOffset"><?php echo Yii::app()->params['session']['durationOffset']; ?></div>
        <div style="display: none;" id="sessionDurationOverlay">
            <div id="sessionDurationOverlayContent">
                <h2 style="font-size: 18px;">Warning</h2>
                <hr/>
                <div style="font-size: 14px;">Due to inactivity, your session will expire in a few moments.</div>
                <div style="margin-top: 20px;">
                    <button id="sessionRefresh">Continue this session</button>
                    <button id="sessionExpire">Retire this session</button>
                </div>
            </div>
        </div>
    </body>
    <!-- END BODY -->
</html>
