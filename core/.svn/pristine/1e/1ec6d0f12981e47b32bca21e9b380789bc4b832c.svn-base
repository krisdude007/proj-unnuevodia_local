<?php

/**
 * This is the model class for table "network_show".
 *
 * The followings are the available columns in table 'network_show':
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 * @property string $description
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property NetworkShowSchedule[] $networkShowSchedules
 */
class eNetworkShow extends NetworkShow
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NetworkShow the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function scopes() {
        // todo - fix this so that it looks for specific roles
        // instead of anything that is not user
        return array(
            'ascending' => array('order' => '`t`.`name` ASC'),
        );
    }
}