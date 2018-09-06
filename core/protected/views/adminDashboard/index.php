<?php
// page specific css
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/uniform.default.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminDashboard/index.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/_yttJqPlot.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/js/jqplot.1.0.5/jquery.jqplot.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/js/jqplot.1.0.5/syntaxhighlighter/styles/shCoreDefault.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/js/jqplot.1.0.5/syntaxhighlighter/styles/shThemejqPlot.min.css');

// page specific js
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.blockui.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/main.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/_global.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminDashboard/index.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/jquery.jqplot.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/syntaxhighlighter/scripts/shCore.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/syntaxhighlighter/scripts/shBrushJScript.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/syntaxhighlighter/scripts/shBrushXml.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.highlighter.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.dateAxisRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.barRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.categoryAxisRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.pointLabels.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.pieRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.donutRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jqplot.1.0.5/plugins/jqplot.enhancedLegendRenderer.cust.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/formater.js', CClientScript::POS_END);
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/_grapher.js', CClientScript::POS_HEAD);

?>
<?php $this->renderPartial('/admin/_csrfToken', array()); ?>
<div class="fab-page-content">

    <!-- flash messages -->
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <!-- flash messages -->

    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 class="fab-title"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>Dashboard Home</h2>
    </div>
            <?php if (isset(Yii::app()->params['reporting']['enableWeeklyReportOnDashBoard'])  && Yii::app()->params['reporting']['enableWeeklyReportOnDashBoard'] == true): ?>
    <div style="margin: -20px 0px 0px 20px;">
        <a href="/admin/dashboard">Dashboard</a> |
        <a href="/adminReport/weeklyReport">Daily Reports</a>
    </div>
    <?php endif; ?>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <!-- END PAGE HEADER-->
        <div id="fab-dashboard">
            <!-- BEGIN DASHBOARD STATS -->
            <div class="fab-row-fluid">
                <?php if(in_array('HAS_VIDEO', Yii::app()->params['features']) && Yii::app()->params['DashboardCounts']['video']): ?>
                <div class="fab-span3 fab-responsive" data-tablet="fab-span6" data-desktop="fab-span3" style="margin-left:10px;">
                    <div class="fab-dashboard-stat fab-red">
                        <div class="fab-visual">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($videoCount); ?></p>
                                <p align="center">Total<br>
                                    Videos</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left"></div>
                        <div class="fab-details">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($pendingCount); ?></p>
                                <p align="center">Pending<br>
                                    Videos</p>
                            </div>
                        </div>
                        <a class="fab-more" href="/admin/video">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/small-video1.png">
                            <span style="margin-left:10px">View all Videos</span>
                            <i class="fab-m-icon-swapright fab-m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="fab-span3 fab-responsive" data-tablet="fab-span6" data-desktop="fab-span3">
                    <?php if(in_array('HAS_TICKER', Yii::app()->params['features']) && Yii::app()->params['DashboardCounts']['ticker']): ?>
                    <div class="fab-dashboard-stat fab-yellow">
                        <div class="fab-visual" style="width:29%">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($tickerRunningCount); ?></p>
                                <p align="center">Running<br>
                                    Tickers</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left" style="margin-left:1%"></div>
                        <div class="fab-visual" style="width:29%">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($tickerFailCount); ?></p>
                                <p align="center">Failed<br>
                                    Tickers</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left" style="margin-left:1%"></div>
                        <div class="fab-visual" style="width:26%">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($tickerNewCount); ?></p>
                                <p align="center">New<br>
                                    Shouts</p>
                            </div>
                        </div>
                        <a class="fab-more" href="/admin/ticker">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/small-ticker1.png">
                            <span style="margin-left:10px">View all Tickers</span>
                            <i class="fab-m-icon-swapright fab-m-icon-white"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="fab-span3 fab-responsive" data-tablet="fab-span6  fab-fix-offset" data-desktop="fab-span3">
                    <?php if(in_array('HAS_VOTING', Yii::app()->params['features']) && Yii::app()->params['DashboardCounts']['poll']): ?>
                    <div class="fab-dashboard-stat fab-purple">
                        <div class="fab-visual">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($voteCount); ?></p>
                                <p align="center">Total<br>
                                    Votes</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left"></div>
                        <div class="fab-details">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($questionCount); ?></p>
                                <p align="center">Voting<br>
                                    Questions</p>
                            </div>
                        </div>
                        <a class="fab-more" href="<?php echo Yii::app()->request->baseUrl; ?>/admin/voting">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/small-voting1.png">
                            <span style="margin-left:10px">View all Voting</span>
                            <i class="fab-m-icon-swapright fab-m-icon-white"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if(in_array('HAS_IMAGE', Yii::app()->params['features']) && Yii::app()->params['DashBoardCounts']['image']): ?>
                <div class="fab-span3 fab-responsive" data-tablet="fab-span6" data-desktop="fab-span3">
                    <div class="fab-dashboard-stat fab-green">
                        <div class="fab-visual">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($imageCount); ?></p>
                                <p align="center">Total<br>
                                    Images</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left"></div>
                        <div class="fab-details">
                            <div align="center">
                                <p class="fab-title-b" align="center"><?php echo($pendingImageCount); ?></p>
                                <p align="center">Pending<br>
                                    Images</p>
                            </div>
                        </div>
                        <a class="fab-more" href="/admin/image?perPage=12">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/small-video1.png">
                            <span style="margin-left:10px">View all Images</span>
                            <i class="fab-m-icon-swapright fab-m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
