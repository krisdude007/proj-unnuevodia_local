<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/_setting.css');
// page specific js
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.blockui.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/chosen.jquery.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery.toggle.buttons.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/app.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/_setting.js', CClientScript::POS_END);
$this->renderPartial('_csrfToken');
?>
<!-- BEGIN PAGE -->
<div class="fab-page-content">
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 style="color: rgb(4, 4, 4);" class="fab-title"><img class="fab-left fab-m10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/settings-image.png">Manage settings</h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid" id="fab-settings-page">
        <!-- BEGIN PAGE HEADER-->
        <!-- END PAGE HEADER-->
        <div class="fab-clear"></div>
        <div class="fab-reports-container">
            <?php
            $settingsBoxFormat = '
                <div class="fab-row-fluid fab-span4 %s">
                    <div class="fab-portlet fab-box light-red">
                        <div class="fab-portlet-title %s-title">
                            <h4>%s Settings</h4>
                        </div>
                        <div class="fab-portlet-body">
                            <table cellspacing="2" cellpadding="5" class="fab-t-settings">
                                <tbody>
                                %s
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            ';
            $settingsRowFormat = '
                <tr>
                    <td class="fab-width80">%s</td>
                    <td class="fab-width20">
                        <div class="fab-onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="fab-onoffswitch-checkbox" id="fab-myonoffswitch%s" %s>
                            <label class="fab-onoffswitch-label" for="fab-myonoffswitch%s">
                                <div class="fab-onoffswitch-inner"></div>
                                <div class="fab-onoffswitch-switch"></div>
                            </label>
                        </div>
                    </td>
                </tr>
            ';
            $settingsRowFormat2 = '
                <tr>
                    <td class="fab-width80">%s</td>
                    <td class="fab-width20">
                        <div class="fab-onoffswitch fab-onoffswitch-ltr">
                            <input type="checkbox" name="onoffswitch" class="fab-onoffswitch-checkbox" id="fab-myonoffswitch%s" %s>
                            <label class="fab-onoffswitch-label fab-onoffswitch-label-ltr" for="fab-myonoffswitch%s">
                                <div class="fab-onoffswitch-inner fab-onoffswitch-inner-ltr"></div>
                                <div class="fab-onoffswitch-switch fab-onoffswitch-switch-ltr"></div>
                            </label>
                        </div>
                    </td>
                </tr>
            ';
            foreach ($settings as $k => $v) {
                if($v->type == 'video' && in_array('HAS_VIDEO', Yii::app()->params['features']) ||
                   $v->type == 'ticker' && in_array('HAS_TICKER', Yii::app()->params['features']) ||
                   $v->type != 'video' && $v->type != 'ticker') {
                        $categorizedSettings[$v->type][$v->description]['id'] = $v->id;
                        $categorizedSettings[$v->type][$v->description]['val'] = $v->value;
                        $categorizedSettings[$v->type][$v->description]['attribute'] = $v->attribute;
                   }
            }
            $i = 0;

            foreach ($categorizedSettings as $k => $v) {
                $boxClass = ($i % 2 == 0) ? 'fab-m-left0' : '';
                $rows = '';
                foreach ($v as $kk => $vv) {
                    $checked = ($vv['val'] == 1) ? 'checked' : '';
                    if ($vv['attribute'] == 'ticker_direction_default') {
                        $rows .= sprintf($settingsRowFormat2, ucwords($kk), $vv['id'], $checked, $vv['id']);
                    } else {
                        $rows .= sprintf($settingsRowFormat, ucwords($kk), $vv['id'], $checked, $vv['id']);
                    }
                }
                echo sprintf($settingsBoxFormat, $boxClass, preg_replace('/\s+/', '_', $k), ucwords($k), $rows);
                ++$i;
            }
            ?>
        </div><!--end container -->
    </div>
    <!-- END PAGE CONTAINER-->
</div>