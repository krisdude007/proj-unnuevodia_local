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
            	<?php echo $campaign->campaign_title; ?> 
            	<a class="fab-btn fab-green" href='<?php echo Yii::app()->createUrl('/adminCampaign/update', array('id'=>$campaign->id));?>' class='btn btn-small'>Edit</a>
            	<a class="fab-btn fab-green" href="<?php echo  $this->createUrl('adminCampaign/changePackage', array('id'=>$campaign->id)); ?>">Change Package </a>
            	<a class="fab-btn fab-green" href="<?php echo  $this->createUrl('adminCampaign/createPost', array('id'=>$campaign->id)); ?>">New Post </a>
            </div>
            <?php if(!$campaign->status): ?> 
            	(Stopped)
            <?php endif;?>
            <div class="campaign_divider"></div>
             
             
         
        
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
    <?php
        $this->widget('zii.widgets.grid.CGridView', array(
        	'id'=>'campaign-grid',
        	'dataProvider'=>$campaign_post->searchByCampaignId($campaign->id),
        	'filter'=>$campaign_post,
        	'columns'=>array(
        		array(
        			'header'=>'Media',
        		    'type'=>'raw',
        		    'cssClassExpression'=>'"img_tr"',
        		    'value'=>'CHtml::image(
        		    	( ($data->media_type == "video" && isset($data->video)) ? 
        		    	"/".basename(Yii::app()->params["paths"]["video"])."/".$data->video->thumbnail.".gif" :
        		    	($data->media_type == "image" && isset($data->image) ? "/".basename(Yii::app()->params["paths"]["image"])."/". $data->image->filename : "") ), 
        		    	
        		    	(($data->media_type == "video" && isset($data->video)) ? $data->video->title : (isset($data->image) ? $data->image->title : "")), 
        		    	
        		    	array(
        		    		"data-toggle"=>"modal", "data-target"=>"#modal","class"=>"image_icon","media_type"=>$data->media_type,
        		    		"video"=>isset($data->video->filename) ? Yii::app()->createAbsoluteUrl("/")."/".basename(Yii::app()->params["paths"]["video"])."/".$data->video->filename.".mp4" : "",
        		    		"thumbnail"=>isset($data->video->filename) ? Yii::app()->createAbsoluteUrl("/")."/".basename(Yii::app()->params["paths"]["video"])."/".$data->video->filename.".png" : "",
        		    		"style"=>"width:100px;"
        		    	)
        		    )'
        		),
        		array(
        		    'header'=>'Day',
        		    'value'=>'date("l", strtotime($data->post_time))',
        		),
        		array(
        			'header'=>'Time(ET)',
        		    'value'=>'date("g:s A", strtotime($data->post_time))',
        		),
        		'post_content', 
                'hash_tag',
                
        		 
        		array(
        			'class'=>'CButtonColumn',
        		    'template'=>'{update}{delete}',
        		    'deleteButtonUrl'=>'Yii::app()->createUrl("/adminCampaign/deletePost", array("post_id"=>$data->id))',
        		    'updateButtonUrl'=>'Yii::app()->createUrl("/adminCampaign/updatePost", array("post_id"=>$data->id))',
        		),
        		array(
        		    'header'=>'',
                    'type'=>'raw',
        		    'value'=>'CHtml::button("Post Now", array("class"=>"btn btn-primary post","id"=>$data->id))'
        		)
        	),
        )); 
    ?>
         
    </div>
    <!-- END PAGE CONTAINER-->
</div>   

<div id="modal" class="modal hide fade upgrade_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header upgrade_modal_header"> 
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign"></i></button> 
    <div id="myModalLabel"></div>
  </div>
  <div class="modal-body text-center">
     <img id='large_image' src="">
     <video id='video' width="320" height="240" controls>
        <source id='video_source' src="" type="video/mp4">
     </video>
	 <div id='flash_player' style='display:none'>
	 	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="320" height="240">
            <param name="movie" value="/core/webassets/swf/StrobeMediaPlayback.swf"></param>
            <param name="FlashVars" value=""></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed src="/core/webassets/swf/StrobeMediaPlayback.swf"
                   type="application/x-shockwave-flash"
                   allowscriptaccess="always" allowfullscreen="true"
                   width="320" height="240"
                   FlashVars="">
            </embed>
        </object>
	 </div>
   </div>
</div>
 
	 
<script type="text/javascript">
	$(function(){
		if(/Firefox/.test(navigator.userAgent) == true) {
			$('video').remove();
			$('#flash_player').show();
    		$('#modal').modal('show').modal('hide');
		}
		$('.image_icon').click(function(){
			var image = $(this);
    		$('#modal').on('show.bs.modal', function (e) {
        		$('#myModalLabel').text(image.attr('alt'));
        		if(image.attr('media_type') == 'video') {
            		$('#large_image').hide();
            		if(/Firefox/.test(navigator.userAgent) == true) {
            			$('object').find('param[name="FlashVars"]').val('src='+ image.attr('video')+'&poster=' + image.attr('thumbnail')+'&backgroundColor=FFFFFF');
                		$('object').find('embed').attr('FlashVars','src='+ image.attr('video')+'&poster=' + image.attr('thumbnail')+'&backgroundColor=FFFFFF');
                		$('#flash_player').show();
            		} else {
                		$('#video_source').attr('src', image.attr('video'));
                		$('#video').load().show();
            		}
        		} else {
            		
            		if(/Firefox/.test(navigator.userAgent) == true) {
            			$('#flash_player').hide();
            		} else {
                		$('#video').hide();
            		}
    				$('#large_image').attr('src', image.attr('src')).show();
        		}
    		});
		});

		$('.post').click(function(e){
			var post_id = $(this).attr('id');
			if(confirm('Are you sure to post this to social media right now?')) {
				FB.login(function(response) {
	                if (response.authResponse) {            
	                    var request = $.ajax({
	                        url:"/user/ajaxFacebookConnect",
	                        type:'POST',
	                        data:({
	                            'CSRF_TOKEN':getCsrfToken(),
	                            'accessToken':response.authResponse.accessToken,
	                            'expiresIn':response.authResponse.expiresIn,
	                            'userID':response.authResponse.userID
	                        }),
	                        success: function(res){
	                        	 var request = $.ajax({
	            					url:'<?php echo Yii::app()->createUrl('/adminCampaign/post'); ?>',
	            					type: 'POST',
	            					dataType : 'json',
	            					data: {post_id:post_id},
	            				}).done(function(data){
	            					var msg = (data.facebook) ? (data.facebook + "\n"): '';
	            					if(data.twitter) msg += data.twitter;
	            					alert(msg);
	            				})
	                        }
	                    });
	                }
	            },{
	                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update,manage_pages'
	            });                                
				 
			}
		})
	})
</script>
<!--

//-->
</script>
