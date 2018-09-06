<style>
    @media (max-width:767px){
        .hidden-xs{display:none!important
        }
    }
    @media (min-width:768px) and (max-width:991px){
        .hidden-sm{display:none!important
        }
    }
    @media (min-width:992px) and (max-width:1199px){
        .hidden-md{display:none!important
        }
    }
    @media (min-width:1200px){
        .hidden-lg{display:none!important
        }
    }
</style>
<div class="floatLeft hidden-md hidden-sm hidden-xs" style="width:40%;">
    <div style="padding-top:10px;overflow: hidden;">
<!--        <div style="float:left;width:240px;">
            <label for="birthday">
                <?php echo $form->labelEx($user, 'birthday'); ?>
            </label>
            <div>
                <?php echo $form->dropDownList($user, 'birthMonth', DateTimeUtility::monthsOfYear()); ?>
                <?php echo $form->dropDownList($user, 'birthDay', DateTimeUtility::daysOfMonth()); ?>
                <?php echo $form->dropDownList($user, 'birthYear', DateTimeUtility::yearsOfCentury()); ?>
                <?php echo $form->error($user, 'birthday'); ?>
            </div>
        </div>-->
    </div>
    <br/>
    <div class="clearfix">
        <div class="row">
            <label for="address"><?php echo Yii::t('youtoo', $form->labelEx($userLocation, 'address1')); ?></label>
            <?php echo $form->textField($userLocation, 'address1', array('class' => 'form-control', 'placeholder' => Yii::t('youtoo', 'Address'))); ?>
            <?php echo $form->error($userLocation, 'address1'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="row">
            <label for="city"><?php echo Yii::t('youtoo', $form->labelEx($userLocation, 'city')) ?></label>
            <?php echo $form->textField($userLocation, 'city', array('class' => 'form-control', 'placeholder' => Yii::t('youtoo', 'City'))); ?>
            <?php echo $form->error($userLocation, 'city'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="row">
            <label for="country"><?php echo Yii::t('youtoo', $form->labelEx($userLocation, 'country')) ?></label>
            <?php echo $form->dropDownList($userLocation, 'country', CountryUtility::getNames(), array('class' => 'form-control')); ?>
            <?php echo $form->error($userLocation, 'country'); ?>
        </div>
    </div><br/>
    <?php if (Yii::app()->name == 'Albousalah Games'): ?>
    <div class="clearfix">
        <div class="row" style="width: 450px">
            <label for="image"><?php echo Yii::t('youtoo', 'Photo ID') ?></label>
            <img id="imgMagnify" style="width:150px; height:100px;cursor: pointer;" src="<?php echo ClientUserUtility::getPhotoId($user); ?>" /><br/>
            <label for="upload"><?php echo Yii::t('youtoo', 'Upload Photo ID') ?></label>
            <?php echo $form->fileField($imageId, 'imageId'); ?>
            <?php echo $form->error($imageId, 'imageId'); ?>
            <?php
            echo CHtml::submitButton(Yii::t('youtoo', 'Upload Photo ID'), array('class' => 'btn btn-default btn-sm active',
                'role' => 'button'));
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>

