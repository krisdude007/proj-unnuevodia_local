<?php

class FormMobileConnectFacebook extends CFormModel {

    public $access_token;

    public function rules() {

        return array(
            array('access_token', 'required'),
            array('access_token', 'safe', 'on'=>'search')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'access_token' => 'Access Token',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('access_token',$this->access_token);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}
