
<?php
// page specific css
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/chosen.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/bootstrap-toggle-buttons.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminVoting/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/spectrum.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-timepicker-addon.css');
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');

$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminGame/winners.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/spectrum.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/adminGame/winners.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
?>


<!-- BEGIN PAGE -->
<div class="fab-page-content">

    <!-- flash messages -->
    <?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        $messageFormat = '<div class="flashes"><div class="flash-%s">%s</div></div>';
        foreach ($flashMessages as $key => $message) {
            echo sprintf($messageFormat, $key, $message);
        }
    }
    ?>
    <!-- flash messages -->

    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top" style="background:#852b99;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="marginRight10 floatLeft" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/voting-image.png"/>Weekly & Monthly Winners </h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- END PAGE HEADER-->
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div style="clear:both;padding-top:40px">
                        <h2>Weekly Winners</h2>
                        <table id="weekWinnerTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Type</th>
                                    <th>Contest Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Created On</th>
                                    <th>Stats</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php

                            foreach($weekWinners as $winner)
                            {
                                if($winner->user_id != NULL) {
                                    $user_id = $winner->user_id;
                                    $username = CHtml::link($winner->user->username, array('admin/user/'.$winner->user_id), array('target'=>'_blank'), array('title' => $winner->user->username));
                                }
                                else {
                                    $user_id = "N/A";
                                    $username = "No Winner";
                                }
                                
                                echo "<tr>";
                                echo "<td>".$winner->id."</td>";
                                echo "<td>".$user_id."</td>";
                                echo "<td>".$username;
                                
                                if($winner->user != NULL) {
                                    echo " (<a target=\"_blank\" href=\"/admin/sendSMS/".$winner->user_id."\">SMS</a>)";
                                }
                                
                                echo "</td>";
                                echo "<td>".$winner->type."</td>";
                                echo "<td>".$winner->contest_name."</td>";
                                echo "<td>".$winner->from_date."</td>";
                                echo "<td>".$winner->to_date."</td>";
                                echo "<td>".$winner->created_on."</td>";
                                
                                echo "<td>";
                                
                                echo "  <table style='width: 100%;'>";
                                echo "      <thead>";
                                echo "          <tr>";
                                echo "              <th>Games</th>";
                                echo "              <th>Plays</th>";
                                echo "              <th>Plays Correct</th>";
                                echo "              <th>Unique Users</th>";
                                echo "              <th>Revenue</th>";
                                echo "          </tr>";
                                echo "      </thead>";
                                echo "      <tbody>";
                                echo "      <tr>";
                                echo "      <td>0</td>";
                                echo "      <td>0</td>";
                                echo "      <td>0</td>";
                                echo "      <td>0</td>";
                                echo "      <td>0</td>";
                                echo "      </tr>";
                                echo "      </tbody>";
                                echo "  </table>";
                                
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                                
                            ?>
                            </tbody>
                        </table>
                        <div class="clearFix"></div>
                    </div>
                    
                    <div style="clear:both;padding-top:40px">
                        <h2>Monthly Winners</h2>
                        <table id="monthWinnerTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Type</th>
                                    <th>Contest Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php

                            foreach($monthWinners as $winner)
                            {
                                if($winner->user_id != NULL) {
                                    $user_id = $winner->user_id;
                                    $username = CHtml::link($winner->user->username, array('admin/user/'.$winner->user_id), array('target'=>'_blank'), array('title' => $winner->user->username));
                                }
                                else {
                                    $user_id = "N/A";
                                    $username = "No Winner";
                                }
                                
                                echo "<tr>";
                                echo "<td>".$winner->id."</td>";
                                echo "<td>".$user_id."</td>";
                                echo "<td>".$username;
                                
                                if($winner->user != NULL) {
                                    echo " (<a target=\"_blank\" href=\"/admin/sendSMS/".$winner->user_id."\">SMS</a>)";
                                }
                                
                                echo "</td>";
                                echo "<td>".$winner->type."</td>";
                                echo "<td>".$winner->contest_name."</td>";
                                echo "<td>".$winner->from_date."</td>";
                                echo "<td>".$winner->to_date."</td>";
                                echo "<td>".$winner->created_on."</td>";
                                echo "</tr>";
                            }
                                
                            ?>
                            </tbody>
                        </table>
                        <div class="clearFix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->



