<?php

/**
 * This is the model class for table "banner".
 *
 * The followings are the available columns in table 'banner':
 * @property string $name
 * @property string $filename
 * @property string $url
 * @property integer $no_click
 * @property string $created_on
 * @property string $updated_on
 */
class eBanner extends Banner {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('no_click', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 25),
            array('filename', 'length', 'max' => 256),
            array('url', 'length', 'max' => 1024),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, filename, url, no_click, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('no_click', $this->no_click);
        $criteria->compare('created_on', $this->created_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->created_on)) : null);
        $criteria->compare('updated_on', $this->updated_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->updated_on)) : null);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
