<?php

/**
 * VCI API Controller
 *
 * Responsible as main interface for importing schedule data.
 *
 * @author <greg.stringer@gmail.com>
 */
class VciController extends Controller {

    /**
     * Initialize. Here we set a custom error handler so that we do not 
     * output default html.
     */
    public function init() {
        parent::init();
        //Yii::app()->errorHandler->errorAction = 'vci/error';
    }

    public function filters() {
        return array();
    }

    public function actionImportVci() {

        $uploaded = 0;
        $mailMsg = 'No file was processed.';
        if (isset($_FILES) && count($_FILES) > 0) {
            if ($_FILES["file"]["error"] > 0) {
                $mailMsg = 'FAIL: ' . $_FILES["file"]["error"];
            } else {
                $targetPath = Yii::app()->params['paths']['vci'] . '/' . $_FILES["file"]["name"];
                $moved = move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath);
                if ($moved) {
                    $uploaded = 1;
                    $mailMsg = 'SUCCESS: File stored ' . Yii::app()->params['paths']['vci'] . '/' . $_FILES["file"]["name"];
                }
            }
        }
        
        mail('greg.stringer@gmail.com, mark@youtoo.com', 'VCI Import', $mailMsg);
        
        if ($uploaded == 1) {
            $handle = fopen($targetPath, "r");
            $row = 1;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                //if ($row > 1) {
                    $spot_type = substr($data[0], 0, 2);
                    if ($spot_type == 'FS' || $spot_type == 'PM') {
                        $spot_number = substr($data[0], 2, 8);
                        $spot_time = $data[1];
                        $date = explode("-", $data[2]);
                        $date = $date[1] . "/" . $date[2] . "/" . $date[0];
                        $date2 = $data[2];
                        $spot_length = $data[3];
                        $blocktime = trim($data[4]);
                        $blocktime = rtrim($blocktime);
                        if ($blocktime == "") { $blocktime = $spot_time; }
                        $showname = addslashes($data[5]);
                        $spot_order = ltrim($data[6], 0);
                        $submitted_on = '0000-00-00 00:00:00';
                        $airs_on = '00:00:00';
                        $spot_available = 1;
                        $showInfo = self::getShowFromBlock($blocktime, $date);
                        $showname = $showInfo['showname'];
                        $abbreviation = $showInfo['abbreviation'];
                        $description = $showInfo['description'];
                        
                        if ($showInfo === false) {
                            // get network show id for paid programming
                            $ns = NetworkShow::model()->findByAttributes(array('abbreviation' => 'PP'));
                            $network_show_id = $ns->id;
                        } else {
                            $ns = NetworkShow::model()->findByAttributes(array('name' => $showname));
                            if(is_null($ns)) {
                                // insert new show
                                $ns = new NetworkShow();
                                $ns->name = $showname;
                                $ns->abbreviation = $abbreviation;
                                $ns->description = ($description == '') ? 'n/a':$description;
                                $ns->created_on = new CDbExpression('NOW()');
                                $ns->save();
                            } 
                            $network_show_id = $ns->id;
                        }
                        
                        // get spot length formatted
                        $sql = "SELECT SEC_TO_TIME(TIME_TO_SEC(REPLACE('".$spot_length."', ':', ''))) AS spot_length";
                        $result = Yii::app()->db->createCommand($sql)->queryAll();
                        $spot_length = $result[0]['spot_length'];
                        
                        // get show_on
                        $sql = "SELECT STR_TO_DATE(CONCAT('$date2', ' ', '$blocktime', 'm'), '%Y-%m-%d %h:%i:%s %p') AS show_on";
                        $result = Yii::app()->db->createCommand($sql)->queryAll();
                        $show_on = $result[0]['show_on'];
                        
                        // get spot_on
                        $sql = "SELECT STR_TO_DATE(CONCAT('$date2', ' ', '$spot_time', 'm'), '%Y-%m-%d %h:%i:%s %p') AS spot_on";
                        $result = Yii::app()->db->createCommand($sql)->queryAll();
                        $spot_on = $result[0]['spot_on'];
                        $nss = eNetworkShowSchedule::model()->find('spot_type=:spot_type AND spot_number=:spot_number AND DATE(spot_on)=:date',
                                                    array(
                                                      ':spot_type'=>$spot_type,
                                                      ':spot_number'=>$spot_number,
                                                      ':date'=>$date2
                                                    ));
                        
                        if(is_null($nss)) {
                            
                            // insert
                            $nss = new eNetworkShowSchedule();
                            $nss->network_show_id = $network_show_id;
                            $nss->spot_type = $spot_type;
                            $nss->spot_number = $spot_number;
                            $nss->spot_on = $spot_on;
                            $nss->show_on = $show_on;
                            $nss->spot_order = $spot_order;
                            $nss->spot_length = $spot_length;
                            $nss->spot_available = 1;
                            $nss->created_on = new CDbExpression('NOW()');
                            $nss->save();
                            //echo "saved <br>";
                        } else {
                            // update
                            $nss->network_show_id = $network_show_id;
                            $nss->spot_type = $spot_type;
                            $nss->spot_number = $spot_number;
                            $nss->spot_on = $spot_on;
                            $nss->show_on = $show_on;
                            $nss->spot_order = $spot_order;
                            $nss->spot_length = $spot_length;
                            $nss->spot_available = 1;
                            $nss->updated_on = new CDbExpression('NOW()');
                            $nss->save();
                            //echo "updated <br>";
                        }
                        
                    }
                
                $row++;
            }
            fclose($handle);
            unlink($targetPath);
            //videoadmin::updateVCIWithShowID();
            //videoadmin::updateVCIWithBatchNumber();
            //videoadmin::updateAirTime();
        }
    }

    public function actionImportSims() {
        $uploaded = 0;
        $mailMsg = 'No file was processed.';
        if (isset($_FILES) && count($_FILES) > 0) {
            if ($_FILES["schedule"]["error"] > 0) {
                $mailMsg = 'FAIL: ' . $_FILES["schedule"]["error"];
            } else {
                $targetPath = "vciuploads/" . $_FILES["schedule"]["name"];
                $moved = move_uploaded_file($_FILES["schedule"]["tmp_name"], $targetPath);
                if ($moved) {
                    $uploaded = 1;
                    $mailMsg = 'SUCCESS: File stored ' . "vciuploads/" . $_FILES["schedule"]["name"];
                }
            }
        }
        
        mail('greg.stringer@gmail.com', 'SIMS Import', $mailMsg);

        if ($uploaded == 1) {
            $lastDate="";
            // remove current data
            NetworkSimsSchedule::model()->deleteAll();
            //Yii::app()->db->createCommand()->truncateTable(NetworkSimsSchedule::model()->tableName());
            

            $timezone = "America/New_York";
            date_default_timezone_set($timezone);
            putenv('TZ=America/New_York');
            ini_set('date.timezone', $timezone);

            $fileName = $targetPath;
            $row = 0;
            $fp = fopen($fileName, "r");
            $insertData = array();

            while ($data = fgetcsv($fp, 10000, "\t")) {
                $num = count($data) - 1;
                if ($num >= 5) {
                    $date = chunk_split($data[1], 2, '/');
                    $start_time = chunk_split($data[2], 2, ':') . "00";
                    $end_time = chunk_split($data[3], 2, ':') . "00";
                    list ($month, $day, $year) = explode('/', $date);
                    list ($start_hour, $start_minute, $start_second) = explode(':', $start_time);
                    list ($end_hour, $end_minute, $end_second) = explode(':', $end_time);
                    $showname = $data[5];
                    $episodename = $data[8];
                    $episodeid = $data[10];
                    //$this->epTable($showname, $episodeid, $episodename);
                    $thisTime = mktime($start_hour, $start_minute, $start_second, $month, $day, $year);
                    $startDateTime = mktime($start_hour, $start_minute, $start_second, $month, $day, $year);
                    $endDateTime = mktime($end_hour, $end_minute, $end_second, $month, $day, $year);

                    if ($endDateTime < $startDateTime) {
                        $endDateTime = mktime($end_hour, $end_minute, $end_second, $month, $day + 1, $year);
                    } else {
                        $endDateTime = mktime($end_hour, $end_minute, $end_second, $month, $day, $year);
                    }
                    $startDate = date("H:i:s	m/d/y    ", $startDateTime);
                    $endDate = date("H:i:s	m/d/y ", $endDateTime);
                    
                    if ($row == 0) {
                        $firstDate = $startDateTime;
                    }

                    if ($startDateTime) {
                        if ($firstDate > $startDateTime) {
                            $firstDate = $startDateTime;
                        }
                    }

                    if ($endDate) {
                        if ($lastDate < $endDateTime) {
                            $lastDate = $endDateTime;
                        }
                    }
                    
                    $insertData[$row][] = '';
                    $insertData[$row][] = $startDateTime;
                    $insertData[$row][] = $endDateTime;
                    for ($c = 4; $c < $num; $c++) {
                        if ($c == 8) {
                            $temp = $data[$c];
                            $temp2 = explode('\\', $temp);
                            $final = $temp2[0];
                            $insertData[$row][] = addslashes($final);
                        } else {
                            $insertData[$row][] = addslashes($data[$c]);
                        }
                    }
                    $row++;
                }
            }

            fclose($fp);
            unlink($fileName);
            
            for ($c = 0; $c < $row; $c++) {
                $nss = new NetworkSimsSchedule;
                $ii=0;
                foreach($nss->getAttributes() as $key=>$val) {
                    $nss->{$key} = $insertData[$c][$ii];
                    ++$ii;
                }
                $nss->save();
            }
        }

        
        //fix missing id's
        //echo "\r\n";
        //echo "Fixing missing IDs";
        //$this->fixID();
        //relink missing shows
        //echo "\r\n";
        //echo "Fixing missing programs";
        //$this->fixPrograms();
    }
 
    
    private static function getShowFromBlock($block, $date) {
        $timezone = "America/New_York";
        date_default_timezone_set($timezone);
        putenv('TZ=America/New_York');
        ini_set('date.timezone', $timezone);
        $block = str_replace("p", "pm", $block);
        $block = str_replace("a", "am", $block);
        $start = strtotime("$block $date");
        $parts = explode(" ", $block);
        $ampm = $parts[1];
        $starthour = substr($block, 0, 2);
        $parts2 = explode(":", $block);
        $min = $parts2[2];

        if ($ampm == "am") {
            $dayseconds = 86340;
            if ($starthour == "12") {
                $starthour = 0;
            }

            if ($starthour >= 0 && $starthour < 7) {
                $newblocktime = $blocktime;
                $time = strtotime("$newblocktime $date");
                $min = str_replace(" am", "", $min);
                if ($starthour == 0 && $min > 30) {
                    $start = ($start - $dayseconds);
                } else {
                    $start = ($start - $dayseconds);
                }
            }
        }

        $result = NetworkSimsSchedule::model()->find('block3<=:start AND block4>:start', array(
            ':start' => $start,
        ));

        $x = 0;
        if (!is_null($result)) {
            return array('showname' =>  $result['block6'],
                         'abbreviation' => str_replace($result['block10'], '', $result['block11']),
                         'description' => $result['block33']);
        }
        return false;
    }

}
