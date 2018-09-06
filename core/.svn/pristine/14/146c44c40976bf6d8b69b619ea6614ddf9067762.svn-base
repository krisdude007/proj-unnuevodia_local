<?php
$cs = Yii::app()->clientScript;
// page specific css
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/chosen.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.modal.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminTicker/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminTicker/tickerModalHistory.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.blockui.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.flot.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.flot.resize.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.gritter.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.pulsate.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.modal.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminTicker/index.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminTicker/tickerModalHistory.js', CClientScript::POS_END);

?>

<?php $this->renderPartial('/admin/_csrfToken', array()); ?>
<!-- BEGIN PAGE -->
<div class="fab-page-content">
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div style="background:#fcb922" id="fab-top">
        <h2 style="color:white" class="fab-title">
            <img class="floatLeft" style="margin-right: 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/ticker-image.png">
            <div class="floatLeft">Ticker Admin - <?php echo $statuses[$status]; ?></div>
            <?php
            if (Yii::app()->params['ticker']['breakingTweets']):
                $this->renderPartial('/admin/_breakingTweetsShortNav');
            endif;
            ?>
        </h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- END PAGE HEADER-->
        <div class="fab-row-fluid">
            <div class="fab-ticker-container">
                <div id="fab-ticker-filter-form">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'ticker-form',
                        'action' => '/admin/ticker',
                        'method' => 'GET',
                    ));
                    ?>
                    <div class="fab-clear" style="height:6px;"></div>
                    <?php if (Yii::app()->params['ticker']['allowCreateAsEntity']): ?>
                        <div class="fab-box fab-left" style="margin-left:10px">
                            <label class="fab-left">Type:</label>
                            <?php echo CHtml::dropDownList('type_id', $type_id, $types, array('style' => 'width:90px;', 'onchange' => 'flip();')); ?>
                        </div>
                    <?php endif; ?>
                    <div class="fab-box fab-left flip" style="margin-left:10px;<?php echo($type_id == 0 ? '' : 'display:none;'); ?>">
                        <label class="fab-left">Question:</label>
                        <?php echo CHtml::dropDownList('question_id', $question_id, $questions, Array('prompt' => 'All Active', 'style' => 'width:350px;', 'disabled' => $type_id == 0 ? '' : 'disabled')); ?>
                    </div>
                    <?php if (Yii::app()->params['ticker']['allowCreateAsEntity']): ?>
                        <div class="fab-box fab-left flip" style="margin-left:10px;<?php echo($type_id == 1 ? '' : 'display:none;'); ?>">
                            <label class="fab-left">Advertiser:</label>
                            <?php echo CHtml::dropDownList('entity_id', $entity_id, $entities, Array('prompt' => 'All', 'style' => 'width:350px;', 'disabled' => $type_id == 1 ? '' : 'disabled')); ?>
                        </div>
                    <?php endif; ?>
                    <div class="fab-box fab-left" style="margin-left:10px;">
                        <label class="fab-left">Status:</label>
                        <?php echo CHtml::dropDownList('status', $status, $statuses, array('style' => 'width:110px;')); ?>
                    </div>
                    <div  class="fab-box fab-left" style="clear:both">
                        <input style="margin-top:-3px" type="checkbox" name='failedLanguage' id='failedLanguage' <?php echo $failedLanguage ? "checked='checked'" : '' ?> />
                        <span>show only tickers with bad language</span>
                    </div>
                    <input type="submit" style="margin: 0px 0px 0px 20px !important" class="fab-right-filter" value="Submit">
                    <?php $this->endWidget(); ?>
                    <div style="clear:right;height:10px;"></div>
                </div>
                <?php if (Yii::app()->params['ticker']['allowCreateAsEntity']): ?>
                    <div style="border:1px solid black;margin-bottom:20px;padding:5px;">
                        <h2>Create Ticker as Entity</h2>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'entity-ticker-form',
                            'enableAjaxValidation' => true,
                        ));
                        ?>
                        <div>
                            <div>
                                <div>
                                    <?php echo $form->labelEx($entity, 'name'); ?>
                                    <?php echo $form->dropDownList($entity, 'name', $entities, array('prompt' => 'Select Entity')); ?>
                                    or <a href="/admin/entity">Add new entity</a>
                                </div>
                                <div>
                                    <?php echo $form->labelEx($ticker, 'ticker'); ?>
                                    <?php echo $form->textField($ticker, 'ticker', array('maxlength' => '140', 'class' => 'counter', 'style' => 'width:560px')); ?>
                                    <?php echo $form->error($ticker, 'ticker'); ?>
                                </div>
                            </div>
                            <div style="clear:both">
                                <?php echo $form->hiddenField($ticker, 'source', Array('value' => 'web')); ?>
                                <?php echo CHtml::submitButton('Submit'); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="fab-ticker-container">
            <div class="fab-row-fluid">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'admin-ticker-form',
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div style='text-align:right;margin-bottom:5px;'>
                    Showing <?php echo(count($tickers)); ?> of <?php echo($pages->itemCount); ?> Tickers
                </div>
                <div style='margin-bottom:5px;'>
                    <?php $this->widget('CLinkPager', array('pages' => $pages, 'header' => '')); ?>
                </div>
                <table class="dtStyle">
                    <thead>
                        <?php if ($status == 'accepted'): ?>
                            <tr>
                                <th colspan="4"></th>
                                <th colspan="2">Set Runs</th>
                                <th>TV Control</th>
                                <th colspan="2">Times Run</th>
                                <th colspan="2">Remaining Runs</th>
                                <th colspan="4"></th>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th style="width:60px">Avatar</th>
                            <th><?php echo $sort->link('ticker', null, array('class' => 'sort-link')) ?></th>
                            <th><?php echo $sort->link('user.username', null, array('class' => 'sort-link')) ?></th>
                            <th><?php echo $sort->link('created_on', null, array('class' => 'sort-link')) ?></th>

                            <?php if ($status == 'accepted'): ?>
                                <th>Web</th>
                                <th>Mobile</th>

                                <?php if ($question_id > 0): ?>
                                    <th>Order</th>
                                <?php else: ?>
                                    <th>Frequency</th>
                                <?php endif; ?>

                                <th>Web</th>
                                <th>Mobile</th>

                                <th>Web</th>
                                <th>Mobile</th>
                            <?php endif; ?>

                            <th>Email</th>

                            <?php if ($status == 'accepted' || $status == 'acceptedtv'): ?>
                                <th>Share</th>
                            <?php endif; ?>

                            <?php if ($status == 'statustv'): ?>
                                <th>Status</th>
                            <?php else: ?>
                                <th style='padding:2px 6px;'><?php echo CHtml::submitButton('Submit'); ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowFormats = Array();
                        $rowFormat['entity']['accepted'] = '
                            <tr>
                                <td class="fab-first-cell"><img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" /></td>
                                <td>
                                    <div class="text-message" style="%s" %s>%s</div>
                                </td>
                                <td>
                                    <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                                </td>
                                <td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td>
                                <td>
                                    <div style="width:70px;">
                                        <a rel="%d" href="#" class="shareToClientFacebook">
                                            <img src="/core/webassets/images/facebook-round.png" />
                                        </a>
                                        <a rel="%d" href="#" class="shareToClientTwitter">
                                            <img src="/core/webassets/images/twitter-round.png" />
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="radioList">
                                        %s
                                        %s
                                    </div>
                                </td>
                            </tr>';

                        $rowFormat['accepted'] = '
                            <tr>
                                <td class="fab-first-cell"><img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" /></td>
                                <td>
                                    <div class="text-message" style="%s" %s>%s</div>
                                </td>
                                <td>
                                    <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                                </td>
                                <td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td><td>%s</td>
                                <td>%s</td>
                                <td>
                                    <div style="width:70px;">
                                        <a rel="%d" href="#" class="shareToClientFacebook">
                                            <img src="/core/webassets/images/facebook-round.png" />
                                        </a>
                                        <a rel="%d" href="#" class="shareToClientTwitter">
                                            <img src="/core/webassets/images/twitter-round.png" />
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="radioList">
                                        %s
                                        %s
                                    </div>
                                </td>
                            </tr>';

                        $rowFormat['new'] = $rowFormat['denied'] = $rowFormat['newtv'] = $rowFormat['deniedtv'] = $rowFormat['newsup1'] = $rowFormat['newsup2'] = '
                        <tr>
                            <td class="fab-first-cell">
                                <img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" />
                            </td>
                            <td>
                                <div class="text-message" style="%s" %s>%s</div>
                            </td>
                            <td>
                                <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                            </td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <div class="radioList">%s</div>
                                %s
                            </td>
                        </tr>';

                        $rowFormat['newsup1'] = $rowFormat['newsup2'] = '
                        <tr>
                            <td class="fab-first-cell">
                                <img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" />
                            </td>
                            <td>
                                <div class="text-message" style="%s" %s>%s</div>
                            </td>
                            <td>
                                <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                            </td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <div class="radioList">%s</div>
                            </td>
                        </tr>';

                        $rowFormat['acceptedtv'] = '
                        <tr>
                            <td class="fab-first-cell">
                                <img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" />
                            </td>
                            <td>
                                <div class="text-message" style="%s" %s>%s</div>
                            </td>
                            <td>
                                <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                            </td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <div style="width:70px;">
                                    <a rel="%d" href="#" class="shareToClientFacebook">
                                        <img src="/core/webassets/images/facebook-round.png" />
                                    </a>
                                    <a rel="%d" href="#" class="shareToClientTwitter">
                                        <img src="/core/webassets/images/twitter-round.png" />
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="radioList">%s</div>
                                %s
                            </td>
                        </tr>';

                        $rowFormat['statustv'] = '
                         <tr>
                            <td class="fab-first-cell">
                                <img style="width: 60px; height: 60px;" src="%s" onclick="historyModalHandler(%s)" />
                            </td>
                            <td>
                                <div class="text-message" style="%s" %s>%s</div>
                            </td>
                            <td>
                                <div class="ticker-username"><a target="_blank" href="%s">%s</a></div>
                            </td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                        </tr>';
                        $format = ($ticker->type == 'entity') ? $rowFormat['entity'][$status] : $rowFormat[$status];
                        if (count($tickers) == 0) {
                            $format = "<tr><td colspan='100%%' style='text-align:center;'>%s</td></tr>";
                            $args = array('No records available');
                            vprintf($format, $args);
                        }
                        foreach ($tickers as $i => $ticker) {
                            //echo($ticker->type);
                            switch ($ticker->type) {
                                /*
                                  case 'entity':
                                  switch ($status) {
                                  case 'denied':
                                  $args = Array(
                                  TickerUtility::getAvatar($ticker),$i,
                                  ($ticker['clean']['result']) ? '' : 'color:#F00',
                                  ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                  $ticker['ticker'],
                                  TickerUtility::getLink($ticker),
                                  TickerUtility::getUsername($ticker),
                                  date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                  isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                  $form->radioButtonList($ticker, "[$i]status", Array('accepted' => 'Accept'), Array('separator' => '', 'style' => 'float:left;')),
                                  );
                                  break;
                                  case 'accepted':
                                  $timesToRun = Array();
                                  $timesRan = Array('web' => 0, 'mobile' => 0);
                                  $remainingRuns = Array();
                                  foreach ($ticker->tickerRuns as $tickerRun) {
                                  $timesRan['web'] += $tickerRun->web_ran;
                                  $timesRan['mobile'] += $tickerRun->mobile_ran;
                                  if ($tickerRun->stopped == 0) {
                                  $timesToRun['web'] += $tickerRun->web_runs;
                                  $timesToRun['mobile'] += $tickerRun->mobile_runs;
                                  $remainingRuns['web'] += ($tickerRun->web_runs - $tickerRun->web_ran);
                                  $remainingRuns['mobile'] += ($tickerRun->mobile_runs - $tickerRun->mobile_ran);
                                  }
                                  }
                                  $args = Array(
                                  TickerUtility::getAvatar($ticker),$i,
                                  ($ticker['clean']['result']) ? '' : 'color:#F00',
                                  ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                  $ticker['ticker'],
                                  TickerUtility::getLink($ticker),
                                  TickerUtility::getUsername($ticker),
                                  date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                  $form->textField($tickerRuns[$i], "[$i]web_runs"),
                                  $form->textField($tickerRuns[$i], "[$i]mobile_runs"),
                                  ($question == 0) ? $form->textField($ticker, "[$i]frequency") : '',
                                  $timesRan['web'],
                                  $timesRan['mobile'],
                                  $remainingRuns['web'] > 0 ? $remainingRuns['web'] : 0,
                                  $remainingRuns['mobile'] > 0 ? $remainingRuns['mobile'] : 0,
                                  'N/A',
                                  $ticker->id, $ticker->id,
                                  $form->radioButtonList($ticker, "[$i]status", Array('denied' => 'Deny'), Array('separator' => '', 'style' => 'float:left;')),
                                  ($remainingRuns['web'] > 0 || $remainingRuns['mobile'] > 0) ? $form->checkbox($ticker, "[$i]stop", Array('style' => 'float:left')) . $form->labelEx($ticker, "[$i]stop") : '',
                                  );
                                  break;
                                  }
                                  break;
                                 */
                                default:
                                    switch ($status) {
                                        case 'new':
                                        case 'newtv':
                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker['ticker'],
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $form->radioButtonList($ticker, "[$i]status", Array('accepted' => 'Accept', 'denied' => 'Deny'), Array('separator' => '', 'style' => 'float:left;')),
                                                (($type_id == 0) ? $form->dropDownList($ticker, "[$i]question_id", $questions, array('prompt' => 'Select Question')) : $form->dropDownList($ticker, "[$i]entity_id", $entities, array('prompt' => 'Select Entity'))),
                                            );
                                            break;
                                        case 'newsup1':
                                        case 'newsup2':
                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker['ticker'],
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $form->radioButtonList($ticker, "[$i]status", Array('accepted' => 'Accept', 'denied' => 'Deny'), Array('separator' => '', 'style' => 'float:left;')),
                                                '',
                                            );
                                            break;
                                        case 'statustv':
                                            $statusColor = '<div style="font-size: 10px;">';
                                            //if the below works for a bit for all the client, we can remove the commented code.
                                            //if ($ticker->extendedStatus['accepted_sup1']) {
                                               // $statusColor .= '<span title="approved" style="color: green">S&P</span> - ';
                                            //} else {
                                           //     $statusColor .= '<span title="no action taken" style="color: orange">S&P</span> - ';
                                            //}

                                            //if ($ticker->extendedStatus['accepted_sup2']) {
                                            //    $statusColor .= '<span title="approved" style="color: green">Legal</span> - ';
                                            //} else {
                                            //    $statusColor .= '<span title="no action taken" style="color: orange">Legal</span> - ';
                                            //}

                                            $extendedLabels = Yii::app()->params['video']['extendedFilterLabels'];
                                            unset($extendedLabels[0]);
                                            unset($extendedLabels[1]);

                                            $i = 1;
                                            foreach($extendedLabels as &$value)
                                            {
                                                if($ticker->extendedStatus['accepted_sup'.$i])
                                                {
                                                    $statusColor .= '<span title="approved" style="color: green">'.$value[key($value)].'</span> - ';
                                                }
                                                else
                                                {
                                                    $statusColor .= '<span title="no action taken" style="color: orange">'.$value[key($value)].'</span> - ';
                                                }
                                                $i++;
                                            }

                                            if ($ticker->extendedStatus['denied_tv']) {
                                                $statusColor .= '<span title="denied" style="color: red">DenyTV</span> - ';
                                            } else {
                                                $statusColor .= '<span title="no action taken" style="color: orange">DenyTV</span> - ';
                                            }

                                            if ($ticker->extendedStatus['denied']) {
                                                $statusColor .= '<span title="denied" style="color: red">DenyWeb</span>';
                                            } else {
                                                $statusColor .= '<span title="no action taken" style="color: orange">DenyWeb</span>';
                                            }
                                            $statusColor .= '</div>';

                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker['ticker'],
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $statusColor
                                            );
                                            break;
                                        case 'denied':
                                        case 'deniedtv':
                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker['ticker'],
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $form->radioButtonList($ticker, "[$i]status", Array('accepted' => 'Accept'), Array('separator' => '', 'style' => 'float:left;')),
                                                '',
                                            );
                                            break;
                                        case 'acceptedtv':
                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker['ticker'],
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker['created_on'])) . " " . date("T"),
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $ticker->id, $ticker->id,
                                                $form->radioButtonList($ticker, "[$i]status", Array('denied' => 'Deny'), Array('separator' => '', 'style' => 'float:left;')),
                                                '',
                                            );
                                            break;
                                        case 'accepted':
                                            $timesToRun = Array('web' => 0, 'mobile' => 0);
                                            $timesRan = Array('web' => 0, 'mobile' => 0);
                                            $remainingRuns = Array('web' => 0, 'mobile' => 0);
                                            foreach ($ticker->tickerRuns as $tickerRun) {
                                                $timesRan['web'] += $tickerRun->web_ran;
                                                $timesRan['mobile'] += $tickerRun->mobile_ran;
                                                if ($tickerRun->stopped == 0) {
                                                    $timesToRun['web'] += $tickerRun->web_runs;
                                                    $timesToRun['mobile'] += $tickerRun->mobile_runs;
                                                    $remainingRuns['web'] += ($tickerRun->web_runs - $tickerRun->web_ran);
                                                    $remainingRuns['mobile'] += ($tickerRun->mobile_runs - $tickerRun->mobile_ran);
                                                }
                                            }
                                            $args = Array(
                                                TickerUtility::getAvatar($ticker), $i,
                                                ($ticker['clean']['result']) ? '' : 'color:#F00',
                                                ($ticker['clean']['result']) ? "" : "title='Fails language filter: {$ticker['clean']['filter']->pattern}'",
                                                $ticker->ticker,
                                                TickerUtility::getLink($ticker),
                                                TickerUtility::getUsername($ticker),
                                                date('Y-m-d h:i:s a', strtotime($ticker->created_on)) . " " . date("T"),
                                                $form->textField($tickerRuns[$i], "[$i]web_runs"),
                                                $form->textField($tickerRuns[$i], "[$i]mobile_runs"),
                                                ($question_id > 0) ? $form->textField($ticker, "[$i]ordinal") : '',
                                                $timesRan['web'],
                                                $timesRan['mobile'],
                                                $remainingRuns['web'] > 0 ? $remainingRuns['web'] : 0,
                                                $remainingRuns['mobile'] > 0 ? $remainingRuns['mobile'] : 0,
                                                isset($ticker->user_id) ? '<a href="mailto:' . $ticker->user->userEmails[0]->email . '"><img src="/core/webassets/images/email-icon.png"></a>' : 'N/A',
                                                $ticker->id, $ticker->id,
                                                $form->radioButtonList($ticker, "[$i]status", Array('denied' => 'Deny'), Array('separator' => '', 'style' => 'float:left;')),
                                                ($remainingRuns['web'] > 0 || $remainingRuns['mobile'] > 0) ? $form->checkbox($ticker, "[$i]stop", Array('style' => 'float:left')) . $form->labelEx($ticker, "[$i]stop") : '',
                                            );
                                            break;
                                    }
                                    break;
                            }
                            vprintf($format, $args);
                        }
                        ?>
                    </tbody>
                </table>
                <div style="text-align:right;clear:both;">
                    <?php echo CHtml::hiddenField('status', $status); ?>
                    <?php echo CHtml::submitButton('Submit'); ?>
                </div>
            </div>
        </div>

    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->
<?php $this->endWidget(); ?>