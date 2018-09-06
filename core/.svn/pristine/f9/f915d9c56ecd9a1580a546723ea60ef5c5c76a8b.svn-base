<?php

class VideoImportUtility {

    public $categoryIdentifier; // hashtag etc.
    public $numVideos; // number of videos to return
    public $source; // vine, youtube etc.
    private $sourceUtilityInstance;

    public function __construct($source, $categoryIdentifier, $numVideos) {

        $this->source = $source;
        $this->categoryIdentifier = $categoryIdentifier;
        $this->numVideos = $numVideos;
        return $this->loadSourceInstance();
    }

    private function loadSourceInstance() {

        $sourceUtilityClassName = $this->source . 'Utility';

        if (class_exists($sourceUtilityClassName)) {
            $this->sourceUtilityInstance = new $sourceUtilityClassName();
            return true;
        } else {
            Yii::app()->user->setFlash('error', "Unable to locate Utility for " . $this->source);
            return false;
        }
    }

    public function importVideos() {

        if ($this->sourceUtilityInstance->connected === true) {

            switch ($this->source) {
                case 'Vine':
                    return $this->importVine();
                    break;
                case 'Keek':
                    return $this->importKeek();
                    break;
                case 'Instagram':
                    return $this->importInstagram();
                    break;
            }
        } else {
            Yii::app()->user->setFlash('error', "Unable to authenticate to " . $this->source);
            return false;
        }
    }

    public function importKeek() {

        // must abstract
        $this->categoryIdentifier = str_replace('#', '', $this->categoryIdentifier);
        $html = $this->sourceUtilityInstance->getTimeline($this->categoryIdentifier, $this->numVideos);

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $tags = $xpath->query('//div[@class="to-keek"]/div[@class="video-b"]/a/@href');
        $videos = array();
        foreach ($tags as $tag) {
            $videoUrl = trim($tag->nodeValue);
            $videoInfo = explode('/',$videoUrl);
            $videoId = $videoInfo[3];
            //$videoPage = $this->sourceUtilityInstance->getVideo($videoId);
            $videoUrl = str_replace('{VIDEO_ID}', $videoId, Yii::app()->params['keek']['url2']);
            $videos[] = array('videoUrl' => $videoUrl,
                             'videoId' => $videoId);
        }

        $numVideos = count($videos);
        $videosImported = 0;

        for ($i = 0; $i < $numVideos; $i++) {

            $videoUrl = $videos[$i]['videoUrl'];
            $filenameDb = $videos[$i]['videoId'];
            $filename = $filenameDb . Yii::app()->params['video']['postExt'];

            $filenamePng = $filenameDb . '.png';
            $fileLocationFlv = Yii::app()->params['paths']['video'] . '/' . $filenameDb . Yii::app()->params['keek']['ext'];
            $fileLocationMp4 = Yii::app()->params['paths']['video'] . '/' . $filename;
            $fileLocationTmpMp4 = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '_bak' . Yii::app()->params['video']['postExt'];
            $fileLocationPng = Yii::app()->params['paths']['video'] . '/' . $filenamePng;
            $fileLocationGif = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '.gif';

            // see if video already exists
            $videoExists = eVideo::model()->findByAttributes(array('filename' => $filenameDb));
            if ($videoExists) {
                continue;
            }

            // pull the video from vine
            $videoFileContents = file_get_contents($videoUrl);
            if (!file_put_contents($fileLocationFlv, $videoFileContents)) {
                continue;
            }

            // convert from mp4 to flv
            //VideoUtility::ffmpegFlvToMp4($fileInput, $fileOutput, $duration);
            $duration = "00:00:" . Yii::app()->params['video']['duration'] . ".00";
            $watermark = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->params['video']['watermark'];
            VideoUtility::ffmpegFlvToMp4($fileLocationFlv, $fileLocationMp4, $duration);

            // rescale video
            VideoUtility::ffmpegRescaleVideo($fileLocationMp4, $fileLocationTmpMp4);

            // generate thumb
            VideoUtility::ffmpegGenerateThumbFromVideo($fileLocationMp4, $fileLocationPng);

            // generate gif
            VideoUtility::ffmpegFlvToGif($fileLocationFlv, $fileLocationGif);

            // get info from video
            $videoData = VideoUtility::ffprobeVideo($fileLocationMp4);

            // remove temp videos
            unlink($fileLocationTmpMp4);
            unlink($fileLocationFlv);

            // get frame rate
            $frame_rate_str = $videoData->streams[0]->r_frame_rate;
            $frameRate = round(eval("return ($frame_rate_str);"), 2);

            $question = eQuestion::model()->video()->findByAttributes(Array('hashtag' => $this->categoryIdentifier));
            // insert new video record
            $video = new eVideo();
            $video->user_id = Yii::app()->user->getId();
            $video->question_id = $question->id;
            $video->filename = $video->source_content_id = $video->thumbnail = $filenameDb;
            $video->processed = 1;
            $video->watermarked = 0;
            $video->title = "{$this->source} Video";
            $video->description = "Video created via {$this->source} on " . date("Y-m-d h:i:s") . ".";
            $video->duration = round($videoData->format->duration, 2);
            $video->frame_rate = $frameRate;
            $video->source_user_id = $video->source = strtolower($this->source);
            $video->to_youtube = 0;
            $video->to_facebook = 0;
            $video->to_twitter = 0;
            $video->arbitrator_id = Yii::app()->user->getId();
            $video->status = 'new';

            if ($video->save()) {
                ++$videosImported;
            }

            if($videosImported == $this->numVideos) {
                break;
            }
        }

        Yii::app()->user->setFlash('success', "Successfully imported {$videosImported} video from {$this->source}.");
    }

