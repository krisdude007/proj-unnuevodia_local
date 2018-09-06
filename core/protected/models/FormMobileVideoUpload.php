<?php

class FormMobileVideoUpload extends CFormModel {

    public $question_id;
    public $video;
    public $title;
    public $description;
    
    public function rules() {

        return array(
            array('question_id, video, title, description', 'required'),
            array('question_id', 'numerical', 'integerOnly' => true),
            array('video', 'file', 'types' => Yii::app()->params['video']['acceptedFileTypes'],'maxSize'=>Yii::app()->params['video']['maxUploadFileSize'],'tooLarge'=>'The File is Too large to be uploaded.','wrongType'=>'Invalid file type. Only '.Yii::app()->params['video']['acceptedFileTypes'].' files can be uploaded'),
            array('question_id', 'exist','allowEmpty' => false,'attributeName' => 'id','className' => 'Question','message' => 'The specified question id does not exist.','skipOnError'=>true),
            array('question_id, title, video, description', 'safe', 'on'=>'search')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'question_id' => 'Question',
            'video' => 'Video',
            'title' => 'Title',
            'description' =>'Descrption'
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;
        $criteria->compare('question_id',$this->question_id);
        $criteria->compare('video',$this->video,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}
