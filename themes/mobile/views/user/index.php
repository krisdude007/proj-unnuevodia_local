<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('infiniteScroll', "
    $('#pageNumber').val(".($pages->currentPage + 2).");//reset to page 2 when use back button.
    function loadItems(pageNo) {
        $.ajax({
            url: '" . Yii::app()->request->requestUri . "?page=' + pageNo,
            type:'GET',
            success: function(html){
                parsed = $.parseHTML(html);
                $('#pageNumber').val($(parsed).find('#pageNumber').val());//set next page to load from loaded
                html = $(parsed).find('#fabmob_videos-container').html();//get items to append
                $('#fabmob_videos-container').append(html);//append to scrolled elements
            }
        });
        return false;
    }
    $('#scroll').scroll(function(){
        if  ($('#scroll').scrollTop() + $('#scroll').height() >= $('#fabmob_videos-container').height() ){//compare scrollable height with scrolled elements
            pageNo  = $('#pageNumber').val();//get page number to load
            if(" . $items_count . " > " . $page_size . " * (pageNo-1)){//do if not over last page
                $('#spinerWrap').fadeIn( 200 );
                loadItems(pageNo);
                $('#spinerWrap').fadeOut( 200 );
            }
        }
    });
    ", CClientScript::POS_READY);
?>
<?php $fullname = empty(trim($user->first_name . " " . $user->last_name)) ? "N/A" : trim($user->first_name . " " . $user->last_name); ?>
<div class="as-table">
    <div style="padding: 2%;overflow: hidden;">
        <img class='userAvatarSM' style="float:left;" src="<?php echo UserUtility::getAvatar($user); ?>"/>
        <div class="fabmob_user-copy-container" style="float:left;">
            <h4><?php echo $fullname ?></h4>
            <h6 class="fabmob_video-count"><?php echo ClientUtility::getNumVideos($user->id); ?> vídeos</h6>
            <h6><?php echo ClientUtility::getNumTexts($user->id); ?> shouts</h6>
            <h6><?php echo ClientUtility::getNumVotes($user->id); ?> votes</h6>
        </div>
    </div>
    <div class="sorter text-center">
        <button class='btn btn-left <?php if (Yii::app()->request->getParam('order') == 'recent') echo 'btn-inverse'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/user/recent'); ?>'" style='border-right: none;border-width: 1px; width: 33.3%; font-size: 14px;'>más recientes</button>
        <button class='btn btn-center <?php if (Yii::app()->request->getParam('order') == 'views') echo 'btn-inverse'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/user/views'); ?>'" style='border-width: 1px; width: 31.3%;font-size: 14px;'>más vistos</button>
        <button class='btn btn-right <?php if (Yii::app()->request->getParam('order') == 'rating') echo 'btn-inverse'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/user/rating'); ?>'" style='border-left: none; border-width: 1px; width: 35.3%;font-size: 14px;'>mejor calificados</button>
    </div>
    <div class="as-table-row">
        <div id="scroll" style="position:relative; height:100%;overflow: scroll;">
            <div id="fabmob_videos-container" style="position:absolute; left:0;right:0;top:0;right:0;">
                <?php
                $videoFormat = '
                    <div class="fabmob_video-container">
                        <div class="videoThumb"><a href="%s"><img src="/webassets/mobile/images/Button_Play.png" class="middleCenter" style="z-index:100;"></a><img src="%s" class="middleCenter"></div>
                        <div class="fabmob_video-copy-container">
                            <img src="%s" style="float:left;width:40px;height:40px;border-radius: 20px;margin-right:8px;">
                            <h6 style="float:right;">%s</h6>
                            <h5 class="fabmob_video-title">%s</h5>
                            <h6>%s</h6>
                            <img src="/webassets/mobile/images/Icon_Views.png" style="height:14px;"> <span>%s</span> &nbsp;&nbsp;&nbsp;
                            <img src="/webassets/mobile/images/Icon_Rating.png" style="height:14px;"> <span>%s</span>
                        </div>
                    </div>
                ';
                foreach ($videos as $video) {
                    //$player = (isset($video->brightcoves[0]->brightcove_id) && is_numeric($video->brightcoves[0]->brightcove_id)) ? '_brightcovePlayer' : '_fallbackPlayer';
                    $player = '_fallbackPlayer';
                    $fullname = empty(trim($video->user->first_name . " " . $video->user->last_name)) ? "N/A" : trim($video->user->first_name . " " . $video->user->last_name);
                    $stars = '';
                    $starNum = 0;
                    for ($i = 0; $i < $video->rating; $i++) {
                        ++$starNum;
                        $stars .= "<img src='/webassets/images/play/star_yellow.png' />";
                    }
                    for ($t = 0; $t < 5 - $i; $t++) {
                        ++$starNum;
                        $stars .= "<img src='/webassets/images/play/star_white.png' />";
                    }
                    echo sprintf(
                            $videoFormat, '/play/' . $video->view_key, '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->thumbnail}.png", UserUtility::getAvatar($video->user), date('M d, Y', strtotime($video->created_on)),
                            //'/' . basename(Yii::app()->params['paths']['video']) . "/{$video->thumbnail}.png",
                            $fullname, $video->title,
                            //date("F j, Y",strtotime($video->created_on))." ".date("T"),
                            $video->views, $video->rating
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pageNumber" value="<?php echo($pages->currentPage + 2); ?>">