    public function importVine() {

        // all vine specific
        // must abstract
        $categoryIdentifier = str_replace('#', '', $this->categoryIdentifier);
        $userInfo = $this->sourceUtilityInstance->getUserInfo();
        $timeLine = $this->sourceUtilityInstance->getTimeline($userInfo["key"], $userInfo["userId"], $categoryIdentifier, $this->numVideos);
        $timelineArray = json_decode($timeLine, true);
        //Utility::dump($timelineArray,1);
        $numVideos = count($timelineArray['data']['records']);

        $videosImported = 0;
        for ($i = 0; $i < $numVideos; $i++) {

            $urlArray = array();
            $urlArray['urlForSharing'] = $timelineArray['data']['records'][$i]['shareUrl'];
            $urlArray['urlToVideo'] = $timelineArray['data']['records'][$i]['videoUrl'];
            $tmp_array = explode('v/', $urlArray['urlForSharing']); // grab the original filename from the url
            $filenameDb = $tmp_array[1];
            $filename = $filenameDb . Yii::app()->params['vine']['ext'];
            $filenamePng = $filenameDb . '.png';
            $fileLocationMp4 = Yii::app()->params['paths']['video'] . '/' . $filename;
            $fileLocationTmpMp4 = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '_bak' . Yii::app()->params['vine']['ext'];
            $fileLocationPng = Yii::app()->params['paths']['video'] . '/' . $filenamePng;
            $fileLocationGif = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '.gif';

            // see if video already exists
            $videoExists = eVideo::model()->findByAttributes(array('filename' => $filenameDb));
            if ($videoExists) {
                continue;
            }

            // pull the video from vine
            $videoFileContents = file_get_contents($urlArray['urlToVideo']);
            if (!file_put_contents($fileLocationMp4, $videoFileContents)) {
                continue;
            }

            // rescale vine video to match our convention
            VideoUtility::ffmpegRescaleVideo($fileLocationMp4, $fileLocationTmpMp4);

            // generate thumb
            VideoUtility::ffmpegGenerateThumbFromVideo($fileLocationMp4, $fileLocationPng);

            // generate gif
            VideoUtility::ffmpegFlvToGif($fileLocationMp4, $fileLocationGif);

            // get info from video
            $videoData = VideoUtility::ffprobeVideo($fileLocationMp4);

            // get frame rate
            $frame_rate_str = $videoData->streams[0]->r_frame_rate;
            $frameRate = round(eval("return ($frame_rate_str);"), 2);

            $question = eQuestion::model()->video()->findByAttributes(Array('hashtag' => $this->categoryIdentifier));

            // remove temp video
            @unlink($fileLocationTmpMp4);

            // insert new video record
            $video = new eVideo();
            $video->user_id = Yii::app()->user->getId();
            $video->question_id = $question->id;
            $video->filename = $video->source_content_id = $video->thumbnail = $filenameDb;
            $video->processed = 1;
            $video->watermarked = 0;
            $video->title = "{$this->source} Video: ".$this->categoryIdentifier;
            $video->description = "Video created via {$this->source} on {$timelineArray['data']['records'][$i]['created']}.";
            $video->duration = round($videoData->format->duration, 2);
            $video->frame_rate = $frameRate;
            $video->source_user_id =  $timelineArray['data']['records'][$i]['username'];
            $video->source = strtolower($this->source);
            $video->to_youtube = 0;
            $video->to_facebook = 0;
            $video->to_twitter = 0;
            $video->arbitrator_id = Yii::app()->user->getId();
            $video->status = 'new';

            if ($video->save()) {
                ++$videosImported;
            }

            if($videosImported == $this->numVideos) {
                break;
            }
        }

        Yii::app()->user->setFlash('success', "Successfully imported {$videosImported} video from {$this->source}.");
    }


