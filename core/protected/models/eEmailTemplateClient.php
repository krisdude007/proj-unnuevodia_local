<?php

/**
 * This is the model class for table "email_template_client".
 *
 * The followings are the available columns in table 'email_template_client':
 * @property integer $id
 * @property string $name
 * @property string $subject
 * @property string $content
 * @property integer $active
 * @property string $created_on
 * @property string $updated_on
 */
class eEmailTemplateClient extends EmailTemplateClient {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
