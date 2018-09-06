<?php

class eTwitterMention extends TwitterMention {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'lastRecord' => array(
                'order' => 'tweet_id DESC',
                'limit' => 1,
            ),
        );
    }

}
