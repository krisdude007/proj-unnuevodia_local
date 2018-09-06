<div id="content">

    <div class="questions centerBlock">
        <div class="stepQuestions">
            <div class="textHead1">1</div>
            <div class="textHead2">ELIGE</div>
            <div class="textHead3">UN TEMA</div>
        </div>
        <div class="stepQuestions">
            <div class="textHead1">2</div>
            <div class="textHead2">GRABA</div>
            <div class="textHead3">TU VIDEO</div>
        </div>
        <div class="stepQuestions">
            <div class="textHead1">3</div>
            <div class="textHead2">ENVÍA</div>
            <div class="textHead3">COMIENZA ABAJO</div>

        </div>
        <div style="display:inline-block;color:#fff; width:573px;">

            <div class="bold" style="clear:both;padding:10px; background-color: #F57A24;">
                <div style="text-align:center;">
                    Haz clic en la pregunta que quieras contestar en tu video.<br>
                    ¡Ya estás un poco más cerca de salir en la TV!
                </div>
            </div>
        </div>
        <?php $i = 1; ?>
        <?php foreach ($questions as $question): ?>
        <div class="<?php echo $i % 2 == 0 ? 'even' : 'odd';?>">
            <a href="/record?id=<?php echo $question->id;?>">
                <div class="questionTopic"><?php echo $i; ?> Tema</div>
                <div style="float:left;width:425px;"><?php echo $question->question; ?></div>
            </a>
            <?php ++$i; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
