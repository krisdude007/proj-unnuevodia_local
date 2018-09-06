<?php $this->renderPartial('/csrf/_csrfToken'); ?> 
<div id="content">
    <div class="centerBlock">
        <div id="voteDetail" style="text-align: center;">
            <?php if (!is_null($activePoll)): ?>
                <div id="voteHead" style="text-align: center"> 
                    <h1>
                        <?php if (strtotime($activePoll->end_time) <= time()): ?>
                            VOTACIÓN CERRADA!
                        <?php else: ?>
                            VOTA AHORA                
                        <?php endif; ?>
                    </h1>            
                    <div id="question" style="font-family: Helvetica, Arial, sans-serif;font-size:24px;font-weight:100;margin-bottom: 12px;">
                        <?php echo $activePoll->question; ?>                        
                    </div>
                </div>
                <div class="afterVote" <?php echo (strtotime($activePoll->end_time) <= time()) ? 'style="display:none"' : ''; ?>>
                    <?php
                    $this->renderPartial('_voteButtons', array('answers' => $activePoll->pollAnswers));
                    ?>
                </div>
                <div class="afterVote" <?php echo (strtotime($activePoll->end_time) <= time()) ? '' : 'style="display:none"'; ?>>
                    <div style="width:580px;display: inline-block;padding:5px;">
                        <?php $this->renderPartial('_voteGraph', array('poll' => $activePoll)); ?>
                    </div>    
                    <div id="buttonsafter" style="width:150px; float:right;">
                        <?php if (strtotime($activePoll->end_time) >= time()): ?>                    
                        <div><a class="linkButton" href="/vote" style="width:120px; text-align: center;">VOTA DE NUEVO</a></div> 
                        <?php endif; ?>
                        <div><a class="linkButton" href="/questions" style="width:120px;text-align: center;">GRABA UN VIDEO</a></div>
                        <div><a class="linkButton" href="/image" style="width:120px;text-align: center;">SUBE UNA FOTO</a></div>
                    </div>                
                </div>
            <?php else: ?>
                <h1>
                    SIN VOTACIÓN ABRE!
                </h1>
            <?php endif; ?>
        </div>
    </div>
</div>
