<?php

class AuditUtility {

    public static function save($controller, $request, $override = Array(), $user_id = false) {
        //TODO find out why error is hit before every admin page.
        if ($controller->action->id != 'error') {
            $audit = new eAudit;
            $audit->user_id = ($user_id != false) ? $user_id : Yii::app()->user->getId();
            $audit->action = $controller->id . '/' . $controller->action->id;
            if ($request) {
                if (isset($request['eUser']['password']) && $request['eUser']['password']) {
                    unset($request['eUser']['password']);
                }
                $audit->action .= '/?' . http_build_query($request);
            }
            if (!empty($override)) {
                $audit->action .= '/?' . http_build_query($override);
            }
            $audit->save();
        }
    }

    public static function translate($action) {
        //This appears cumbersome.
        //It's really not.
        //I promise the elegance will be revealed when you have to write a translation.
        //(Could probably be optimized though)
        //
        //Follow these and you'll be ok:
        //Single replace: {key}
        //Boolean option: {key|true|false}
        //Database options:
        //  {pk:model:column}
        //  {attribute;model;column}
        //
        $translationTable = Array(
            'adminQuestion/index' => 'Viewed the admin question page.',
            'adminUser/index' => 'Viewed the admin user page.',
            'adminReport/ajaxGetGraphData' => 'Viewed the admin dashboard.',
            'adminReport/ajaxGetLineGraphData' => 'Viewed the admin dashboard.',
            'adminTicker/index' => 'Viewed the admin ticker.',
            'adminAudit/audit' => 'Viewed the admin audit table.',
            'video/capture' => 'Recorded a video from {source} for the question "{qID:eQuestion:question}".',
            'video/process' => 'Processed a video with the title "{id:eVideo:title}".',
            'video/index' => 'Viewed the video page in {order} order.',
            'video/rate' => 'Gave the video "{video:eVideo:title}" {rating} star(s).',
            'video/play' => 'Watched the video "{view_key;eVideo;title}".',
            'image/index' => 'Viewed the image page in {order} order.',
            'user/view' => 'Viewed {id:eUser:username}\'s page in {order} order.',
            'user/index' => 'Viewed their user page in {order} order.',
            'user/facebook' => 'Logged in via facebook.',
            'user/login' => 'Logged in via web.',
            'user/acceptTerms' => '{choice|Accepted|Denied} the terms of service.',
            'admin/login' => 'Logged into the admin portal.',
            'admin/ajaxVideoUpdateStatus' => 'Changed the status of a video.',
            'adminSocialStream/ajaxReadStream' => 'Loaded data into the Social Stream.',
            'adminSocialStream/ajaxStartStream' => 'Started the social stream.',
            'ticker/stream' => 'Viewed a ticker from the {destination}.',
        	'ticker/ajaxStream' => 'Viewed a ticker from the {destination}.',
            'admin/saveSetting' => 'Changed the value of the "{id;eAppSetting;description}" setting to {value|on|off}.',
            'adminQuestion/save' => 'Altered the question {id:eQuestion:question}.',
            'adminVideo/index' => 'Viewed the admin video page with {perPage} videos per page.',
            'adminImage/index' => 'Viewed the admin image page with {perPage} images per page.',
            //TODO: Get with Lee about this one.
            'adminReport/ajaxDashboardGraph' => 'Viewed the dashboard graph for {metric}s starting on {date}.',
            'adminImage/ajaxImageUpdateStatus' => '{status} image ID: {imageId} on {currentStatus}',
            'image/rate' => 'Gave the image "{object_id:eImage:title}" {rating} star(s).',
            'adminVideo/ajaxVideoUpdateStatus' => '{status} video ID: {videoId} on {currentStatus}',
        );
        if (preg_match('/(.*?\/.*?)\/\?(.*?)$/', $action, $matches)) {
            // This block is if the action had variables passed to it; we need to parse them via translation array above.
            $action = $matches[1];
            $action = (isset($translationTable[$action]) &&  $translationTable[$action]) ? $translationTable[$action] : $action;
            parse_str($matches[2], $request);
            foreach ($request as $k => $v) {
                if (preg_match('/\{' . $k . '.*?\}/', $action)) {
                    if (preg_match('/\{' . $k . ':(.*?):(.*?)\}/', $action, $dataTranslation)) {
                        if ($dataTranslation[1]) {
                            $model = new $dataTranslation[1]();
                            $action = preg_replace('/\{' . $k . '.*?\}/', $model->findByPK($v)->$dataTranslation[2], $action);
                        } else {
                            $action = preg_replace('/\{' . $k . '.*?\}/', $v, $action);
                        }
                    }
                    if (preg_match('/\{' . $k . ';(.*?);(.*?)\}/', $action, $dataTranslation)) {
                        if ($dataTranslation[1]) {
                            $model = new $dataTranslation[1]();
                            $action = preg_replace('/\{' . $k . '.*?\}/', $model->findByAttributes(Array($k => $v))->$dataTranslation[2], $action);
                        } else {
                            $action = preg_replace('/\{' . $k . '.*?\}/', $v, $action);
                        }
                    }
                    if (preg_match('/\{' . $k . '\|(.*?)\|(.*?)\}/', $action, $dataTranslation)) {
                        $action = ($v) ? preg_replace('/\{' . $k . '.*?\}/', $dataTranslation[1], $action) : preg_replace('/\{' . $k . '.*?\}/', $dataTranslation[2], $action);
                    }
                }
                if (preg_match('/\{' . $k . '\}/', $action)) {
                    $action = preg_replace('/\{' . $k . '.*?\}/', $v, $action);
                }
            }
            //This line is debug code to show the actual request in the table.
            //$action .= "<br>".print_r($request,true);
        } else if (preg_match('/(.*?)\/(.*?)$/', $action, $matches)) {
            //This block is if there was no variables passed to the action; just a basic view, easy parse.
            $controller = strtolower($matches[1]);
            $action = ($matches[2] == 'index') ? '' : $matches[2];
            $controller = preg_replace('/admin/', 'admin ', $controller);
            $action = "Viewed the $controller $action page";
        } else {
            //This is to catch anything that MIGHT slip through the cracks.  Just show the action, unparsed.
            $action = $action;
        }
        return $action;
    }

}

?>
