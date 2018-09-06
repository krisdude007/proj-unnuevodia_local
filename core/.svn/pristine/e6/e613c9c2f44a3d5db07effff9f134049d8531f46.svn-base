<?php

/**
 * This is the model class for table "game_reveal_grid".
 *
 * The followings are the available columns in table 'game_reveal_grid':
 * @property integer $id
 * @property integer $user_id
 * @property integer $reveal_id
 * @property string $grid_section
 * @property integer $is_shown
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property GameReveal $reveal
 * @property User $user
 */
class eGameRevealGrid extends GameRevealGrid {
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, reveal_id, grid_section, is_shown', 'numerical', 'integerOnly' => true),
            array('is_shown', 'default', 'value' => 0),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('user_id, reveal_id, grid_section, is_shown, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'game_reveal' => array(self::BELONGS_TO, 'GameReveal', 'reveal_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'reveal_id' => 'Game Reveal',
            'grid_section' => 'Grid Section',
            'is_shown' => 'Is Shown',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    
    
    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TickerSearchStats the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

