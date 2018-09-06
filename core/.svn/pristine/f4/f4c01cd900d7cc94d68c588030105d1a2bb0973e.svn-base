<html dir="rtl">
    <head>
        <title><?php echo Yii::t('youtoo','Print Game Invoice'); ?></title>
    </head>
    <body onload='window.print()'>
        <table width='700' >
            <tr>
                <td valign='top' width="350">
                    <img src='/webassets/images/logoTmp.png'/>
                    <h1 style='margin-bottom: 0;'><?php echo Yii::t('youtoo','Game Invoice'); ?> #<a target="_blank" href="<?php echo '/admin/gamechoice/multiple/'.$game->id; ?>"><?php echo $game->id; ?></a></h1>
                </td>
                <td valign='top' width="350">
                    <h1 style='margin-bottom: 0'><?php echo Yii::t('youtoo','Al Bousalah Game'); ?></h1>
                    <div><?php echo Yii::t('youtoo','Dubai Media City / Building No. 7 - i 1'); ?></div>
                    <div><?php echo Yii::t('youtoo','Dubai / United Arab Emirates'); ?></div>
                </td>
            </tr>
        </table>

        <div>&nbsp;</div>

        <table width='70%' style="direction: rtl;">
            <tr>
                <td valign='top'>
                    <h2 style='margin-bottom: 0'><?php echo Yii::t('youtoo','Ship To'); ?>:</h2>
                    <div><strong><?php echo Yii::t('youtoo','Date of Invoice');?>:</strong> <?php echo $game->updated_on; ?></div>
                    <?php if ($user->first_name != '' && $user->last_name != ''): ?>
                        <div><strong><?php echo Yii::t('youtoo','Name'); ?>:</strong> <?php echo $user->first_name; ?> <?php echo $user->last_name; ?></div>
                    <?php endif; ?>
                    <div><strong><?php echo Yii::t('youtoo','User ID');?>:</strong> <?php echo $user->id; ?></div>
                    <div><strong><?php echo Yii::t('youtoo','User Name'); ?>:</strong> <?php echo $user->username; ?></div>
                    <div><strong><?php echo Yii::t('youtoo','Phone Number'); ?>:</strong> <?php echo $user->username; ?></div>

                    <div><strong><?php echo Yii::t('youtoo','Address'); ?>:</strong></div>
                    <div style="margin: 0px 0px 0px 20px;">
                    <div> <?php echo $user->userLocations[0]->address1; ?> </div>
                    <div> <?php echo $user->userLocations[0]->address2; ?> </div>
                    <div> <?php echo $user->userLocations[0]->city; //.", ".$user->userLocations[0]->state." ".$user->userLocations[0]->postal_code; ?> </div>
                    <div> <?php echo $user->userLocations[0]->country; ?> </div>
                    <div>
                </td>
            </tr>
        </table>

        <div>&nbsp;</div>

        <table width='700' style="direction: rtl;">
            <tr style='background-color: #DDDDDD'>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Line Item'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Game ID'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Start Date'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Game Question'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Correct Answer'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Prize Name'); ?></th>
                <th style='text-align: right'><?php echo Yii::t('youtoo','Qty'); ?></th>
            </tr>
            <tr>
                <td valign='top'>
                    1
                </td>
                <td valign='top'>
                    <?php echo $game->id; ?>
                </td>
                <td valign='top'>
                    <?php echo $game->start_date; ?>
                </td>
                <td valign='top'>
                    <?php echo $game->question; ?>
                </td>
                <td valign='top'>
                    <?php echo $game->gameChoiceAnswers[0]->answer; ?>
                </td>
                <td valign='top'>
                    <?php echo $game->prize; ?>
                </td>
                <td valign='top'>
                    1
                </td>
            </tr>
        </table>

    </body>
</html>