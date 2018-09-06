<?php

class eVideo extends Video {

    public $extendedStatus;
    public $video_count;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    public function filterByWeek($filterDate) {
        return DateTimeUtility::filterByWeek($this, $filterDate);
    }
    
    public static function getExternalSourceUsername($video, $username) {
        $sourceArr = array('keek','instagram','vine');
        if($video->source_user_id != '' && in_array($video->source, $sourceArr)) {
            return $video->source_user_id;
        }
        return $username;
    }

    public function getVideosOrderBy($order, $limit = 48) {
        $total = eVideo::model()->with('user')->accepted()->count();
        $criteria = new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->select = '*, COUNT(videoViews.id) AS views, (SELECT AVG(rating) FROM video_rating WHERE video_id= t.id) as rating';
        $criteria->with = array('user', 'videoViews');
        $criteria->together = true;
        $criteria->condition = Yii::app()->params['video']['useExtendedFilters'] ? ("t.statusbit & " . Yii::app()->params['statusBit']['accepted'] . " AND (t.statusbit & " . Yii::app()->params['statusBit']['denied'] . ") = 0") : 'status="accepted"';
        $criteria->group = 't.id';
        $criteria->order = $order . ' DESC';

        if (Yii::app()->params['pagination']['enablePagination'] == true) {
            $pages = new CPagination($total);
            $pages->setPageSize(Yii::app()->params['pagination']['listPerPage']);
            $pages->applyLimit($criteria);
        }
        return self::model()->findAll($criteria);
    }

    public function getContestantVideosOrderBy($order, $limit = 48) {
        $total = eVideo::model()->with('user.isContestant')->accepted()->count();
        $criteria = new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->select = '*, COUNT(videoViews.id) AS views, (SELECT AVG(rating) FROM video_rating WHERE video_id= t.id) as rating';
        $criteria->with = array('user.isContestant', 'videoViews');
        $criteria->together = true;
        $criteria->condition = Yii::app()->params['video']['useExtendedFilters'] ? ("t.statusbit & " . Yii::app()->params['statusBit']['accepted'] . " AND (t.statusbit & " . Yii::app()->params['statusBit']['denied'] . ") = 0") : 'status="accepted"';
        $criteria->group = 't.id';
        $criteria->order = $order . ' DESC';

        if (Yii::app()->params['pagination']['enablePagination'] == true) {
            $pages = new CPagination($total);
            $pages->setPageSize(Yii::app()->params['pagination']['listPerPage']);
            $pages->applyLimit($criteria);
        }
        return self::model()->findAll($criteria);
    }

