<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/core/webassets/js/adminUser/index.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/adminUser/index.css');
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$this->renderPartial('/admin/_csrfToken');
?>

<div class="fab-page-content">
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->

  <div id="fab-top">
    <h2 class="fab-title"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>User Login Log</h2>
  </div>
  <!-- END PAGE TITLE & BREADCRUMB-->
  <!-- BEGIN PAGE CONTAINER-->
  <div class="fab-container-fluid">
    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->
    <div id="fab-dashboard">
      <div style="padding:0px 20px 0px 20px;">
        <div style="clear:both;padding-top:40px">
                        <table id="gameTable">
                            <thead>
                                <tr>
                                    <th>LID</th>
                                    <th>UID</th>
                                    <th>Email</th>
                                    <th width="370px">Device/Browser</th>
                                    <th>Source</th>
                                    <th>IP</th>
                                    <th>IP City</th>
                                    <th>IP State</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th width="100px">Date Logged In</th>
                                    <th width="100px">Date Joined</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                            for($i=0; $i<sizeof($users); $i++)
                            {
                                echo "<tr>";
                                echo "<td>";
                                echo $users[$i]['id'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['user_id'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['username'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['user_agent'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['source'];
                                echo "</td>";
                                
                                echo "<td>";
                                echo $users[$i]['ip_address'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['ip_basedcity'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['ip_basedstate'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['city'];
                                echo "</td>";

                                echo "<td>";
                                echo $users[$i]['state'];
                                echo "</td>";

                                $dateTime = new DateTime ($users[$i]['logedin_date'], new DateTimeZone('UTC'));
                                $dateTime->setTimezone(new DateTimeZone('America/Chicago'));

                                echo "<td>";
                                echo $dateTime->format('m-d-Y h:i:s A');
                                echo "</td>";

                                $dateTime2 = new DateTime ($users[$i]['joined_date'], new DateTimeZone('UTC'));
                                $dateTime2->setTimezone(new DateTimeZone('America/Chicago'));

                                echo "<td>";
                                echo $dateTime2->format('m-d-Y h:i:s A');;
                                echo "</td>";


                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>
                        <div class="clearFix"></div>
                    </div>
    </div>
  </div>
  <!-- END PAGE CONTAINER-->
</div>