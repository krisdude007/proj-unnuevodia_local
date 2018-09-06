 
<?php $form = $this->beginWidget('CActiveForm', array(
          'id' => 'campaign-form-step2',
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
      ));
?>
<div class='row'>
    <div class='campaign_form_element'>
    	 
    	
    	<?php echo $form->labelEx($campaign, 'show_title', array('class'=>'label')); ?>
    	<br/>
        <?php echo $form->textField($campaign, 'show_title'); ?>
        <?php echo $form->error($campaign, 'show_title'); ?>
    	 
    </div>
    <div class='campaign_form_element'>
    	<?php echo $form->labelEx($campaign, 'campaign_title', array('class'=>'label')); ?>
    	<br/>
        <?php echo $form->textField($campaign, 'campaign_title'); ?>
        <?php echo $form->error($campaign, 'campaign_title'); ?>
    </div>
</div>
<div class='row'> 
    <div class='campaign_form_element'>
    	<?php echo $form->labelEx($campaign, 'show_airing_time', array('class'=>'label', 'label'=>'Show Airing(All Times ET)')); ?>
    	<br/>
        <?php echo $form->dropDownList($campaign, 'occurrence', array('Daily'=>'Daily','Weekly'=>'Weekly'), array('style'=>'width:120px')); ?>
        <?php echo $form->error($campaign, 'show_airing_time'); ?>
        <?php echo $form->dropDownList($campaign, 'day', Utility::getDayArray(), array('style'=>'width:120px')); ?>
        <?php echo $form->error($campaign, 'day'); ?>
        <span>
            <span class='label'>Time</span>
            <?php echo $form->dropDownList($campaign, 'hour', Utility::getHourArray(), array('style'=>'width:60px;'));  ?>
            <span class='label'>:</span>
            <?php echo $form->dropDownList($campaign, 'minute', Utility::getMinuteArray(), array('style'=>'width:60px;'));  ?>
            
            <?php echo $form->dropDownList($campaign, 'am', array('AM'=>'AM','PM'=>'PM'), array('style'=>'width:60px;'));  ?>
        </span>
        <span>
            <span class='label'>Start/End Date</span>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'attribute'=>'start_date',
                'model'=> $campaign,
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>"yy-mm-dd",
            		'defaultDate'=> '+1',
                    'onSelect'=>'js:function(dateText, inst) {
                          curDate = $(this).datepicker("getDate");
						  dayName = $.datepicker.formatDate("DD", curDate);
						  $("#start_day").text(dayName);
                       }'
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;width:120px'
                ),
            ));?>
            -
            <?php  $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'attribute'=>'end_date',
                    'model'=>$campaign,
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
            			'dateFormat'=>"yy-mm-dd",
                        'defaultDate'=> '+8',
            			'onSelect'=>'js:function(dateText, inst) {
                          curDate = $(this).datepicker("getDate");
						  dayName = $.datepicker.formatDate("DD", curDate);
						  $("#end_day").text(dayName);
                       }'
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;width:120px'
                    ),
                ));
            ?>
        </span>
        <?php echo $form->error($campaign, 'start_date'); ?>
        <?php echo $form->error($campaign, 'end_date'); ?>
    	 
    </div>
     
</div>
 <div class='row'>
    <div class='campaign_form_element'>
        <span class='label'>Run Week Starts On</span>
        <span id='start_day'><?php if($campaign->start_date) echo date('l', strtotime($campaign->start_date)); ?></span>
        <span class='label'> Ends On</span>
        <span id='end_day'><?php if($campaign->end_date) echo date('l', strtotime($campaign->end_date)); ?></span>
    </div>
</div>
 <div class='row'>
    <div class='campaign_form_element'>
    	<?php echo $form->labelEx($campaign, 'show_info', array('class'=>'label')); ?>
    	<br/>
        <?php echo $form->textField($campaign, 'show_info'); ?>
        <?php echo $form->error($campaign, 'show_info'); ?>
    </div>
</div>
 <div class='row'>
    <div class='campaign_form_element'>
    	<?php echo $form->labelEx($campaign, 'tags', array('class'=>'label')); ?>
    	<br/>
        <?php echo $form->textField($campaign, 'tags', array('placeholder'=>'Enter tags for SEO purpose',
                                'data-toggle'=>'popover',
                                'data-content'=>'Suggested Tags could be: cast/crew, common phrases,etc',
                                'onfocus'=>'$(this).popover();'
              )); 
        ?>
        <?php echo $form->error($campaign, 'tags'); ?>
    </div>
</div>
 <div class='row'>
    <div class='campaign_form_element'>
    	<?php echo $form->labelEx($campaign, 'hashtags', array('class'=>'label')); ?>
    	<br/>
        <?php echo $form->textField($campaign, 'hashtags', array('placeholder'=>'For Twitter and Facebook')); ?>
        <?php echo $form->error($campaign, 'hashtags'); ?>
    </div>
</div>

<div class='row campaign_customize_row'>
    <span class='campaign_customize'>Customize</span> 
    <?php if($campaign->occurrence): ?>
    	<input type="checkbox" checked> 
    <?php endif;?>
    <span>Do you want this campaign to reoccur? If so, select number of weeks</span>
    <span><?php echo CHtml::dropDownList('weeks', $campaign->getReoccurrenceWeeks() ,$campaign->getWeeksArray(), array('class'=>'weeks'));?></span>
</div>

<div class=''>
	<a href='' >Go Back</a>
</div>
<div class="campaign_continue_button">
	<button type="reset" class='btn' value="Reset">Cancel</button>
	<input type="hidden" name="submit_step1" value='step1' />
    <?php echo CHtml::submitButton('Continue', array('class'=>'btn btn-primary')); ?>
</div>
<?php $this->endWidget(); ?>
