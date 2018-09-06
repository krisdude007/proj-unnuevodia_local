<?php
class clientUserEmail extends eUserEmail
{
    public $confirm_email;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function rules()
    {
        return array(
            array('email, confirm_email','required','on' => 'register'),
            array('email','email'),
            array('email','unique','on'=>'register,profile,twitter'),
            array('user_id, active', 'numerical', 'integerOnly'=>true),
            array('email, type', 'length', 'max'=>255),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
            array('active','default','value'=>1,'on'=>'insert'),
            array('type','default','value'=>'primary','on'=>'insert'),
            array('confirm_email', 'compare', 'compareAttribute'=>'email', 'on'=>'register'),
            array('id, user_id, email, type, active, created_on, updated_on', 'safe', 'on'=>'search'),
        );
    }
}