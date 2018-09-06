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
    	<?php $this->renderPartial('/adminCampaign/_campaign_menu'); ?>
    		 <div class="campaign_subtitle">
            	Current package: <?php echo strtoupper($campaign->package);?>
             
            </div>
        	<div class="hero-unit">
               
                <p><?php echo $campaign->show_title; ?></p>
                <p>From <?php echo $campaign->start_date; ?> To <?php echo $campaign->end_date;?></p>
                <p>Reoccur <?php echo $campaign->occurrence; ?> @ <?php echo $campaign->show_airing_time; ?> 
                    <?php if($campaign->occurrence == 'weekly'): ?>
                    (<?php echo $campaign->day; ?>)
                    <?php endif; ?>
                </p>
                <p>Tags: <?php echo $campaign->tags; ?></p>
                <p>Hash Tags: <?php echo $campaign->hashtags; ?>
               
            </div>
    
            <?php $this->renderPartial('_package', array('campaign'=>$campaign)); ?>
     	</div>
  	</div>
</div>