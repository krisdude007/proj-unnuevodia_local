<?php
class ePollResponse extends PollResponse
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('poll_id, answer_id, source', 'required'),
            array('poll_id, answer_id, user_id', 'numerical', 'integerOnly'=>true),
            array('source, source_content_id, source_user_id', 'length', 'max'=>255),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, poll_id, answer_id, user_id, source, source_content_id, source_user_id, created_on, updated_on', 'safe', 'on'=>'search'),
        );
    }
    
    public function relations()
    {
        return array(
            'poll' => array(self::BELONGS_TO, 'ePoll', 'poll_id'),
            'user' => array(self::BELONGS_TO, 'eUser', 'user_id'),
            'answer' => array(self::BELONGS_TO, 'ePollAnswer', 'answer_id'),
        );
    }
        
    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }
        
    public function filterByWeek($filterDate) {
        return DateTimeUtility::filterByWeek($this, $filterDate);
    }
        
    public function filterById($id) {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'poll_id =:pollId',
            'params'=>array(':pollId'=>$id,),
        ));
        return $this;
    }
}