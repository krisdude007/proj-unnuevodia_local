<?php

class FormMobileImageUpload extends CFormModel {

    public $image;
    public $title;
    public $description;
    public $is_avatar;
    
    public function rules() {

        return array(
            array('image, title, description, is_avatar', 'required'),
            array('image', 'file', 'types' => Yii::app()->params['image_upload_filetype'],'maxSize'=>Yii::app()->params['image']['maxUploadFileSize'],'tooLarge'=>'The File is Too large to be uploaded.','wrongType'=>'Invalid file type. Only '.Yii::app()->params['image']['acceptedFileTypes'].' files can be uploaded'),
            array('is_avatar', 'in', 'range'=>array(0,1)),
            array('title, image, description, is_avatar', 'safe', 'on'=>'search')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'image' => 'Image',
            'title' => 'Title',
            'description' =>'Descrption'
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;
        $criteria->compare('image',$this->image,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}
