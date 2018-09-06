<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminTvScreenAppearSetting/index.css');
?>
<style>
    .tFormOverlay { width: auto; }
    .tFormOverlay label{ display: inline-block;min-width: 70px;font-weight: 900;}
</style>
<div class="tFormOverlay" id="header">
    <h2>Select Contestants from users</h2>
    <div id="flashMsg" style="display: none;" class="flash-success flashes"></div>
    <ul class="tabNav">
        <li class="selected" formId='selectContainer' onclick="triggerTab(this);"><a href="#">Contestant</a></li>
        <!--<li formId='createContainer' onclick="triggerTab(this);"><a href="#" >New User</a></li>-->
    </ul>
    <div class="formBox">
        <div id="selectContainer" class="content">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'admin-user-grid',
                'dataProvider' => $users->search(10),
                'filter' => $users,
                'columns' => array(
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}',
                        'buttons' => array(
                            'view' => array(
                                'url' => '$data->id',
                                'options' => array('onclick' => 'viewClicked(this);return false;'),
                            ),
                        ),
                    ),
                    'username',
                    array(
                        'name' => 'role',
                        'value' => 'CHtml::encode($data->role)',
                        'filter' => array('super admin' => 'super admin',
                            'site admin' => 'site admin',
                            'producer admin' => 'producer admin',
                            'user' => 'user'
                        ),
                    ),
                    array(
                        'name' => 'userPermissions',
                        'type' => 'raw',
                        'filter' => array('Yes' => 'Yes',
                            'No' => 'No',
                        ),
                    ),
                    'first_name',
                    'last_name',
                    array(
                        'name' => 'userEmails.email',
                        'type' => 'raw',
                        'value' => 'isset($data->userEmails[0]->email)? $data->userEmails[0]->email : ""',
                        'filter' => CHtml::activeTextField($users, 'email'),
                    ),
                ),
            ));
            ?>
        </div>
        <div class="clearfix  saveLabel">
            <div class="saveContainer">
                <div class="clearfix hintTxt preview" >Note: Please select a user to be contestant</div>
            </div>
        </div>
    </div>
</div>