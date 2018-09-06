<?php

class clientVideoUploadForm extends FormVideoUpload {

     
    public $question_id;
    public $video;
    public function rules() {

            return array(
            array('question_id', 'required'),
            array('video', 'required' ,'message'=>Yii::t('youtoo','Video cannot be blank')),
            array('video', 'file', 'types' => 'mov,m4v,mp4','maxSize'=>Yii::app()->params['video']['maxUploadFileSize'],'tooLarge'=>Yii::app()->params['custom_params']['invalid_file_size']),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'question_id' => 'Question',
            'video' => 'Video',
             
        );
    }

    
}
