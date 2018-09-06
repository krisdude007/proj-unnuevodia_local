<div id="voteList" style="margin-top:60px">
<?php
foreach ($polls as $poll){
    echo "<div>{$poll->question}</div>";
}
?>
</div>        
