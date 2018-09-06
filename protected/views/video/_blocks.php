<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/jquery.jscrollpane.min.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/jquery.mousewheel.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/mwheelIntent.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
$cs->registerScript('scrollpane',"$('.scroll-pane').jScrollPane({scrollbarWidth:18,verticalDragMinHeight: 60,verticalDragMaxHeight: 60,horizontalDragMinWidth: 18,horizontalDragMaxWidth: 18,hideFocus: true});");
$videoFormat = '
    <div class="videoBlock">
        <div class="videoThumb"><a href="%s"><img src="%s" /></a></div>
        <div class="videoData" style="text-align:left;">
            <div class="videoTitle bold">%s</div>
            <div class="videoDate">%s</div>
            <div class="videoByline">by <a href="%s"><span class="bold">%s</span></a></div>
            <div class="videoViews">%s vistas</div>
            <div class="videoRate">%s</div>
        </div>
    </div>
';
$starNum = 0;
if(sizeof($videos) != 0){
    foreach($videos as $video){
        $video->user->first_name = (isset($video->user->first_name)) ? $video->user->first_name : $video->first_name;
        $video->user->last_name = (isset($video->user->last_name)) ? $video->user->last_name : $video->last_name;
        $stars='';
        for($i=0;$i<$video->rating;$i++){
            ++$starNum;
            $stars .= "<img src='/webassets/images/play/star_yellow.png' />";
        }
        for($t=0;$t<5-$i;$t++){
            ++$starNum;
            $stars .= "<img src='/webassets/images/play/star_white.png' />";
        }
        echo sprintf(
            $videoFormat,
            '/play/'.$video->view_key,
            '/'.basename(Yii::app()->params['paths']['video'])."/{$video->thumbnail}.png",
            $video->title,
            date("F j, Y",strtotime($video->created_on))." ".date("T"),            
            '/user/'.$video->user_id,
            $video->user->first_name.' '.$video->user->last_name,
            $video->views,
            $stars
        );
    }
}
?>