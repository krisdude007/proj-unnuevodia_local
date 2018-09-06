<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile('/core/webassets/css/game/reveal.css');
$cs->registerCoreScript('jquery', CClientScript::POS_END);
?>

<style type="text/css">
    
.imageMain {
    width: <?php echo $reveal->image_main_w; ?>px; 
    height: <?php echo $reveal->image_main_h; ?>px; 
    margin: auto; 
    background-size: <?php echo $reveal->image_main_w; ?>px <?php echo $reveal->image_main_h; ?>px; 
    background-image: url('<?php echo $reveal->grid_background; ?>');
    color: black;
    font-size: 26px;
    font-weight: bold;
}

.imageSection {
    float: left; 
    width: <?php echo $reveal->image_section_w; ?>px; 
    height: <?php echo $reveal->image_section_h; ?>px;
    background: <?php echo $reveal->square_color; ?>;
    opacity: .995;
    text-align: center;
    border: 1px solid black;
}

.imageSection p {
    margin: <?php echo $reveal->image_section_h/2-10; ?>px 0px 0px 0px;
}

.imageOpaque {
    opacity: .1;
}
    
</style>

<script type="text/javascript">
    
var grid_id = <?php echo $reveal->id; ?>;
    
$(document).ready(function() {
    window.setInterval(checkGrid, 2000);
});

function checkGrid()
{
    gameRevelGridGetAjax(grid_id);
}

function gameRevelGridGetAjax(id) {
    var data = {grid_id:id};
    var request = $.ajax({
        url: "/game/ajaxRevealGridGet",
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(data){
            $.each(data, function(i) {
                  if(data[i].is_shown == 1)
                  {
                     $("#bk"+data[i].grid_section).addClass("imageOpaque");
                  }
                  else
                  {
                      $("#bk"+data[i].grid_section).removeClass("imageOpaque");
                  }
            });
        }
    });
}

</script>

<div class="imageMain">
    <?php
    for($i=1; $i<=$reveal->total_squares; $i++)
    {
        echo '<div id="bk'.$i.'" class="imageSection"><p>'.$i.'</p></div>';
    }
    ?>
</div>




                

