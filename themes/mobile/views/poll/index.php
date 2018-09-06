<?php $this->renderPartial('/csrf/_csrfToken'); ?>
<div id="content">
    <div <?php echo ($this->isMobile() && Yii::app()->params['useMobileTheme'] == true) ? 'class="homeTop" style="background-color: #d68a28; display: block;"' : 'style="display:none;"'; ?>><b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día</div>
    <div class="centerBlock">
        <br/>
        <div id="voteDetail">
            <?php if (!is_null($activePoll)): ?>
                <div class="afterVote" <?php echo (strtotime($activePoll->end_time) <= time()) ? 'style="display:none"' : ''; ?> rel='<?php echo $activePoll->id; ?>'>
                    <div id="voteHead" class='row text-center'>
                    <h1 style="color: #ffffff;padding-bottom: 15px;">
                        <?php if (strtotime($activePoll->end_time) <= time()): ?>
                            Voting Closed!
                        <?php else: ?>
                            <?php echo Yii::t('system', 'Votación'); ?>
                        <?php endif; ?>
                    </h1>

                    <div id="question" <?php echo ($this->isMobile() && Yii::app()->params['useMobileTheme'] == true) ? 'style="margin : auto; width: 85%"' : 'style="font-size:18px; color: #ffffff;"' ?>>
                        <?php echo $activePoll->question; ?>
                    </div>
                </div>
                <br>
                    <div class="row text-center"><img src="/webassets/mobile/images/Icon_Vote.png" style="max-width: 55px; width: 100%; margin-bottom: 15px;"/>
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="row">
                            <?php foreach ($activePoll->pollAnswers as $answer): ?>
                                <?php if (count($activePoll->pollAnswers) == 3): ?>
                                    <div class="col-sm-4">
                                        <a href="#" class="btn voteButton bold white" style="color: #ffffff !important; border-color: #ffffff !important;" rel="<?php echo $answer->id; ?>">
                                            <?php echo $answer->answer; ?>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div <?php echo (!Yii::app()->params['useMobileTheme'] && !$this->isMobile()) ? 'class="col-sm-6"' : 'class="col-sm-6" style="margin-bottom: 10px;"'; ?>>
                                        <a href="#" class="btn voteButton bold white" style="color: #ffffff !important; border-color: #ffffff !important; min-width: 220px !important; max-width: 350px;" rel="<?php echo $answer->id; ?>">
                                            <?php echo $answer->answer; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="afterVote" <?php echo (strtotime($activePoll->end_time) <= time()) ? '' : 'style="display:none"'; ?>>
                    <div id="voteHead" class='row text-center'>
                    <h1 style="color: #ffffff;padding-bottom: 15px;">
                        <?php if (strtotime($activePoll->end_time) <= time()): ?>
                            Voting Closed!
                        <?php else: ?>
                            <?php echo Yii::t('system', 'Resultados de Votación'); ?>
                        <?php endif; ?>
                    </h1>

                    <div id="question" <?php echo ($this->isMobile() && Yii::app()->params['useMobileTheme'] == true) ? 'style="margin : auto; width: 85%"' : 'style="font-size:18px; color: #ffffff;"' ?>>
                        <?php echo $activePoll->question; ?>
                    </div>
                </div>
                    <div class='col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 vote_div'>
                        <?php foreach ($activePoll->pollAnswers as $answer): ?>
                            <div class='vote_label'>
                                <span <?php echo (!Yii::app()->params['useMobileTheme'] && !$this->isMobile()) ? "class='pull-left'" : ""; ?>><?php echo $answer->answer; ?></span>
                                <span class='pull-right percent'>0%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"  >
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="row text-center">
                        <div class='form group col-sm-12'>
                            <?php if (strtotime($activePoll->end_time) <= time()): ?>
                                <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;"><a href="/vote" class='btn voteButtons center-block' style="min-width: 185px !important;width: 100%;">Votación</a></div>
                            <?php else: ?>
                                <div class="col-sm-6" style="margin-bottom: 10px;padding-left: 0px; padding-right: 0px;"><a href="<?php echo Yii::app()->createUrl('/poll/index'); ?>" class="btn voteButtons" style="color: #ffffff !important; border-color: #ffffff !important; min-width: 145px !important; min-height: 45px !important; padding: 3% 2% !important; font-size: 100%; width: 100%;">Vota de Nuevo</a></div>
                            <?php endif; ?>
                            <div class="col-sm-6" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;"><a href="<?php echo Yii::app()->createUrl('/site/index'); ?>" class="btn voteButtons" style="color: #ffffff !important; border-color: #ffffff !important; min-width: 145px !important; min-height: 45px !important; padding: 3% 2% !important; font-size: 100%;width: 100%;">Página Principal</a></div>
                            <div class="col-sm-6;padding-left: 0px; padding-right: 0px;"><a href="<?php echo Yii::app()->createUrl('/video/index', array('order' => 'recent')); ?>" class="btn voteButtons" style="color: #ffffff !important; border-color: #ffffff !important; min-width: 145px !important; min-height: 45px !important; padding: 3% 2% !important; font-size: 100%;width: 100%;">Ver Vídeos</a></div>
                        </div>
                    </div>
                    </div>
                </div>
            <?php else: ?>
                <div class='row text-center'>
                    <h1><?php echo Yii::t('youtoo','No Polls Open') ?></h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

