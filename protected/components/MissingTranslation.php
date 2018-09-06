<?php

class MissingTranslation extends CApplicationComponent {

    public static function handler($event) {
        $category = $event->category;
        $message = $event->message;
        $params = $event->params;
        //uncomment to see missingTranslation
        //echo "fail to translate:" . $message;
    }

}

?>
