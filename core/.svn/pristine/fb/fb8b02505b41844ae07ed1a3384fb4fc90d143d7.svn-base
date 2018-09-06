<?php

class sendVideoToBrightcoveCommand extends CConsoleCommand {
    public function run($args){
        $bcutil = new BrightcoveUtility;
        $brightcoves = eBrightcove::model()->findAllByAttributes(Array('brightcove_id'=>'N/A'));
        foreach($brightcoves as $brightcove){   
            $video = eVideo::model()->findByPK($brightcove->video_id);
            $bcutil->publish($video);
        }
    }       
}

?>
