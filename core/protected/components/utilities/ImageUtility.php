<?php

class ImageUtility {
    // gets values for image status dropdown
    public static function getStatuses() {
        $filterLabels = Yii::app()->params['image']['extendedFilterLabels'];
        $statuses = array();
        foreach($filterLabels as &$value)
        {
            if(Yii::app()->user->isSuperAdmin() || Yii::app()->user->isSiteAdmin() || Yii::app()->user->hasPermission(key($value)))
            {
                $statuses = CMap::mergeArray($statuses, $value);
            }
        }

        if(Yii::app()->user->isSuperAdmin())
        {
            $statuses = CMap::mergeArray($statuses, Yii::app()->params['image']['superAdminExtendedFilterLabels']);
        }

        return $statuses;
    }

    public static function getPerPageOptions() {
        return array('12' => '12',
            '24' => '24',
            '36' => '36',
            '48' => '48'
        );
    }

    public static function getTypes() {
        return array('all' => 'All',
            'avatar' => 'Avatars',
            'image' => 'Images',
        );
    }

    public static function ffmpegImageToVideo($fileInput, $fileOutput) {
        if(file_exists($fileInput)) {
            $params = Yii::app()->params['ffmpeg']['imageToVideoParams'];
            $params = str_replace('{FILE_INPUT}', $fileInput, $params);
            $params = str_replace('{FILE_OUTPUT}', $fileOutput, $params);
            $cmd = Yii::app()->params['paths']['ffmpeg'] . $params;
            exec($cmd);
        }

        if(file_exists($fileOutput))
        {
            return true;
        }

        return false;
    }

    public static function ffmpegFinalizeImageVideoForTv($fileInput, $fileOutput) {
        if(file_exists($fileInput)) {
            $params = Yii::app()->params['ffmpeg']['imageToVideoToTvParams'];
            $params = str_replace('{FILE_INPUT}', $fileInput, $params);
            $params = str_replace('{FILE_OUTPUT}', $fileOutput, $params);
            $cmd = Yii::app()->params['paths']['ffmpeg'] . $params;
            exec($cmd);
        }

        if(file_exists($fileOutput))
        {
            return true;
        }

        return false;
    }

    public static function ffmpegImageVideoAddAudio($fileInput, $fileInputAudio, $fileOutput) {
        if(file_exists($fileInput)) {
            $params = Yii::app()->params['ffmpeg']['imageToVideoWithAudioParams'];
            $params = str_replace('{FILE_INPUT}', $fileInput, $params);
            $params = str_replace('{FILE_INPUT_AUDIO}', $fileInputAudio, $params);
            $params = str_replace('{FILE_OUTPUT}', $fileOutput, $params);
            $cmd = Yii::app()->params['paths']['ffmpeg'] . $params;
            exec($cmd);
        }

        if(file_exists($fileOutput))
        {
            return true;
        }

        return false;
    }

    public static function ffmpegImageScale($fileInput, $fileOutput) {
        if(file_exists($fileInput)) {
            $params = Yii::app()->params['ffmpeg']['imageScaleParams'];
            $params = str_replace('{FILE_INPUT}', $fileInput, $params);
            $params = str_replace('{FILE_OUTPUT}', $fileOutput, $params);
            $cmd = Yii::app()->params['paths']['ffmpeg'] . $params;
            exec($cmd);
        }

        if(file_exists($fileOutput))
        {
            return true;
        }

        return false;
    }