    public function orderBy($id, $order, $limit = 48) {
        if (Yii::app()->params['video']['useExtendedFilters']) {
            $sqlWhere = "v.statusbit & " . Yii::app()->params['statusBit']['accepted'] . "
                        AND (v.statusbit & " . Yii::app()->params['statusBit']['denied'] . ") = 0";
        } else {
            $sqlWhere = 'status = "accepted"';
        }

        if (is_null($id)) {
            $sql = '
                select view_key,v.user_id,thumbnail,title,v.created_on,username,first_name,last_name,COUNT(vv.id) AS views, (select Avg(rating) from video_rating where video_id= v.id) as rating
                    from video v
                    LEFT JOIN user u ON u.id = v.user_id
                    LEFT JOIN video_view vv on vv.video_id = v.id
                    where ' . $sqlWhere . '
                    group by v.id
            ';
        } else {
            $sql = '
                select view_key,v.user_id,thumbnail,title,v.created_on,username,first_name,last_name,COUNT(vv.id) AS views,  (select Avg(rating) from video_rating where video_id= v.id) as rating
                    from video v
                    LEFT JOIN user u ON u.id = v.user_id
                    LEFT JOIN video_view vv on vv.video_id = v.id
                    where ' . $sqlWhere . '
                    and v.user_id = "%d"
                    group by v.id
            ';
            $sql = sprintf($sql, $id);
        }
        switch ($order) {
            case 'views':
                $sql .= 'order by views desc LIMIT ' . $limit;
                $videos = Yii::app()->db->createCommand($sql)->queryAll(true);
                $videos = json_decode(json_encode($videos));
                break;
            case 'rating':
                $sql .= 'order by rating desc LIMIT ' . $limit;
                $videos = Yii::app()->db->createCommand($sql)->queryAll(true);
                $videos = json_decode(json_encode($videos));
                break;
            default:
                $sql .= 'LIMIT ' . $limit;
                break;
        }
        return $videos;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $extendedRules = array(
            //bit value 128 for "new" and 16 for "new_tv"
            array('statusbit', 'default', 'value' => 144, 'on' => 'insert'),
            array('extendedStatus', 'safe')
        );

        $defaultRules = array(
            array('title, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('source', 'required', 'message' => Yii::t('youtoo', 'Video cannot be blank')),
            array('title', 'required', 'on' => 'update', 'message' => Yii::t('youtoo', 'Title cannot be blank')),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('status', 'default', 'value' => 'new', 'on' => 'insert'),
            array('filename', 'required', 'on' => 'insert', 'message' => Yii::t('youtoo', 'Video cannot be blank')),
            array('thumbnail', 'required', 'on' => 'insert'),
            array('filename, thumbnail', 'unique'),
            array('view_key', 'default', 'value' => md5(uniqid('', true)), 'on' => 'insert'),
            array('user_id, watermarked, is_preroll, to_youtube, to_facebook, to_twitter, arbitrator_id, is_default_ad, roll_type', 'numerical', 'integerOnly' => true),
            array('filename, thumbnail, title, description, view_key, source, source_content_id, source_user_id, company_name, company_email', 'length', 'max' => 255),
            array('status', 'length', 'max' => 8),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            //array('id, user_id, question_id, title, description, view_key, source, watermarked, to_youtube, to_facebook, to_twitter, arbitrator_id, status, status_date, created_on, updated_on', 'safe', 'on' => 'search'),
            array('id, user_id, question_id, prize_id, hero_user_id, filename, thumbnail, processed, watermarked, is_preroll, title, description, duration, frame_rate, view_key, source, source_content_id, source_user_id, to_youtube, to_facebook, to_twitter, arbitrator_id, status, statusbit, is_default_ad, roll_type, company_name, company_email, status_date, created_on, updated_on', 'safe', 'on' => 'search'),
        );

        if (Yii::app()->params['video']['useExtendedFilters']) {
            return CMap::mergeArray($defaultRules, $extendedRules);
        } else {
            return $defaultRules;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'prize' => array(self::BELONGS_TO, 'Prize', 'prize_id'),
            'brightcoves' => array(self::HAS_MANY, 'eBrightcove', 'video_id'),
            'arbitrator' => array(self::BELONGS_TO, 'User', 'arbitrator_id'),
            'user' => array(self::BELONGS_TO, 'eUser', 'user_id'),
            'userPhone' => array(self::BELONGS_TO, 'eUserPhone', 'user_id'),
            'userLocation' => array(self::BELONGS_TO, 'eUserLocation', 'user_id'),
            'userTwitter' => array(self::BELONGS_TO, 'eUserTwitter', 'user_id'),
            'question' => array(self::BELONGS_TO, 'eQuestion', 'question_id'),
            'heroUser' => array(self::BELONGS_TO, 'eUser', 'hero_user_id'),
            'videoDestinations' => array(self::HAS_MANY, 'eVideoDestination', 'video_id'),
            'videoRatings' => array(self::HAS_MANY, 'eVideoRating', 'video_id'),
            'videoViews' => array(self::HAS_MANY, 'eVideoView', 'video_id'),
            'rating' => array(self::STAT, 'eVideoRating', 'video_id', 'select' => 'ROUND(AVG(rating))', 'group' => 'video_id'),
            'views' => array(self::STAT, 'eVideoView', 'video_id', 'select' => 'COUNT(id)', 'group' => 'video_id'),
            'tagVideos' => array(self::HAS_MANY, 'eTagVideo', 'video_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $defaultLabels = CMap::mergeArray(parent::attributeLabels(), array(
                    'to_youtube' => 'Youtube',
                    'to_facebook' => 'Facebook',
                    'to_twitter' => 'Twitter',
        ));

        $extendedLabels = array(
            'statusbit' => 'Statusbit',
            'extendedStatus' => 'ExtendedStatus',
            'title' => 'Video Title',
        );

        if (Yii::app()->params['video']['useExtendedFilters']) {
            return CMap::mergeArray($defaultLabels, $extendedLabels);
        } else {
            return $defaultLabels;
        }
    }

    public function scopes() {
        $defaultScopes1 = array(
            'recent' => array('order' => '`t`.`id` desc'),
            'byViews' => array('order' => 'views desc'),
            'rating' => array('order' => '`t`.rating desc'),
            'withViews' => array('order' => 'views desc'),
            'withRating' => array('order' => 'rating desc'),
            'processed' => array('condition' => '`t`.processed=1'),
            'all' => array('condition' => '`t`.processed=1'),
            'hasUser' => array('condition' => '`t`.user_id>0'),
            'nonAdvertisement' => array('condition' => '`t`.source != "ad"'),
        );

        $defaultScopes2 = array(
            'new' => array('condition' => '`t`.status="new"'),
            'accepted' => array('condition' => '`t`.status="accepted"'),
            'denied' => array('condition' => '`t`.status="denied"'),
        );

        if (Yii::app()->params['video']['useExtendedFilters']) {
            $extendedScopes = array(
                'new' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['new']),
                'accepted' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['accepted'] . "
                                                   AND (`t`.statusbit & " . Yii::app()->params['statusBit']['denied'] . ") = 0"),
                'denied' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['denied']),
                'newtv' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['newTv']),
                'acceptedtv' => Utility::getAcceptedTVScope(Yii::app()->params['video']['extendedFilterLabels']),
                'deniedtv' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['deniedTv']),
                'newsup1' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                                   AND (`t`.statusbit & " . Yii::app()->params['statusBit']['deniedTv'] . ") = 0
                                                   AND (`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin1'] . ") = 0"), //(accepted tv) and (not deniedtv) and (not accepted sup1)
                'newsup2' => array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                                   AND (`t`.statusbit & " . Yii::app()->params['statusBit']['deniedTv'] . ") = 0
                                                   AND (`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin2'] . ") = 0"), //(accepted tv) and (not deniedtv) and (not accepted sup2)
                'statustv' => Utility::getStatusTVScope(Yii::app()->params['video']['extendedFilterLabels']),
            );

