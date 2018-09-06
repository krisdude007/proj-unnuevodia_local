<?php

/**
 * This is the model class for table "game_choice_smsoutbound".
 *
 * The followings are the available columns in table 'game_choice_smsoutbound':
 * @property integer $id
 * @property string $smsid
 * @property string $opid
 * @property string $destination
 * @property string $smssender
 * @property string $smstext
 * @property string $smsdecodetext
 * @property string $idlang
 * @property string $return_value
 * @property string $created_on
 *
 *
 * The followings are the available model relations:
 * @property User $user
 */
class GameChoiceSmsOutbound extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'game_choice_smsoutbound';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('smsid, opid, destination, smssender, smstext, idlang, return_value, created_on', 'required'),
            array('smssender, destination, opid', 'numerical'),
            array('opid, destination', 'length', 'max' => 11),
            array('smssender', 'length', 'max' => 20),
            array('idlang', 'in', 'range' => array('0', '1'), 'allowEmpty' => false),
            array('smstext, smsdecodetext', 'length', 'max' => 512),
            array('return_value', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, smsid, opid, destination, smssender, smstext, smsdecodetext, idlang, return_value, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'smsid' => 'SMS ID',
            'opid' => 'OP_ID',
            'destination' => 'Short Code',
            'smssender' => 'Mobile Number',
            'smstext' => 'SMS Text',
            'smsdecodetext' => 'SMS Decoded Text',
            'idlang' => 'Language ID',
            'return_value' => 'Return Value',
            'created_on' => 'Created On',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('smsid', $this->smsid);
        $criteria->compare('opid', $this->opid);
        $criteria->compare('destination', $this->destination, true);
        $criteria->compare('smssender', $this->smssender, true);
        $criteria->compare('smstext', $this->smstext, true);
        $criteria->compare('smsdecodetext', $this->smsdecodetext, true);
        $criteria->compare('idlang', $this->idlang, true);
        $criteria->compare('return_value', $this->return_value, true);
        $criteria->compare('created_on', $this->created_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->created_on)) : null);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Transaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
