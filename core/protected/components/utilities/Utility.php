<?php

class Utility {

    // takes record set and converts it to key value pairs for dropdowns
    public static function resultToKeyValue($result, $keyColumn, $valueColumn) {

        $array = array();

        foreach ($result as $r) {
            $array[$r->$keyColumn] = $r->$valueColumn;
        }

        return $array;
    }

    public static function concatFirstLastName($user) {
        return $user->first_name . ' ' . $user->last_name;
    }

    public static function makeLinksFromText($text) {
        return preg_replace('/(https?:\/\/([-\w\.]+)+(:\d+)?(\/([\w\/_\.-]*(\?\S+)?)?)?)/', '<a target="_blank" href="\\1">\\1</a>', $text);
    }

    public static function getDefaultStatus($labels) {
        $extendedLabels = $labels;
        $defaultStatus = key($extendedLabels[0]);

        foreach ($extendedLabels as &$value) {
            if (Yii::app()->user->hasPermission(key($value))) {
                $defaultStatus = key($value);
                break;
            }
        }

        return $defaultStatus;
    }

    public static function getAcceptedTVScope($labels, $tbName = "t") {
        switch (sizeof($labels)) {
            case 1:
                $acceptedtv = array('condition' => "1=2"); //This should work but can try 1=1: if there is one array labels, there should be no accepted tv scope.
                break;
            case 2:
                $acceptedtv = array('condition' => "`$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                                 AND (`$tbName`.statusbit & " . Yii::app()->params['statusBit']['deniedTv'] . ") = 0");
                break;
            case 3:
                $acceptedtv = array('condition' => "`$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                                 AND `$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin1'] . "
                                                 AND (`$tbName`.statusbit & " . Yii::app()->params['statusBit']['deniedTv'] . ") = 0");
                break;
            case 4:
                $acceptedtv = array('condition' => "`$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                                 AND `$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin1'] . "
                                                 AND `$tbName`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin2'] . "
                                                 AND (`$tbName`.statusbit & " . Yii::app()->params['statusBit']['deniedTv'] . ") = 0");
                break;
            default:
                $acceptedtv = array('condition' => "");
        }

        return $acceptedtv;
    }

    public static function getStatusTVScope($labels) {
        switch (sizeof($labels)) {
            case 1:
            case 2:
                $statustv = array('condition' => "");
                break;
            case 3:
                $statustv = array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                               AND (`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin1'] . ") = 0");
                break;
            case 4:
                $statustv = array('condition' => "`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedTv'] . "
                                               AND ((`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin1'] . ") = 0
                                               OR (`t`.statusbit & " . Yii::app()->params['statusBit']['acceptedSuperAdmin2'] . ") = 0)");
                break;
            default:
                $statustv = array('condition' => "");
        }

        return $statustv;
    }

    public static function setExtendedStatus($that) {
        $that->extendedStatus['new'] = false;
        $that->extendedStatus['accepted'] = false;
        $that->extendedStatus['denied'] = false;

        $that->extendedStatus['new_tv'] = false;
        $that->extendedStatus['accepted_tv'] = false;
        $that->extendedStatus['denied_tv'] = false;

        $that->extendedStatus['accepted_sup1'] = false;
        $that->extendedStatus['accepted_sup2'] = false;

        $bits = $that->statusbit;
        $that->extendedStatus['bit'] = $bits;

        //status web
        if (($bits & Yii::app()->params['statusBit']['new']) == Yii::app()->params['statusBit']['new']) {
            $that->extendedStatus['new'] = true;
        }
        if (($bits & Yii::app()->params['statusBit']['accepted']) == Yii::app()->params['statusBit']['accepted']) {
            $that->extendedStatus['accepted'] = true;
        }
        if (($bits & Yii::app()->params['statusBit']['denied']) == Yii::app()->params['statusBit']['denied']) {
            $that->extendedStatus['denied'] = true;
        }

        //status tv
        if (($bits & Yii::app()->params['statusBit']['newTv']) == Yii::app()->params['statusBit']['newTv']) {
            $that->extendedStatus['new_tv'] = true;
        }
        if (($bits & Yii::app()->params['statusBit']['acceptedTv']) == Yii::app()->params['statusBit']['acceptedTv']) {
            $that->extendedStatus['accepted_tv'] = true;
        }
        if (($bits & Yii::app()->params['statusBit']['deniedTv']) == Yii::app()->params['statusBit']['deniedTv']) {
            $that->extendedStatus['denied_tv'] = true;
        }

        //status super
        if (($bits & Yii::app()->params['statusBit']['acceptedSuperAdmin1']) == Yii::app()->params['statusBit']['acceptedSuperAdmin1']) {
            $that->extendedStatus['accepted_sup1'] = true;
        }
        if (($bits & Yii::app()->params['statusBit']['acceptedSuperAdmin2']) == Yii::app()->params['statusBit']['acceptedSuperAdmin2']) {
            $that->extendedStatus['accepted_sup2'] = true;
        }

        return $that->extendedStatus;
    }

    public static function updateExtendedStatus($currentStatus, $status, $obj) {
        switch ($currentStatus) {
            case "new":
                if ($status == "accepted") {
                    $obj->extendedStatus['new'] = false;
                    $obj->extendedStatus['accepted'] = true;
                } else {
                    $obj->extendedStatus['new'] = false;
                    $obj->extendedStatus['denied'] = true;
                }
                break;
            case "accepted":
                if ($status == "denied") {
                    $obj->extendedStatus['new'] = false;
                    $obj->extendedStatus['denied'] = true;
                }
                break;
            case "denied":
                if ($status == "accepted") {
                    $obj->extendedStatus['accepted'] = true;
                    $obj->extendedStatus['denied'] = false;
                }
                break;
            case "newtv":
                if ($status == "accepted") {
                    $obj->extendedStatus['new_tv'] = false;
                    $obj->extendedStatus['accepted_tv'] = true;
                } else {
                    $obj->extendedStatus['new_tv'] = false;
                    $obj->extendedStatus['denied_tv'] = true;
                }
                break;
            case "acceptedtv":
                if ($status == "denied") {
                    $obj->extendedStatus['new_tv'] = false;
                    $obj->extendedStatus['denied_tv'] = true;
                }
            case "deniedtv":
                if ($status == "accepted") {
                    $obj->extendedStatus['accepted_tv'] = true;
                    $obj->extendedStatus['denied_tv'] = false;
                }
                break;
            case "newsup1":
                if ($status == "accepted") {
                    $obj->extendedStatus['accepted_sup1'] = true;
                } else {
                    $obj->extendedStatus['denied_tv'] = true;
                }
                break;
            case "newsup2":
                if ($status == "accepted") {
                    $obj->extendedStatus['accepted_sup2'] = true;
                } else {
                    $obj->extendedStatus['denied_tv'] = true;
                }
                break;
            default:
                break;
        }

        return $obj->extendedStatus;
    }

    public static function setStatusbit($that) {
        if ($that->scenario != 'insert' || $that->extendedStatus['accepted']) {
            //web
            if (!empty($that->extendedStatus['new'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['new']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['new']);
            }

            if (!empty($that->extendedStatus['accepted'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['accepted']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['accepted']);
            }

            if (!empty($that->extendedStatus['denied'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['denied']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['denied']);
            }

            //status tv
            if (!empty($that->extendedStatus['new_tv'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['newTv']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['newTv']);
            }

            if (!empty($that->extendedStatus['accepted_tv'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['acceptedTv']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['acceptedTv']);
            }

            if (!empty($that->extendedStatus['denied_tv'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['deniedTv']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['deniedTv']);
            }

            //status super
            if (!empty($that->extendedStatus['accepted_sup1'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['acceptedSuperAdmin1']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['acceptedSuperAdmin1']);
            }

            if (!empty($that->extendedStatus['accepted_sup2'])) {
                $that->statusbit = (string) ($that->statusbit | Yii::app()->params['statusBit']['acceptedSuperAdmin2']);
            } else {
                $that->statusbit = (string) ($that->statusbit & ~ Yii::app()->params['statusBit']['acceptedSuperAdmin2']);
            }
        }

        return $that->statusbit;
    }

    public static function dump($string, $die = 0) {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
        if ($die)
            die();
    }

    public static function getHourArray($is_24hours = false) {
        $prepend = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09');
        return $is_24hours ? array_merge($prepend, range(10, 23)) : array_merge($prepend, range(10, 12));
    }

    public static function getMinuteArray() {
        $prepend = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09');
        return array_merge($prepend, range(10, 59));
    }

    public static function getDayArray() {
        return array(
            'Sunday' => 'Sunday',
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday'
        );
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    public static function isMobile() {
        $RE_MOBILE = '/(nokia|iphone|iPad|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220)/i';
        //if (!isset(Yii::app()->session['mobile'])) {
            Yii::app()->session['mobile'] = isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) || preg_match($RE_MOBILE, $_SERVER['HTTP_USER_AGENT']);
        //}
        return Yii::app()->session['mobile'];
    }

}
