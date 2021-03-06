<div class="form">
<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-profileimage-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
        'validateOnSubmit' => true,),
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
?>
<?php echo $form->errorSummary(Array($image)); ?>
<table class="formProfile">
    <tr>
        <td>
        Foto actual
    </td>
        <td colspan="2">
    </td>
    </tr>

    <tr>
        <td>
            <img style="max-height:50px; max-width:50px" src="<?php echo UserUtility::getAvatar($user);?>" />
       </td>
        <td colspan="2">
            Sube una nueva foto<br/>
           <?php echo $form->fileField($image, 'image'); ?>
            <?php echo $form->error($image, 'image', array('clientValidation' => 'js:customValidateFile(messages)'), false, true);
            $infoFieldFile = (end($form->attributes));
            ?>
       </td>
    </tr>
     <tr>
         <td></td>
        <td>
            <?php echo CHtml::submitButton('GUARDAR',array('style'=>'width:150px;')); ?>
         </td>
    </tr>
    </table>

<?php $this->endWidget(); ?>
</div>
<script>
    function customValidateFile(messages){
        var nameC= '#<?php echo $infoFieldFile['inputID']; ?>';

        var control = $(nameC).get(0);

        //simulates the required validator and allowEmpty setting of the file validator
        if (control.files.length==0) {
            messages.push("La imagen no puede estar en blanco");
            return false;
        }

        file = control.files[0];

    }

</script>