<!--                <div class="fab-span3 fab-responsive" data-tablet="fab-span6" data-desktop="fab-span3">
                    <div class="fab-dashboard-stat fab-green">
                        <div class="fab-visual">
                            <div align="center">
                                <p class="fab-title-b" align="center">26,756</p>
                                <p align="center">Total<br>
                                    Likes</p>
                            </div>
                        </div>
                        <div class="fab-stat-border fab-left"></div>
                        <div class="fab-details">
                            <div align="center">
                                <p class="fab-title-b" align="center">123</p>
                                <p align="center">Total<br>
                                    Tweets</p>
                            </div>
                        </div>
                        <a class="fab-more" href="#">
                            <img src="<?php //echo Yii::app()->request->baseUrl; ?>/core/webassets/images/small-social1.png">
                            <span style="margin-left:10px">View all Social</span>
                            <i class="fab-m-icon-swapright fab-m-icon-white"></i>
                        </a>
                    </div>
                </div>-->
            </div>
        </div>
        <div style="margin-top:40px; margin-left:10px;">
            <?php $this->renderPartial('//adminReport/_dateFilterLinks', array('startDate' => $startDate, 'endDate' => $endDate)); ?>
        </div>
        <div class="clearFix"></div>
        <!-- END DASHBOARD STATS -->
        <div class="fab-row-fluid">
            <div class="clearfix" style="height:20px;"></div>
            <div id="graphWrap">
                <?php
                if (in_array('HAS_VIDEO', Yii::app()->params['features']) && !empty($settings['graph_videos'])): ?>
                <div class="dashGraph" style="padding-top:6px;">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/video-chart.jpg"/>
                        <span>Videos Submitted</span>
                    </div>
                    <div id="videoGraph"></div>
                </div>
                <?php endif;
                if (!empty($settings['graph_users'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/users-chart.png"/>
                        <span>New Users</span>
                    </div>
                    <div id="userGraph"></div>
                </div>
                <div class="dashGraphSpace"></div>
                <?php endif;
                if (!empty($settings['graph_map'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon-map.jpg"/>
                        <span>User Map</span>
                    </div>
                    <a href="/adminReport/demographic/daysBack/30/request/total_user/#tabs-2">
                        <div id="mapGraph">
                            <?php
                            if(isset(Yii::app()->params['dashboard_user_map']))
                            {
                                $dashboardUserMapURL = Yii::app()->params['dashboard_user_map'];
                            }
                            else {
                                $dashboardUserMapURL = "/core/webassets/images/dashboard/dashboard-map.png";
                            }
                            ?>
                            <img style="width:480px; height:270px; padding:10px;" src="<?php echo Yii::app()->request->baseUrl.$dashboardUserMapURL; ?>">
                        </div>
                    </a>
                </div>
                <?php endif;
                if (in_array('HAS_GAME', Yii::app()->params['features'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/users-chart.png"/>
                        <span>Games Played</span>
                    </div>
                    <div id="gameplayedGraph"></div>
                </div>
                <div class="dashGraphSpace"></div>
                <?php endif;
                if(in_array('HAS_TICKER', Yii::app()->params['features'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/icon-ticker.jpg"/>
                        <span>Tickers Submitted</span>
                    </div>
                    <div id="tickerGraph"></div>
                </div>
                <div class="clearFix"></div>
                <?php endif;
                if(in_array('HAS_VOTING', Yii::app()->params['features'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/votes-chart.png"/>
                        <span>Votes Submitted</span>
                    </div>
                    <div id="voteGraph"></div>
                </div>
                <?php endif;
                if(in_array('HAS_IMAGE', Yii::app()->params['features'])): ?>
                <div class="dashGraph">
                    <div>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/votes-chart.png"/>
                        <span>Images Submitted</span>
                    </div>
                    <div id="imageGraph"></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>