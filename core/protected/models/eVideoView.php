<?php
class eVideoView extends VideoView
{
    public $viewCount;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    public function filterByWeek($filterDate) {
        return DateTimeUtility::filterByWeek($this, $filterDate);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('video_id, user_id', 'required'),
                array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
                array('video_id, user_id', 'numerical', 'integerOnly'=>true),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('id, video_id, user_id, created_on, updated_on', 'safe', 'on'=>'search'),
        );
    }
    
    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'groupByVideo' => array(
                'select' => 't.video_id, COUNT(t.id) AS viewCount',
                'group' => 't.video_id',
            ),
        );
    }
}