    public function importInstagram()
    {
        $count_video = 0;
        $categoryIdentifier = str_replace('#', '', $this->categoryIdentifier);
        $url = 'https://api.instagram.com/v1/tags/'.urlencode($categoryIdentifier).'/media/recent?client_id='.Yii::app()->params['custom_params']['instagram_client_id'];

        if($response = json_decode(file_get_contents($url))) {
            //$next_url = $response->pagination->next_url;
            if($data = $response->data) {
                foreach($data as $record) {
                    if($record->type=='video') {
                        $video_url = $record->videos->standard_resolution->url;
                        $username = $record->user->username;
                        if($this->saveVideo($video_url, $username)) {
                            if(++$count_video >= $this->numVideos ) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        
        Yii::app()->user->setFlash('success', "Successfully imported {$count_video} video from {$this->source}.");
    }


    // Fetch video from remote site and save to our own server
    public function saveVideo($videoUrl, $username)
    {
        $url = parse_url($videoUrl);
        $filenameDb = $this->source.'_'.str_replace(array('/','.mp4'), '',$url['path']);

        $filename = $filenameDb . Yii::app()->params['video']['postExt'];

        $filenamePng = $filenameDb . '.png';
        $fileLocationFlv    = Yii::app()->params['paths']['video'] . '/' . $filenameDb . Yii::app()->params['keek']['ext'];
        $fileLocationMp4    = Yii::app()->params['paths']['video'] . '/' . $filename;
        $fileLocationTmpMp4 = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '_bak' . Yii::app()->params['video']['postExt'];
        $fileLocationPng    = Yii::app()->params['paths']['video'] . '/' . $filenamePng;
        $fileLocationGif    = Yii::app()->params['paths']['video'] . '/' . $filenameDb . '.gif';

        // see if video already exists
        if(!$videoExists = eVideo::model()->findByAttributes(array('filename' => $filenameDb))) {

            $videoFileContents = file_get_contents($videoUrl);
            if (file_put_contents($fileLocationMp4, $videoFileContents)) {

                // convert from mp4 to flv
                //VideoUtility::ffmpegFlvToMp4($fileInput, $fileOutput, $duration);
                $duration = "00:00:" . Yii::app()->params['video']['duration'] . ".00";
                $watermark = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->params['video']['watermark'];
                //VideoUtility::ffmpegFlvToMp4($fileLocationFlv, $fileLocationMp4, $duration);

                // rescale video
                //VideoUtility::ffmpegRescaleVideo($fileLocationMp4, $fileLocationTmpMp4);

                // generate thumb
                VideoUtility::ffmpegGenerateThumbFromVideo($fileLocationMp4, $fileLocationPng);

                // generate gif
                VideoUtility::ffmpegMp4ToGif($fileLocationMp4, $fileLocationGif);

                // get info from video
                $videoData = VideoUtility::ffprobeVideo($fileLocationMp4);

                // remove temp videos
                @unlink($fileLocationTmpMp4);
                //unlink($fileLocationFlv);

                // get frame rate
                $frame_rate_str = $videoData->streams[0]->r_frame_rate;
                $frameRate = round(eval("return ($frame_rate_str);"), 2);

                $question = eQuestion::model()->video()->findByAttributes(Array('hashtag' => $this->categoryIdentifier));
                
                // insert new video record
                $video = new eVideo();
                $video->user_id = Yii::app()->user->getId();
                $video->question_id = $question->id;
                $video->filename = $video->source_content_id = $video->thumbnail = $filenameDb;
                $video->processed = 1;
                $video->watermarked = 0;
                $video->title = "{$this->source} Video";
                $video->description = "Video created via {$this->source} on " . date("Y-m-d h:i:s") . ".";
                $video->duration = round($videoData->format->duration, 2);
                $video->frame_rate = $frameRate;
                $video->source_user_id = $username;
                $video->source = strtolower($this->source);
                $video->to_youtube = 0;
                $video->to_facebook = 0;
                $video->to_twitter = 0;
                $video->arbitrator_id = Yii::app()->user->getId();
                $video->status = 'new';

                return $video->save();
            }

        }
        return false;

    }

}

