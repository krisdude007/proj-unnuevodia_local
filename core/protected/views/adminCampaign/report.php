<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminCampaign/index.css');
    Yii::app()->clientScript->registerScriptFile('/core/webassets/js/adminCampaign/index.js', CClientScript::POS_END);
?>
<style>
.fab-box
{
	margin-left:0px;
	margin-top:20px;
}
.activity_date
{
	color:#ffffff;
	margin-right: 20px;
}
</style>
<div class="fab-page-content">

    <!-- flash messages -->
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <!-- flash messages -->

     
    <div class="campaign_top_bar">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/campaign/campaign_manager_icon.png" />
        <a href='<?php echo $this->createUrl('/adminCampaign'); ?>' >Campaign Manager</a>
    </div>
     
    <div class="fab-container-fluid">
    	<div class='fab-row-fluid'>
    		<div class="btn-group">
				<a class="fab-btn" href="<?php echo  $this->createUrl('adminCampaign/'); ?>">Home</a>
			</div>
			<div class="btn-group">
				<a class="fab-btn fab-green" href="<?php echo  $this->createUrl('adminCampaign/create'); ?>">New Campaign </a>
			</div>
            <div class="btn-group">
				<a class="fab-btn dropdown-toggle" data-toggle="dropdown" href="#">
				Edit <span class="caret"></span>
				<!-- <i class="icon-angle-down"></i> -->
				</a>
				<ul class="fab-dropdown-menu">
					<li><a href="#">Edit Accounts</a></li>
					<li><a href="#">Edit Show Details</a></li>
					<li><a href="#">Edit Package</a></li>
				</ul>
			</div>
    	</div>
	 
        <div class="fab-portlet fab-box fab-grey">
            <div class="fab-portlet-title">
             
                 Activity 
                <span class='fab-pull-right'>
                    <a class='btn btn-link activity_date'>Current Total</a> 
                    <a class='btn btn-link activity_date'> Last 30 days </a>
                    <a class='btn btn-link activity_date'>Last 7 days </a>
                    <a class='btn btn-link activity_date'> Yesterday </a>
                    <a class='btn btn-link activity_date'> Custom Date Range </a>
                </span>
        	 
            </div>
            <div class="fab-portlet-body">
                  
            </div>
        </div>
        
        <div class="fab-portlet fab-box fab-grey">
            <div class="fab-portlet-title">
                 Activity 
            </div>
            <div class="fab-portlet-body">
                  
            </div>
        </div>
    </div>
    
</div>
