
<div id="linksPopUpOverlay" style="display:none">
<h2>Links</h2> 
	<div class="linksContent">
		
		<div class="clearfix">
			<?php echo CHtml::hiddenField('baseurl',Yii::app()->getBaseUrl(true)); ?>
			<?php echo CHtml::label('XML URL', NULL, array('id' => 'xml_url_lb')); ?>
			<br/>
			<?php echo CHtml::textField('xml_url',NULL, array('class'=>'copyTxtBox','readonly'=>true)); ?>  
		</div>
		<div class="clearfix">
			<?php echo CHtml::label('RSS URL',NULL, array('id' => 'rss_url_lb')); ?>
			<br/>
			<?php echo CHtml::textField('rss_url',NULL, array('class'=>'copyTxtBox','readonly'=>true)); ?>  
		</div>
		<div class="clearfix">
			<?php echo CHtml::label('TV URL',NULL, array('id' => 'tv_url_lb')); ?>
			<br/>
			<?php echo CHtml::textField('tv_url',NULL, array('class'=>'copyTxtBox','readonly'=>true)); ?> 
		</div>
                <div class="clearfix">
			<?php echo CHtml::label('TV URL 2',NULL, array('id' => 'tv_url2_lb')); ?>
			<br/>
			<?php echo CHtml::textField('tv_url2',NULL, array('class'=>'copyTxtBox','readonly'=>true)); ?> 
		</div>
	</div>
</div>