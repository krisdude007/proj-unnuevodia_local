<?php
// page specific css
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminCampaign/index.css');
 
Yii::app()->clientScript->registerScriptFile('/core/webassets/js/adminCampaign/index.js', CClientScript::POS_END);


?>
<div class="fab-page-content">

    <!-- flash messages -->
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <!-- flash messages -->

     
    <div class="campaign_top_bar">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/campaign/campaign_manager_icon.png" />Campaign Manager
    </div>
     
    <div class="fab-container-fluid">
    <h1><?php echo $post->campaign->campaign_title; ?></h1>
    	<div class='campaign_container'>
        <?php $this->renderPartial('_post_form', array('post'=>$post)); ?>
        </div>
    </div>
</div>
        
