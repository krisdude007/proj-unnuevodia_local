<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('infiniteScroll', "
    $('#pageNumber').val(" . ($pages->currentPage + 2) . ");//reset to page 2 when use back button.
    setFlag('image');//Better than \$images[0]->tableName(), which can be empty
    function loadItems(pageNo) {
        $.ajax({
            url: '" . Yii::app()->request->requestUri . "?page=' + pageNo,
            type:'GET',
            success: function(html){
                parsed = $.parseHTML(html);
                $('#pageNumber').val($(parsed).find('#pageNumber').val());//set next page to load from loaded
                html = $(parsed).find('#fabmob_videos-container').html();//get items to append
                $('#fabmob_videos-container').append(html);//append to scrolled elements
                setFlag('image');//Better than \$images[0]->tableName(), which can be empty
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
<div class="as-table">
    <div class="sorter text-center">
        <button class='btn btn-left <?php if (Yii::app()->request->getParam('order') == 'recent') echo 'btn-inverse activeBorder'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/images/recent'); ?>'" style='border-right: none;border-width: 1px; width: 33.3%;font-size: 14px;'>más recientes</button>
        <button class='btn btn-center <?php if (Yii::app()->request->getParam('order') == 'views') echo 'btn-inverse activeBorder'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/images/views'); ?>'" style='border-width: 1px; width: 31.3%;font-size: 14px;'>más vistos</button>
        <button class='btn btn-right <?php if (Yii::app()->request->getParam('order') == 'rating') echo 'btn-inverse activeBorder'; ?>' onclick="window.location = '<?php echo Yii::app()->createUrl('/images/rating'); ?>'" style='border-left: none; border-width: 1px; width: 35.3%;font-size: 14px;'>mejor calificados</button>
    </div>
    <div class="homeTop">
        <b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día
    </div>
    <div class="as-table-row">
        <div id="scroll" style="position:relative; height:100%;overflow: scroll;">
            <div id="fabmob_videos-container" style="position:absolute; left:0;right:0;top:0;right:0;">
                <?php
                $imageFormat = '
                    <div class="fabmob_video-container">
                        <div class="videoThumb"><a href="%s"><img src="%s" class="middleCenter"></a></div>
                        <div class="fabmob_video-copy-container">
                            <img src="%s" style="float:left;width:40px;height:40px;border-radius: 20px;margin-right:8px;">
                            <h6 style="float:right;">%s</h6>
                            <h5 class="fabmob_video-title">%s</h5>
                            <h6>%s</h6>
                            <img src="/webassets/mobile/images/Icon_Views.png" style="height:14px;"> <span>%s</span> &nbsp;&nbsp;&nbsp;
                            <img src="/webassets/mobile/images/Icon_Rating.png" style="height:14px;"> <span>%s</span>
                            <div style="float:right;">
                                <a class="flag" tbl="%s" contentId="%s" onclick="popupReport(this)">
                                    <img src="/webassets/mobile/images/icon_flag.png" style="height:14px;"> Flag Image
                                </a>
                            </div>
                        </div>
                    </div>
                ';
                foreach ($images as $image) {
                    //$player = (isset($image->brightcoves[0]->brightcove_id) && is_numeric($image->brightcoves[0]->brightcove_id)) ? '_brightcovePlayer' : '_fallbackPlayer';
                    //$player = '_fallbackPlayer';
                    $fullname = empty(trim($image->user->first_name . " " . $image->user->last_name)) ? "N/A" : trim($image->user->first_name . " " . $image->user->last_name);
                    $stars = '';
                    $starNum = 0;
                    for ($i = 0; $i < $image->rating; $i++) {
                        ++$starNum;
                        $stars .= "<img src='/webassets/images/play/star_yellow.png' />";
                    }
                    for ($t = 0; $t < 5 - $i; $t++) {
                        ++$starNum;
                        $stars .= "<img src='/webassets/images/play/star_white.png' />";
                    }
                    echo sprintf(
                            $imageFormat, '/viewimage/' . $image->view_key, '/' . basename(Yii::app()->params['paths']['image']) . "/{$image->filename}", UserUtility::getAvatar($image->user), date('M d, Y', strtotime($image->created_on)),
                            //'/' . basename(Yii::app()->params['paths']['video']) . "/{$image->thumbnail}.png",
                            $fullname, $image->title,
                            //date("F j, Y",strtotime($image->created_on))." ".date("T"),
                            $image->views, $image->rating, $image->tableName(), $image->id
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pageNumber" value="<?php echo($pages->currentPage + 2); ?>">