    public static function orientateImage($imagePath) {
            // rotate image
            if(exif_imagetype($imagePath) == IMAGETYPE_JPEG){

                $image = imagecreatefromstring(file_get_contents($imagePath));
                $exif = exif_read_data($imagePath);

                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $image = imagerotate($image,90,0);
                            break;
                        case 3:
                            $image = imagerotate($image,180,0);
                            break;
                        case 6:
                            $image = imagerotate($image,-90,0);
                            break;
                    }

                    imagejpeg($image, $imagePath);
                    imagedestroy($image);
                }
            }
    }


    public static function rotateImage($imagePath, $newImagePath, $direction='left') {
        // rotate image
        // get image type

        $image = imagecreatefromstring(file_get_contents($imagePath));
        switch($direction) {
            case 'left':
                $image = imagerotate($image,90,0);
                break;
            case 'right':
                $image = imagerotate($image,-90,0);
                break;
        }

        switch(exif_imagetype($imagePath)) {
            case IMAGETYPE_GIF:
                imagegif($image, $newImagePath);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image, $newImagePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $newImagePath);
                break;

        }

        imagedestroy($image);
        unlink($imagePath);
    }

    public static function getThumbName($filename, $size) {
        $path_parts = pathinfo($filename);
        $outputfile = "";
        if($size == "xs"){
            if($path_parts['dirname'] == ".")
                $outputfile = $path_parts['filename']."_xs.".$path_parts['extension'];
            else
                $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_xs.".$path_parts['extension'];
        }
        else if($size == "sm"){
            if($path_parts['dirname'] == ".")
                $outputfile = $path_parts['filename']."_sm.".$path_parts['extension'];
            else
                $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_sm.".$path_parts['extension'];
        }
        else if($size == "lg"){
            if($path_parts['dirname'] == ".")
                $outputfile = $path_parts['filename']."_lg.".$path_parts['extension'];
            else
                $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_lg.".$path_parts['extension'];
        }
        return $outputfile;
    }

    public static function generateThumbs($filename) {
        $path_parts = pathinfo($filename);
        if(!empty(Yii::app()->params['image']['thumb-xs'])){
            $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_xs.".$path_parts['extension'];
            ImageUtility::generateThumb($filename, $outputfile, Yii::app()->params['image']['thumb-xs']);
        }
        if(!empty(Yii::app()->params['image']['thumb-sm'])){
            $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_sm.".$path_parts['extension'];
            ImageUtility::generateThumb($filename, $outputfile, Yii::app()->params['image']['thumb-sm']);
        }
        if(!empty(Yii::app()->params['image']['thumb-lg'])){
            $outputfile = $path_parts['dirname']."/".$path_parts['filename']."_lg.".$path_parts['extension'];
            ImageUtility::generateThumb($filename, $outputfile, Yii::app()->params['image']['thumb-lg']);
        }
    }
    public static function generateThumb($inputfile, $outputfile, $width) {
        if (!file_exists($inputfile))
            return false;
        if(empty($outputfile) || !is_int($width) )
            return false;
        list($width_src, $height_src, $type_src) = getimagesize($inputfile);
        if(empty($width_src) || empty($height_src) || empty($type_src))
            return false;
        if($width_src <= $width){
            copy($inputfile,$outputfile);
            return true;
        }
        $height = round($height_src*$width/$width_src);
        $destination = imagecreatetruecolor($width, $height);
        $source = false;
        switch ($type_src) {
            case IMAGETYPE_GIF://animated gif does not work now.
                $source = imagecreatefromgif($inputfile);
                $trnprt_indx = imagecolortransparent($source);
                if ($trnprt_indx >= 0) {
                    $trnprt_color = imagecolorsforindex($source, $trnprt_indx);
                    $trnprt_indx = imagecolorallocate($destination, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                    imagefill($destination, 0, 0, $trnprt_indx);
                    imagecolortransparent($destination, $trnprt_indx);
                }
                break;
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($inputfile);
                break;
            case IMAGETYPE_PNG:
                imagealphablending($destination, false);
                imagesavealpha($destination, true);
                $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
                imagefilledrectangle($destination, 0, 0, $width, $height, $transparent);
                $source = imagecreatefrompng($inputfile);
                break;
        }
        if ($source === false)
            return false;
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $width_src, $height_src);
        switch ($type_src) {
            case IMAGETYPE_GIF:
                imagegif($destination, $outputfile);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $outputfile);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $outputfile);
                break;
        }
        ImageDestroy($source);
        ImageDestroy($destination);
        return true;
    }
}

?>
