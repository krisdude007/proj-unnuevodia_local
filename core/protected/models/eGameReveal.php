<?php

/**
 * This is the model class for table "game_reveal".
 *
 * The followings are the available columns in table 'game_reveal':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $grid_w
 * @property string $grid_h
 * @property string $grid_w_squares
 * @property string $grid_h_squares
 * @property string $grid_background
 * @property string $square_color
 * @property integer $control_scale
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property GameRevealGrid[] $gameRevealGrs
 */
class eGameReveal extends GameReveal {

    public $image_main_w;
    public $image_main_h;
    public $image_section_w;
    public $image_section_h;
    public $button_main_w;
    public $button_main_h;
    public $button_section_w;
    public $button_section_h;
    public $total_squares;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'default', 'value' => Yii::app()->user->getId()),
            array('user_id, title, grid_w, grid_h, grid_w_squares, grid_h_squares, square_color, control_scale', 'required'),
            array('grid_background', 'safe'),
            array('user_id, grid_w, grid_h, grid_w_squares, grid_h_squares, is_active, is_deleted', 'numerical', 'integerOnly' => true),
            array('title, grid_background', 'length', 'max' => 255),
            array('square_color', 'length', 'min' => 3, 'max' => 15),
            array('is_active, is_deleted', 'default', 'value' => 0),
            array('image_main_w, image_main_h, image_section_w, image_section_h, button_main_w, button_main_h, button_section_w, button_section_h', 'safe'),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('user_id, title, grid_w, grid_h, grid_w_squares, grid_h_squares, grid_background, square_color, control_scale, is_active, is_deleted, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'grid_w' => 'Grid Width',
            'grid_h' => 'Grid Height',
            'grid_w_squares' => 'Grid Width Squares',
            'grid_h_squares' => 'Grid Height Squares',
            'grid_background' => 'Grid Background',
            'square_color' => 'Square Color',
            'control_scale' => 'Control Scale',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'image_main_w' => 'Image Main Width',
            'image_main_h' => 'Image Main Height',
            'image_section_w' => 'Image Section Width',
            'image_section_h' => 'Image Section Height',
            'button_main_w' => 'Button Main Width',
            'button_main_h' => 'Button Main Height',
            'button_section_w' => 'Button Section Width',
            'button_section_h' => 'Button Section Height',
        );
    }

    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'deleted' => array(
                'condition' => "is_deleted = '1'"
            ),
            'notdeleted' => array(
                'condition' => "is_deleted = '0'"
            ),
            'orderByCreatedDesc' => array(
                'order' => '`t`.created_on DESC',
            ),
            'orderByCreatedAsc' => array(
                'order' => '`t`.created_on ASC',
            ),
            'orderByIDDesc' => array(
                'order' => '`t`.id DESC',
            ),
        );
    }


    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    public function afterFind() {
        $public_scale = 2;
                
        $this->image_main_w = $this->grid_w/$public_scale;//+$this->grid_w_squares*2;
        $this->image_main_h = $this->grid_h/$public_scale;//+$this->grid_h_squares*2;

        $this->image_section_w = $this->grid_w/$this->grid_w_squares/$public_scale;
        $this->image_section_h = $this->grid_h/$this->grid_h_squares/$public_scale;

        $this->button_main_w = $this->grid_w/$this->control_scale+$this->grid_w_squares*2;
        $this->button_main_h = $this->grid_h/$this->control_scale+$this->grid_h_squares*2;

        $this->button_section_w = $this->grid_w/$this->grid_w_squares/$this->control_scale;
        $this->button_section_h = $this->grid_h/$this->grid_h_squares/$this->control_scale;

        $this->total_squares = $this->grid_w_squares * $this->grid_h_squares;

        return parent::afterFind();
    }
    
    public function afterSave() {
        
        $gridNum = eGameRevealGrid::model()->countByAttributes(Array('reveal_id' => $this->id));
        
        if(empty($gridNum)) {
            $gridNum = 1;
        }
        
        if($gridNum == $this->grid_w_squares * $this->grid_h_squares) {
            $gridNum = ($this->grid_w_squares * $this->grid_h_squares) + 1;
        }
        
        for($i = $gridNum; $i <= $this->grid_w_squares * $this->grid_h_squares; $i++) {
            $grid = new eGameRevealGrid();
            $grid->user_id = Yii::app()->user->getId();
            $grid->reveal_id = $this->id;
            $grid->grid_section = $i;
            $grid->save();
        }
        
        return parent::afterSave();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

