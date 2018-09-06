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
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/campaign/campaign_manager_icon.png" />
        <a href='<?php echo $this->createUrl('/adminCampaign'); ?>' >Campaign Manager</a>
    </div>
     
    <div class="fab-container-fluid">
    	<div class='campaign_container'>
             <div class='campain_header'>
             	Get Started
             </div>
        
            <div class='campaign_step'>
                <span class="campaign_step1_unselected"></span>
                <span class="campaign_step2_unselected"></span>
                <span class="campaign_step3_selected"></span>
            </div> 
             
            <?php $this->renderPartial('_package', array('campaign'=>$campaign)); ?>
           
         </div>
     </div>
 </div>