<?php
class UpdateAnalyticsCommand extends CConsoleCommand{
    public function run(){//nightly cron
        $analytics = eAnalytics::model()->findByPk(Yii::app()->params['analytics']['projectId']);
        if (sizeof($analytics) == 0) {
            $analytics = new eAnalytics('new');
        }
        $analytics->project_id = Yii::app()->params['analytics']['projectId'];
        $startDate = Yii::app()->params['analytics']['startDate'];
        $endDate = date('Y-m-d');
        $results = eAnalytics::pullGAdata($startDate, $endDate);
        $results->startDate = $startDate;
        $results->endDate = $endDate;
        $analytics->json = json_encode($results);
        if ($analytics->validate())
            $analytics->save();
    }
}
?>
