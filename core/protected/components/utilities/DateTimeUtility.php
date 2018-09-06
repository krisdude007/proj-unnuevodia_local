<?php

class DateTimeUtility {

    public static function secsToTimecode($secs) {
        //TODO: make this account for frames as well.
        return sprintf('%02d:%02d:%02d', ($secs / 3600), ($secs / 60 % 60), $secs % 60);
    }

    public static function niceTime($timestamp) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $tense = ($now > $timestamp) ? 'ago' : 'from now';
        $difference = abs($now - $timestamp);
        for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
            $difference /= $lengths[$i];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$i].= "s";
        }
        return "$difference $periods[$i] {$tense}";
    }

    public static function getStartDate($startDate = null) {
        $start_date = (!empty(Yii::app()->params['analytics']['startDate'])) ? Yii::app()->params['analytics']['startDate'] : '2010-01-01';
        if(isset($startDate)) {
            if ($startDate == 'total') {
                $startDate = $start_date;
            }
            $startDate = max($start_date, $startDate);
        } else {
            $startDate = max($start_date, date("Y-m-d", strtotime("-7 days")));
        }

        return $startDate;
    }

    public static function filterByDates($obj, $startDate, $endDate) {
        $obj->getDbCriteria()->mergeWith(array(
            'condition' => $obj->getTableAlias() . '.created_on>=:startDate and ' . $obj->getTableAlias() . '.created_on <= :endDate',
            'params' => array(':startDate' => $startDate!==null?gmdate('Y-m-d 00:00:00', strtotime($startDate)):null, ':endDate' => $endDate!==null?gmdate('Y-m-d 23:59:59', strtotime($endDate)):null,),
        ));
        return $obj;
    }

    public static function filterByWeek($obj, $filterDate) {
        $endDate = date('Y-m-d', strtotime($filterDate . ' + 6 days'));
        $obj->getDbCriteria()->mergeWith(array(
            'condition' => 'created_on between :filterDate and :endDate',
            'params' => array(':filterDate' => $filterDate!==null?gmdate('Y-m-d 00:00:00', strtotime($filterDate)):null, ':endDate' => $endDate!==null?gmdate('Y-m-d 23:59:59', strtotime($endDate)):null),
        ));
        return $obj;
    }

    public static function convertTimestampToDate($timestamp) {
        return date('m/d/Y', strtotime($timestamp));
    }

    public static function convertTimestampToTime($timestamp) {
        return date('h:i a', strtotime($timestamp));
    }

    public static function daysOfMonth() {
        $days = array(''=> Yii::t('youtoo','Day'));
        for ($i = 1; $i <= 31; $i++) {
            $days[sprintf('%02d', $i)] = $i;
        }
        return $days;
    }

    public static function monthsOfYear() {
        $months = array('' => Yii::t('youtoo','Month'));
        for ($i = 1; $i <= 12; $i++) {
            $months[sprintf('%02d', $i)] = Yii::t('youtoo',date('F', mktime(0, 0, 0, $i, 1, date('Y', time()))));
        }
        return $months;
    }

    public static function yearsOfCentury() {
        $years = array('' => Yii::t('youtoo','Year'));
        for ($i = date('Y'); $i >= date('Y') - 100; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }
    
    public static function yearsThisAndNextTwenty() {
        $years = array();
        for ($i = date('Y'); $i <= date('Y') + 20; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    public static function getStartAndEndDateWeek($week, $year)
    {
        $time = strtotime("1 January $year", time());
        $day = date('w', $time);
        $time += ((7*$week)+1-$day)*24*3600;
        $return[0] = date('Y-m-d', $time);
        $time += 6*24*3600;
        $return[1] = date('Y-m-d', $time);

        return $return;
    }

    public static function getIsoWeeksInYear($year) {
        $date = new DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    public static function daysOfMonthAR() {
        $days = array(''=>'اليوم');
        for ($i = 1; $i <= 31; $i++) {
            $days[sprintf('%02d', $i)] = $i;
        }
        return $days;
    }

    public static function monthsOfYearAR() {
        $months = array(
       ''   => 'الشهر',
       '01' => 'يناير',
       '02' => 'فبراير',
       '03' => 'مارس',
       '04' => 'أبريل',
       '05' => 'مايو',
       '06' => 'يونيو',
       '07' => 'يوليو',
       '08' => 'أغسطس',
       '09' => 'سبتمبر',
       '10' => 'أكتوبر',
       '11' => 'نوفمبر',
       '12' => 'ديسمبر',
        );

        return $months;
    }

    public static function DayOfWeekAR() {
        $val = array(
       'Sunday'   => 'الأحد',
       'Monday' => 'الإثنين',
       'Tuesday' => 'الثلاثاء',
       'Wednesday' => 'الأربعاء',
       'Thursday' => 'الخميس',
       'Friday' => 'الجمعة',
       'Saturday' => 'السبت',
        );

        return $val;
    }

    public static function DayOfWeek() {
        $val = array(
       'Sunday'   => 'Sunday',
       'Monday' => 'Monday',
       'Tuesday' => 'Tuesday',
       'Wednesday' => 'Wednesday',
       'Thursday' => 'Thursday',
       'Friday' => 'Friday',
       'Saturday' => 'Saturday',
        );

        return $val;
    }

    public static function yearsOfCenturyAR() {
        $years = array('' => 'السنة');
        for ($i = date('Y'); $i >= date('Y') - 100; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }


}

?>
