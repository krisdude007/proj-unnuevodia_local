<?php

class ImageImportUtility {

    public $categoryIdentifier; // hashtag etc.
    public $numImages; // number of videos to return
    public $source; // vine, youtube etc.
    private $sourceUtilityInstance;

    public function __construct($source, $categoryIdentifier, $numImages) {

        $this->source = $source;
        $this->categoryIdentifier = $categoryIdentifier;
        $this->numImages = $numImages;
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

    public function importImages() {

        if ($this->sourceUtilityInstance->connected === true) {

            switch ($this->source) {
                case 'Instagram':
                    return $this->importInstagram();
                    break;
            }
        } else {
            Yii::app()->user->setFlash('error', "Unable to authenticate to " . $this->source);
            return false;
        }
    }

    public function importInstagram() {
        $count_image = 0;
        $categoryIdentifier = str_replace('#', '', $this->categoryIdentifier);
        $url = 'https://api.instagram.com/v1/tags/' . urlencode($categoryIdentifier) . '/media/recent?client_id=' . Yii::app()->params['custom_params']['instagram_client_id'];

        if ($response = json_decode(file_get_contents($url))) {
            //$next_url = $response->pagination->next_url;
            if ($data = $response->data) {
                foreach ($data as $record) {
                    if ($record->type == 'image') {
                        $imageUrl = $record->images->standard_resolution->url;
                        $username = $record->user->username;
                        if ($this->saveImage($imageUrl, $username)) {
                            if (++$count_image >= $this->numImages) {
                                break;
                            }
                        }
                    }
                }
            }
        }

        Yii::app()->user->setFlash('success', "Successfully imported {$count_image} images from {$this->source}.");
    }

    // Fetch video from remote site and save to our own server
    public function saveImage($imageUrl, $username) {

        $user = Yii::app()->user->getId();
        $filename = basename($imageUrl);
        $fileLocationImage = Yii::app()->params['paths']['avatar'] . '/' . $filename;
        $imageFileContents = file_get_contents($imageUrl);
        
        if (file_put_contents($fileLocationImage, $imageFileContents)) {
            $record = array();
            $record['filename'] = $filename;
            $record['arbitrator_id'] = Yii::app()->user->getId();
            $record['user_id'] = Yii::app()->user->getId();
            $record['source'] = $this->source;
            $record['title'] = $username;
            $record['description'] = 'Instagram Image';
            $record['is_avatar'] = 0;
            $record['view_key'] = eImage::generateViewKey();
            $record['status'] = 'new';
            $inserted = eImage::insertRecord($record);

            if (Yii::app()->params['image']['autoApprove']) {
                $inserted->status = 'accepted';
                if (Yii::app()->params['image']['useExtendedFilters']) {
                    $inserted->extendedStatus['accepted'] = true;
                    $inserted->extendedStatus['new_tv'] = true;
                }
            } else {
                $inserted->status = 'new';
            }

            if ($inserted) {
                $inserted->to_facebook = 0;
                $inserted->to_twitter = 0;
                $inserted->save();
                return true;
            } else {
                return false;
            }
        }


        /*
          $url = parse_url($imageUrl);
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

          $imageFileContents = file_get_contents($imageUrl);
          if (file_put_contents($fileLocationMp4, $imageFileContents)) {

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
         * 
         */
        return false;
    }

}