            return CMap::mergeArray($defaultScopes1, $extendedScopes);
        } else {
            return CMap::mergeArray($defaultScopes1, $defaultScopes2);
        }
    }

    public function getCountBySource() {
        $return = array();
        $criteria = new CDbCriteria;
        $criteria->select = 'source, count(id) as video_count';
        $criteria->group = 'source';
        if ($data = self::model()->findAll($criteria)) {
            foreach ($data as $row) {
                $return[$row->source] = $row->video_count;
            }
            return $return;
        }
        return false;
    }

    public function afterSave() {
        if ($this->status == 'accepted' || Yii::app()->params['video']['useExtendedFilters'] && $this->extendedStatus['accepted']) {
            if ($this->to_twitter == 1) {
                $destination = eDestination::model()->findByAttributes(Array('destination' => 'twitter'));
                $sent = eVideoDestination::model()->findByAttributes(Array('video_id' => $this->id, 'user_id' => $this->user_id, 'destination_id' => $destination->id));
                if (is_null($sent)) {
                    $text = Yii::app()->facebook->fbPost;
                    $text .= Yii::app()->createAbsoluteUrl('/play/' . $this->view_key);
                    $dest = new eVideoDestination;
                    $dest->video_id = $this->id;
                    $dest->user_id = $this->user_id;
                    $dest->destination_id = $destination->id;
                    $response = TwitterUtility::tweetAs($this->user_id, $text);
                    if (sizeof($response->errors) > 0) {
                        foreach ($response->errors as $i => $error) {
                            $dest->response .= $error->message;
                        }
                    } else {
                        $dest->response = $response->id_str;
                    }
                    $dest->save();
                }
            }
            if ($this->to_facebook == 1) {
                $destination = eDestination::model()->findByAttributes(Array('destination' => 'facebook'));
                $sent = eVideoDestination::model()->findByAttributes(Array('video_id' => $this->id, 'user_id' => $this->user_id, 'destination_id' => $destination->id));
                if (is_null($sent)) {
                    $post = array(
                        'message' => Yii::app()->facebook->fbPost . ' ',
                        'link' => Yii::app()->createAbsoluteUrl('/play/' . $this->view_key),
                        'picture' => isset($_SERVER['HTTPS']) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . '/uservideos/' . $this->filename . '.png',
                    );
                    $dest = new eVideoDestination;
                    $dest->video_id = $this->id;
                    $dest->user_id = $this->user_id;
                    $dest->destination_id = $destination->id;
                    $response = FacebookUtility::shareAs($this->user_id, $post);
                    if (!$response['result']) {
                        $dest->response = $response['error'];
                    } else {
                        $dest->response = $response['response']['id'];
                    }
                    $dest->save();
                }
            }
        }
        return parent::afterSave();
    }

    public function beforeSave() {
        if (Yii::app()->params['video']['useExtendedFilters']) {
            $this->statusbit = Utility::setStatusbit($this);
            $this->extendedStatus = Utility::setExtendedStatus($this);
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        if (Yii::app()->params['video']['useExtendedFilters']) {
            $this->extendedStatus = Utility::setExtendedStatus($this);
        }
        return parent::afterFind();
    }

    public static function generateViewKey() {
        return md5(uniqid('', true) . time());
    }

    public static function insertRecord($keyValuePairs = array()) {

        if (count($keyValuePairs) > 0) {

            $video = new self();

            foreach ($keyValuePairs as $key => $value) {
                $video->{$key} = $value;
            }

            if ($video->save()) {
                return $video;
            }
        }

        return false;
    }

    public function getRecentVideos() {
        return self::model()->findAll(array('limit' => 50, 'order' => 'updated_on desc', 'condition' => 'status="accepted"'));
    }

}
