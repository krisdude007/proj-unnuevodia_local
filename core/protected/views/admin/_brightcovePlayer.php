<?php
if(!isset($width)) $width = '700';
if(!isset($height)) $height = '400';
?>
	<!-- Start of Brightcove Player -->
	
	<div style="display:none">
	
	</div>
	
	<!--
	By use of this code snippet, I agree to the Brightcove Publisher T and C
	found at https://accounts.brightcove.com/en/terms-and-conditions/.
	-->
	
	<script type="text/javascript" src="https://sadmin.brightcove.com/js/BrightcoveExperiences.js"></script>
	
	<object id="myExperience" class="BrightcoveExperience">
	  <param name="wmode" value="transparent" />                   
	  <param name="bgcolor" value="#FFFFFF" />
	  <param name="width" value="700" />
	  <param name="height" value="400" />
	  <param name="playerID" value="1833037780001" />
	  <param name="playerKey" value="AQ~~,AAABqrGtIvE~,QfeoOVnmCtVbHKx9CltiFq7VfqzEYEuW" />
	  <param name="isVid" value="true" />
	  <param name="dynamicStreaming" value="true" />
	  <param name="@videoPlayer" value="<?php echo $video->brightcove->brightcove_id; ?>" />
          <param name="secureConnections" value="true" />
          <param name="secureHTMLConnections" value="true" />
	</object>
	
	<!--
	This script tag will cause the Brightcove Players defined above it to be created as soon
	as the line is read by the browser. If you wish to have the player instantiated only after
	the rest of the HTML is processed and the page load is complete, remove the line.
	-->
	<script type="text/javascript">brightcove.createExperiences();</script>
	
	<!-- End of Brightcove Player -->
