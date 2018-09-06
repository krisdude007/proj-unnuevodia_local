<?php

class AdminReportController extends Controller {

    public $user;
    public $notification;
    public $layout = '//layouts/admin';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
        Yii::app()->setComponents(array('errorHandler' => array('errorAction' => 'admin/error',)));
        $this->user = ClientUtility::getUser();
        $this->notification = eNotification::model()->orderDesc()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'ajaxSelectedQuestion',
                    'ajaxAnalytics',
                    'ajaxDashboardGraph',
                    'ajaxGetLineGraphData',
                    'ajaxGetGraphData',
                    'demographic',
                    'weeklyReport',
                    'videoQuestionReport',
                    'tickerQuestionReport',
                    'index',
                    'test',
                    'TvReport',
                    'RegisteredUserReport',
                    'GamePlayesReport',
                    'GamePlayesReportTotal',
                    'GamePlayReportByHour',
                ),
                'expression' => '(Yii::app()->user->isAdmin())',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAjaxSelectedQuestion() {
        $this->layout = false;
        if ($_POST['pollId'] == "" || $_POST['startDate'] == "" || $_POST['endDate'] == "")
            return;
        $rows = Array(
            'Total' => number_format(ePollResponse::model()->filterByDates($_POST['startDate'], $_POST['endDate'])->countByAttributes(Array('poll_id' => $_POST['pollId']))),
            'Web' => number_format(ePollResponse::model()->filterByDates($_POST['startDate'], $_POST['endDate'])->countByAttributes(Array('poll_id' => $_POST['pollId'], 'source' => 'web'))),
            'Facebook' => number_format(ePollResponse::model()->filterByDates($_POST['startDate'], $_POST['endDate'])->countByAttributes(Array('poll_id' => $_POST['pollId'], 'source' => 'facebook'))),
            'Mobile' => number_format(ePollResponse::model()->filterByDates($_POST['startDate'], $_POST['endDate'])->countByAttributes(Array('poll_id' => $_POST['pollId'], 'source' => 'mobile'))),
            'Twitter' => number_format(ePollResponse::model()->filterByDates($_POST['startDate'], $_POST['endDate'])->countByAttributes(Array('poll_id' => $_POST['pollId'], 'source' => 'twitter'))),
                //'Text' => ePollResponse::model()->filterByDates($_POST['date'])->countByAttributes(Array('poll_id' => $_POST['pollId'], 'source' => 'text')),
        );
        $links = Array(
            'total_pollResponse_' . $_POST['pollId'],
            'web_pollResponse_' . $_POST['pollId'],
            'facebook_pollResponse_' . $_POST['pollId'],
            'mobile_pollResponse_' . $_POST['pollId'],
            'twitter_pollResponse_' . $_POST['pollId'],
        );
        $this->renderPartial('_reportTable', array('headerRow' => true, 'classes' => 'fab-a-blue', 'rows' => $rows, 'links' => $links, 'startDate' => $_POST['startDate'], 'endDate' => $_POST['endDate']));
    }

    public function actionAjaxAnalytics() {
        $this->layout = false;
        $results = eAnalytics::pullGAdata($_POST['start_date'], $_POST['end_date']);
        $rows = Array(
            'Total Visits' => number_format($results->visits),
            'Unique Visitors' => number_format($results->uniqueVisitors),
            'Pageviews' => number_format($results->pageviews),
            'Pages Per Visit' => isset($results->pagesPerVisit) ? $results->pagesPerVisit : 0,
            'Avg. Visit Duration' => $results->avgTimeOnSite,
            'Bounce Rate' => isset($results->bounceRate) ? $results->bounceRate : 0,
            '% New Visits' => isset($results->percentNew) ? $results->percentNew : 0,
        );

        $this->renderPartial('_reportTable', array('headerRow' => true, 'id' => 'gaData', 'rows' => $rows));
        unset($rows);
        $rows['By Browser'] = '';
        foreach ($results->browsers as $browser => $visits) {
            $rows[$browser] = $visits . '&nbsp;-&nbsp;' . round(($visits / $results->browsersTotal) * 100, 2) . '%';
        }
        $this->renderPartial('_reportTableToggle', array('id' => 'gaBrowserData', 'rows' => $rows));

        unset($rows);
        $rows['By OS'] = '';
        foreach ($results->os as $os => $visits) {
            $rows[$os] = $visits . '&nbsp;-&nbsp;' . round(($visits / $results->osTotal) * 100, 2) . '%';
        }
        $this->renderPartial('_reportTableToggle', array('id' => 'gaOsData', 'rows' => $rows));
    }

    /**
     *
     *
     * Demographic ACTIONS
     * This section contains everything required for the Demographic section of the admin
     *
     *
     */
    public function actionDemographic($startDate = null, $endDate = null, $request = null) {
        $startDate = DateTimeUtility::getStartDate($startDate);
        $endDate = (is_null($endDate) || $endDate == '') ? date("Y-m-d") : $endDate;
        ini_set('memory_limit', '512M');
        $request_array = explode('_', $request);
        if (count($request) == 3) {
            $scope = $request_array[0];
            $model = $request_array[1];
            $pollId = $request_array[2];
        } else {
            $pollId = 0;
            $scope = $request_array[0];
            $model = $request_array[1];
        }
        //for map
        switch ($model) {
            case 'user':
                $demographicData = eUser::model()->filterByDates($startDate, $endDate)->with('userEmails:primary', 'votesByUserId', 'countVideosByUserId', 'countVotesByUserId', 'userLocations:primary', 'userLogins:latest')->findAll(array('together' => true, 'group' => eUser::model()->getTableAlias() . '.id'));
                break;
            case 'ticker':
                $demographicData = eTicker::model()->filterByDates($startDate, $endDate)->ticker()->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eTicker::model()->getTableAlias() . '.user_id'));
                break;
            case 'video':
                $demographicData = eVideo::model()->filterByDates($startDate, $endDate)->processed()->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eVideo::model()->getTableAlias() . '.user_id'));
                break;
            case 'videoAccepted':
                $demographicData = eVideo::model()->filterByDates($startDate, $endDate)->processed()->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eVideo::model()->getTableAlias() . '.user_id'));
                break;
            case 'videoNew':
                $demographicData = eVideo::model()->filterByDates($startDate, $endDate)->processed()->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eVideo::model()->getTableAlias() . '.user_id'));
                break;
            case 'videoDenied':
                $demographicData = eVideo::model()->filterByDates($startDate, $endDate)->processed()->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eVideo::model()->getTableAlias() . '.user_id'));
                break;

            case 'image':
                $demographicData = eImage::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eImage::model()->getTableAlias() . '.user_id'));
                break;
            case 'imageAccepted':
                $demographicData = eImage::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eImage::model()->getTableAlias() . '.user_id'));
                break;
            case 'imageNew':
                $demographicData = eImage::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eImage::model()->getTableAlias() . '.user_id'));
                break;
            case 'imageDenied':
                $demographicData = eImage::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => eImage::model()->getTableAlias() . '.user_id'));
                break;

            case 'pollResponse':
                $parms = explode('_', $request);
//                $scope = $parms[0];
//                $model = $parms[1];
                if (sizeof($parms) == 3) {
                    $pollId = $parms[2];

                    $demographicData = Yii::app()->db->createCommand("select p.*, u.*,ue.*, ul.*, ua.* from poll_response p "
                            ."left outer join user u on (u.id = p.user_id) "
                            ."left outer join user_email ue on ((u.id = ue.user_id) and (ue.type='primary')) "
                            ."left outer join user_location ul on ((u.id = ul.user_id) and (ue.type='primary')) "
                            ."left outer join user_login ua on (u.id = ua.user_id) where (p.created_on >= '".$startDate."' and p.created_on <= '".$endDate."') "
                            ."group by p.user_id order by ua.created_on desc
                            ")->queryAll();

                    //$demographicData = ePollResponse::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => ePollResponse::model()->getTableAlias() . '.user_id'));
                }
                $demographicData = Yii::app()->db->createCommand("select p.*, u.*,ue.*, ul.*, ua.* from poll_response p "
                            ."left outer join user u on (u.id = p.user_id) "
                            ."left outer join user_email ue on ((u.id = ue.user_id) and (ue.type='primary')) "
                            ."left outer join user_location ul on ((u.id = ul.user_id) and (ue.type='primary')) "
                            ."left outer join user_login ua on (u.id = ua.user_id) where (p.created_on >= '".$startDate."' and p.created_on <= '".$endDate."') "
                            ."group by p.user_id order by ua.created_on desc
                            ")->queryAll();
                //$demographicData = ePollResponse::model()->filterByDates($startDate, $endDate)->with('user', 'user.userEmails:primary', 'user.votesByUserId', 'user.countVideosByUserId', 'user.countVotesByUserId', 'user.userLocations:primary', 'user.userLogins:latest')->findAll(array('together' => true, 'group' => ePollResponse::model()->getTableAlias() . '.user_id'));
                break;
            case 'gameChoiceResponse':
                $demographicData = eGameChoiceResponse::model()->filterByDates($startDate, $endDate)->with('eUser', 'eUser.userLocations:primary', 'eUser.userLogins:latest')->findAll(array('together' => true, 'group' => eGameChoiceResponse::model()->getTableAlias() . '.user_id'));
                break;
            default:
                echo "error, unrecognized model";
                exit;
        }
//        $uniqueZips = array();
//        foreach ($demographicData as $d) {
//            $zip = ($model != 'user') ? $d['postal_code'] : $d['postal_code'];
//            if ((is_numeric($zip)) && (strlen($zip) == 5)) {
//                $zip = (string) $zip;
//                if (in_array($zip, $uniqueZips)) {
//                    $uniqueZips[$zip]['count'] = 1;
//                } else {var_dump($uniqueZips);
//                    $uniqueZips[$zip]['count']++;
//                }
//            }
//        }exit;
//        $postalCodes = ePostalCode::model()->findAll();
//        foreach ($postalCodes as $postalCode) {
//            if (isset($uniqueZips[$postalCode->identifier])) {
//                $uniqueZips[$postalCode->identifier]['lat'] = ReportUtility::cleanLatLng($postalCode->latitude);
//                $uniqueZips[$postalCode->identifier]['lng'] = ReportUtility::cleanLatLng($postalCode->longitude);
//                $uniqueZips[$postalCode->identifier]['income'] = $postalCode->income;
//            }
//        }
        $records['records'] = array();
//        foreach (eAppSetting::model()->demographic()->active()->findAll() as $setting) {
//            $records['mapDisplayOnly'][] = $setting->attribute;
//        }
//
//        foreach ($demographicData as $d) {
//            $userId = ($model != 'user') ? $d->user->id : $d->id;
//            if ($userId) {
//                $postalCode = false;
//                $zip = '';
//                if ($model == 'user') {
//                    if (isset($d->userLocations[0])) {
//                        $postalCode = $d->userLocations[0]->getPostalCodeByPostalCode($d->userLocations[0]->postal_code);
//                        $zip = $d->userLocations[0]->postal_code;
//                    }
//                } else {
//                    if (isset($d->user->userLocations[0])) {
//                        $postalCode = $d->user->userLocations[0]->getPostalCodeByPostalCode($d->user->userLocations[0]->postal_code);
//                        $zip = $d->user->userLocations[0]->postal_code;
//                    }
//                }
//                $records['records'][] = array(
//                    'UserID' => Yii::app()->user->Id,
//                    'LastName' => ($model != 'user') ? $d->user->last_name : $d->last_name,
//                    'FirstName' => ($model != 'user') ? $d->user->first_name : $d->first_name,
//                    'Email' => ($model != 'user') ? (isset($d->user->userEmails) ? $d->user->userEmails[0]->email : '') : (isset($d->userEmails[0]) ? $d->userEmails[0]->email : ''),
//                    'Videos' => ($model != 'user') ? $d->user->countVideosByUserId : $d->countVideosByUserId,
//                    'Votes' => ($model != 'user') ? $d->user->countVotesByUserId : $d->countVotesByUserId,
//                    'Source' => ($model != 'user') ? $d->user->source : $d->source,
//                    'LastLoginDate' => ($model != 'user') ? (isset($d->user->userLogins[0]) ? $d->user->userLogins[0]->created_on : false) : (isset($d->userLogins[0]) ? $d->userLogins[0]->created_on : false),
//                    'JoinDate' => ($model != 'user') ? $d->user->created_on : $d->created_on,
//                    'ZipCode' => $zip,
//                    'country' => ($model != 'user') && !empty($d->user->userLocations[0]->country) ? $d->user->userLocations[0]->country : ($model == 'user') && !empty($d->userLocations[0]->country) ? $d->userLocations[0]->country : '',
//                    'AreaHouseholdIncome' => $postalCode ? $postalCode->income : 0,
//                    'latitude' => $postalCode ? $postalCode->latitude : '',
//                    'longitude' => $postalCode ? $postalCode->longitude : '',
//                );
//            }
//        }
        //for graph
        $daysBack = 0;
        if ($daysBack != 'total') {
            $filterDate = date('Y-m-d', strtotime('-' . $daysBack . ' days'));
        } else {
            $filterDate = Yii::app()->params['analytics']['startDate'];
        }
        $this->render('demographic', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'request' => $request,
            'demographicData' => $demographicData,
            //'uniqueZips' => $uniqueZips,
            'records' => $records,
            'daysBack' => $daysBack,
            'model' => $model,
            'scope' => $scope,
            'pollId' => $pollId
        ));
    }

    /**
     *
     *
     * REPORTING ACTIONS
     * This section contains everything required for the reporting section of the admin
     *
     *
     */
    public function actionIndex($startDate = null, $endDate = null) {
        $startDate = DateTimeUtility::getStartDate($startDate);
        $endDate = is_null($endDate) ? date("Y-m-d") : $endDate;
        $questions = ePoll::model()->findAll(array(
            'condition' => 'start_time or end_time >= :startDate and start_time or end_time <= :endDate',
            'params' => array(':startDate' => $startDate !== null ? gmdate('Y-m-d H:i:s', strtotime($startDate)) : null, ':endDate' => $endDate !== null ? gmdate('Y-m-d H:i:s', strtotime($endDate)) : null),
            'order' => 'id DESC'
        ));

        $json = eAnalytics::model()->findByPk(Yii::app()->params['analytics']['projectId']);
        $analyticsData = isset($json->json) ? json_decode($json->json) : false;

        //$webId = eDestination::model()->findByAttributes(Array('destination' => 'web'))->id;
        $facebookId = eDestination::model()->findByAttributes(Array('destination' => 'facebook'))->id;
        //$tvId = eDestination::model()->findByAttributes(Array('destination' => 'tv'))->id;

        $settings = eAppSetting::model()->report()->active()->findAll();
        foreach ($settings as $k => $v) {
            $pageSettings[$v->attribute] = $v->value;
        }
        $this->render('index', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'questions' => $questions,
            'analyticsData' => $analyticsData,
            'usersTotal' => eUser::model()->filterByDates($startDate, $endDate)->count(),
            'usersWeb' => eUser::model()->filterByDates($startDate, $endDate)->count('source="web"'),
            'usersFacebook' => eUser::model()->filterByDates($startDate, $endDate)->count('source ="facebook"'),
            'usersMobile' => eUser::model()->filterByDates($startDate, $endDate)->count('source ="mobile"'),
            'usersTwitter' => eUser::model()->filterByDates($startDate, $endDate)->count('source="twitter"'),
            'responseTotalCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count(),
            'responseWebCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count('source="web"'),
            'responseFaceboookCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count('source ="facebook"'),
            'responseMobileCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count('source ="mobile"'),
            'responseTwitterCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count('source="twitter"'),
            'responseTextCount' => ePollResponse::model()->filterByDates($startDate, $endDate)->count('source="text"'),
            'tickerTotalCount' => eTicker::model()->ticker()->filterByDates($startDate, $endDate)->count(),
            'tickerWebCount' => eTicker::model()->ticker()->filterByDates($startDate, $endDate)->count('source="web"'),
            'tickerFacebookCount' => eTicker::model()->ticker()->filterByDates($startDate, $endDate)->count('source ="facebook"'),
            'tickerMobileCount' => eTicker::model()->ticker()->filterByDates($startDate, $endDate)->count('source ="mobile"'),
            'tickerTwitterCount' => eTicker::model()->ticker()->filterByDates($startDate, $endDate)->count('source="twitter"'),
            'videoCounts' => eVideo::model()->processed()->filterByDates($startDate, $endDate)->getCountBySource(),
            'videoAcceptedCount' => eVideo::model()->processed()->filterByDates($startDate, $endDate)->accepted()->count(),
            'videoNewCount' => eVideo::model()->processed()->filterByDates($startDate, $endDate)->new()->count(),
            'videoDeniedCount' => eVideo::model()->processed()->filterByDates($startDate, $endDate)->denied()->count(),
            'videoViewCount' => eVideoView::model()->filterByDates($startDate, $endDate)->count(),
            'imageTotalCount' => eImage::model()->filterByDates($startDate, $endDate)->count(),
            'imageWebCount' => eImage::model()->filterByDates($startDate, $endDate)->count('source="web"'),
            'imageFacebookCount' => eImage::model()->filterByDates($startDate, $endDate)->count('source ="facebook"'),
            'imageMobileCount' => eImage::model()->filterByDates($startDate, $endDate)->count('source ="mobile"'),
            'imageVineCount' => eImage::model()->filterByDates($startDate, $endDate)->count('source="vine"'),
            'imageAcceptedCount' => eImage::model()->filterByDates($startDate, $endDate)->accepted()->count(),
            'imageNewCount' => eImage::model()->filterByDates($startDate, $endDate)->new()->count(),
            'imageDeniedCount' => eImage::model()->filterByDates($startDate, $endDate)->denied()->count(),
            'socialReceivedTotalCount' => eTicker::model()->filterByDates($startDate, $endDate)->social()->count(),
            'socialFacebookCount' => eTicker::model()->filterByDates($startDate, $endDate)->social()->count('source ="facebook"'),
            'socialTwitterCount' => eTicker::model()->filterByDates($startDate, $endDate)->social()->count('source="twitter"'),
            'socialReturnedTwitterCount' => eTickerSearchPull::model()->filterByDates($startDate, $endDate)->count('source="twitter"'),
            'socialReturnedTwitterFollowing' => (int) Yii::app()->db->createCommand("SELECT SUM(following) FROM ticker_search_pull")->queryScalar(), //temp, need to use Yii
            'socialAssignedTwitterCount' => eTicker::model()->filterByDates($startDate, $endDate)->social()->count('source="twitter"'),
            'socialAcceptedTwitterCount' => eTicker::model()->filterByDates($startDate, $endDate)->social()->accepted()->count('source="twitter"'),
            'settings' => $pageSettings,
            'socialPublishedTotalCount' => 0,
            'socialToWebCount' => 0,
            'socialToFacebookCount' => 0,
            'socialToTvCount' => 0,
                //SOCIAL SEARCH tricky part is filterByDate, or filterByTickerDate or filterByDestinationDate (destonation date broken for some reason)
//            'socialPublishedTotalCount' => eTicker::model()->filterByDestinationDate($filterDate)->social()->with('tickerDestination')->hasDestination()->count(),
//            'socialToWebCount' => eTicker::model()->filterByTickerDate($filterDate)->social()->with('tickerDestination')->filterByDestination($webId)->count(),
//            'socialToFacebookCount' => eTicker::model()->filterByTickerDate($filterDate)->social()->with('tickerDestination')->filterByDestination($facebookId)->count(),
//            'socialToTvCount' => eTicker::model()->filterByTickerDate($filterDate)->social()->with('tickerDestination')->filterByDestination($tvId)->count(),
        ));
    }

    public function actionAjaxGetLineGraphData() {
        $startDate = $startDate = DateTimeUtility::getStartDate(Yii::app()->request->getPost('startDate'));
        $endDate = Yii::app()->request->getPost('endDate');
        switch (Yii::app()->request->getPost('model')) {
            case "user":
                $results = eUser::model()->filterByDates($startDate, $endDate)->findAll();
                break;
            case "video":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->findAll();
                break;
            case "ticker":
                $results = eTicker::model()->ticker()->filterByDates($startDate, $endDate)->findAll();
                break;
            case "pollResponse":
                if (isset($_POST['pollId']) && $_POST['pollId'] == 0)
                    $results = ePollResponse::model()->filterByDates($startDate, $endDate)->findAll();
                else
                    $results = ePollResponse::model()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('poll_id' => $_POST['pollId']));//var_dump($results);
                break;
            case "videoAccepted":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'accepted'));
                break;
            case "videoNew":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'new'));
                break;
            case "videoDenied":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'denied'));
                break;


            case "image":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->findAll();
                break;
            case "imageAccepted":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'accepted'));
                break;
            case "imageNew":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'new'));
                break;
            case "imageDenied":
                $results = eImage::model()->filterByDates($startDate, $endDate)->FindAllByAttributes(Array('status' => 'denied'));
                break;
            default:
                echo "error: unexpected model ONE";
                return true;
        }
        if ($_POST['scope'] == 'total') {
            $initializedResultSet = ReportUtility::initResults($startDate, $endDate);
            switch ($_POST['model']) {
                case "user":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#aaaaaa');
                    break;
                case "video":
                case "videoAccepted":
                case "videoNew":
                case "videoDenied":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'vine' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#00bf8f', '#aaaaaa');
                    break;
                case "image":
                case "imageAccepted":
                case "imageNew":
                case "imageDenied":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'vine' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#00bf8f', '#aaaaaa');
                    break;
                case "ticker":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#aaaaaa');
                    break;
                case "vote":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#aaaaaa');
                    break;
                case "pollResponse":
                    $totals = Array(
                        'web' => $initializedResultSet,
                        'facebook' => $initializedResultSet,
                        'twitter' => $initializedResultSet,
                        'mobile' => $initializedResultSet,
                        'total' => $initializedResultSet
                    );
                    $seriesColors = array('#35aa47', '#ff9900', '#e02222', '#852b99', '#aaaaaa');
                    break;
                default:
                    echo "error: unexpected model TWO";
                    return;
                    break;
            }
        } else {
            $totals = Array(
                $_POST['scope'] => ReportUtility::initResults($startDate, $endDate)
            );
        }
        $max = 0;
        foreach ($results as $k => $v) {
            if ($_POST['scope'] == 'total' || $_POST['scope'] == $v->source) {
                if (isset($totals[$v->source][substr($v->created_on, 0, strpos($v->created_on, ' '))])) {
                    $totals[$v->source][substr($v->created_on, 0, strpos($v->created_on, ' '))]++;
                } else {
                    $totals[$v->source][substr($v->created_on, 0, strpos($v->created_on, ' '))] = 1;
                }
                if (isset($totals['total'][substr($v->created_on, 0, strpos($v->created_on, ' '))])) {
                    $totals['total'][substr($v->created_on, 0, strpos($v->created_on, ' '))]++;
                } else {
                    $totals['total'][substr($v->created_on, 0, strpos($v->created_on, ' '))] = 1;
                }
                $newMax = $totals['total'][substr($v->created_on, 0, strpos($v->created_on, ' '))];
                $max = $newMax > $max ? $newMax : $max;
            }
        }
        if ($_POST['scope'] != 'total') {
            unset($totals['total']);
        } else {
            $ret['deselectTotal'] = true;
        }
        $ret['data'] = $totals;
        $ret['seriesColors'] = isset($seriesColors) ? json_encode($seriesColors) : false;
        $ret['yMax'] = $max;
        echo json_encode($ret);
    }

    public function actionAjaxGetGraphData() {
        $startDate = $startDate = DateTimeUtility::getStartDate(Yii::app()->request->getPOST('startDate'));
        $endDate = Yii::app()->request->getPOST('endDate');
        switch (Yii::app()->request->getPOST('model')) {
            case "video":
                $results = eVideo::model()->processed()->filterByDates($startDate, $endDate)->getCountBySource();
                $seriesColors = array('#fd8e22', '#ff4014', '#e7191b', '#c91011', "#839557", "#958c12", "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c747a3", "#cddf54", "#FBD178", "#26B4E3", "#bd70c7");
                break;
            case "image":
                $results = eImage::model()->filterByDates($startDate, $endDate)->getCountBySource();
                $seriesColors = array('#fd8e22', '#ff4014', '#e7191b', '#c91011', "#839557", "#958c12", "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c747a3", "#cddf54", "#FBD178", "#26B4E3", "#bd70c7");
                break;
            case "ticker":
                $results = Array(
                    'Web' => eTicker::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'web')),
                    'Mobile' => eTicker::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'mobile')),
                    'Facebook' => eTicker::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'facebook'))
                );
                $seriesColors = array('#ffd73d', '#b1b614', '#909408');
                break;
            case "vote":
                $results = Array(
                    'Web' => ePollResponse::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'web')),
                    'Mobile' => ePollResponse::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'mobile')),
                    'Facebook' => ePollResponse::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'facebook')),
                    'Twitter' => ePollResponse::model()->filterByDates($startDate, $endDate)->countByAttributes(Array('source' => 'twitter'))
                );
                $seriesColors = array('#bf4ca6', '#941278', '#480858', '#2c0237');
                break;
        }
        $max = 0;
        if ($results) {
            foreach ($results as $k => $v) {
                $max = $v > $max ? $v : $max;
            }
        }
        $max = ceil($max * .2 + $max);
        $ret['data'] = $results;
        $ret['seriesColors'] = json_encode($seriesColors);
        $ret['yMax'] = $max;
        echo json_encode($ret);
    }

    public function actionWeeklyReport($startDate = null) {
        $startDate = is_null($startDate) ? date('Y-m-d', strtotime('this week', time())) : $startDate;
        $ru = new ReportUtility($startDate);
        $HAS_VIDEO = in_array('HAS_VIDEO', Yii::app()->params['features']);
        $HAS_IMAGE = in_array('HAS_IMAGE', Yii::app()->params['features']);
        $HAS_VOTING = in_array('HAS_VOTING', Yii::app()->params['features']);
        $criteria = new CDbCriteria;

        $criteria->condition = 'source = "web"';
        $users['New Registered Users from Website'] = $ru->formatCategoryWeek(eUser::model(), $criteria);
        $criteria->condition = 'source = "facebook"';
        $users['New Registered Users logging in w/ FB'] = $ru->formatCategoryWeek(eUser::model(), $criteria);
        if (isset(Yii::app()->params['reporting']['getMobileRegisteredUsers']) && Yii::app()->params['reporting']['getMobileRegisteredUsers'] == true) {
        $criteria->condition = 'source = "mobile" or source = "mobile web"';
        $users['New Registered Users logging in w/ mobile'] = $ru->formatCategoryWeek(eUser::model(), $criteria);
        }

        if ($HAS_VIDEO) {
            $criteria->condition = 'source = "web"';
            $videos['Web Video Submissions'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = 'source = "facebook"';
            $videos['Facebook Video Submissions'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = 'source = "mobile"';
            $videos['Mobile Video Submissions'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = '1 = 1';
            $criteria->group = 'user_id';
            $videos['Unique Users to Record'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = 'status = "new"';
            $criteria->group = '';
            $videos['Videos Not Accepted'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = 'status = "denied"';
            $videos['Videos Deleted'] = $ru->formatCategoryWeek(eVideo::model()->processed(), $criteria);
            $criteria->condition = '1 = 1';
            $videos['Total Video Views'] = $ru->formatCategoryWeek(eVideoView::model(), $criteria);
        }

        if ($HAS_IMAGE) {
            $criteria->condition = 'source = "web"';
            $photos['Web Photo Submissions'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = 'source = "facebook"';
            $photos['Facebook Photo Submissions'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = 'source = "mobile"';
            $photos['Mobile Photo Submissions'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = '1 = 1';
            $criteria->group = 'user_id';
            $photos['Unique Users to Record'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = 'status = "new"';
            $criteria->group = '';
            $photos['Photos Not Accepted'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = 'status = "denied"';
            $photos['Photos Deleted'] = $ru->formatCategoryWeek(eImage::model(), $criteria);
            $criteria->condition = '1 = 1';
            $photos['Total Photo Views'] = $ru->formatCategoryWeek(eImageView::model(), $criteria);
        }

        $criteria->condition = 'source = "web"';
        $votes['Web Votes'] = $ru->formatCategoryWeek(ePollResponse::model(), $criteria);
        $criteria->condition = 'source = "facebook"';
        $votes['Facebook Votes'] = $ru->formatCategoryWeek(ePollResponse::model(), $criteria);
        $criteria->condition = 'source = "mobile"';
        $votes['Mobile Votes'] = $ru->formatCategoryWeek(ePollResponse::model(), $criteria);
        $criteria->condition = 'source = "twitter"';
        $votes['Twitter Votes'] = $ru->formatCategoryWeek(ePollResponse::model(), $criteria);

        $totals['New Registered Users'] = $ru->compareCategoryWeeks(eUser::model());
        if ($HAS_VIDEO)
            $totals['Video Submissions'] = $ru->compareCategoryWeeks(eVideo::model());
        if ($HAS_IMAGE)
            $totals['Photo Submissions'] = $ru->compareCategoryWeeks(eImage::model());
        if ($HAS_VOTING)
            $totals['Voting Participation'] = $ru->compareCategoryWeeks(ePollResponse::model());
        if ($HAS_VIDEO)
            $totals['Total Video Views'] = $ru->compareCategoryWeeks(eVideoView::model());

        $weekBefore = date('Y-m-d', strtotime($startDate . ' - 1 week'));
        $ymd = explode("-", $weekBefore);
        $startingIndexDay = $ymd[2];
        if(file_exists(Yii::app()->params['analytics']['keyfile']))
            $data = eAnalytics::pullData($weekBefore, date('Y-m-d', strtotime($startDate . ' + 1 week')));
        if (!empty($data)) {
            foreach ($data as $gapiReportEntry) {
                $temp = $gapiReportEntry->getDimensions();
                if (isset($temp['visitorType'])) {
                    $associative[$temp['day']][$temp['visitorType']] = $gapiReportEntry->getMetrics();
                }
            }
        }
        //array_split wont work on associative array
        //put the starting day at the front of the array since google's order by day uses the number and not the date(stupid)
        $gotToStartIndex = false;
        $analyticsTotals = array();
        if (isset($associative) && $associative) {
            foreach ($associative as $day => $record) {
                if ($day == $startingIndexDay)
                    $gotToStartIndex = true;
                if ($gotToStartIndex)
                    $analyticsTotals[] = $record;
            }
        }
        $analytics = $ru->formatAnalyticWeek($analyticsTotals);
        $analyticsCompare = $ru->compareAnalyticWeeks($analyticsTotals);

        $collection['User Data'] = $users;
        if ($HAS_VIDEO)
            $collection['Video Participation'] = $videos;
        if ($HAS_IMAGE)
            $collection['Photo Participation'] = $photos;
        if ($HAS_VOTING)
            $collection['Voting Participation'] = $votes;
        //$collection['Web Analytics'] = $analytics;
        $collection['Week-to-week Trends'] = $totals;
        //$collection['Analytic Trends'] = $analyticsCompare;
        $this->render('weekly', Array(
            'startDate' => $startDate,
            'collection' => $collection,
        ));
    }

    public function actionTickerQuestionReport() {
        $type = 'ticker';
        $question = new eQuestion('search');
        $dataProvider = $question->search($type);
        $questions = eQuestion::model()->{$type}()->findAll($dataProvider->criteria);
        $this->render('question', Array(
            'questions' => $questions,
            'pages' => $dataProvider->pagination,
            'sort' => $dataProvider->sort,
            'type' => $type,
        ));
    }

    public function actionVideoQuestionReport() {
        $type = 'video';
        $question = new eQuestion('search');
        $dataProvider = $question->search($type);
        $questions = eQuestion::model()->{$type}()->findAll($dataProvider->criteria);
        $this->render('question', Array(
            'questions' => $questions,
            'pages' => $dataProvider->pagination,
            'sort' => $dataProvider->sort,
            'type' => $type,
        ));
    }

    public function actionTvReport() {
        $hayStack = array();
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=TV_Report.csv");
        header("Content-Transfer-Encoding: binary");
        $headerArray = array('Video Title', 'Video Created', 'Video Updated', 'User Id', 'First Name', 'Last Name', 'Username', 'Phone Number');
        $criteria = new CDbCriteria;
        $criteria->select = 't.title, t.created_on, t.updated_on, t.user_id';
        if (isset(Yii::app()->params['video']['extendedFilterLabels'][1]))
            $hayStack = array_keys(Yii::app()->params['video']['extendedFilterLabels'][1]);
        if (in_array('acceptedtv', $hayStack)) {
            $criteria->condition = 't.statusbit & ' . Yii::app()->params['statusBit']['acceptedTv'];
        } else {
            $criteria->condition = 't.status = "accepted"';
        }
        $criteria->with = array('user' => array('select' => 'user.first_name,last_name, user.username, user.birthday'), 'user.userPhones:primary' => array('select' => 'userPhones.number'));
        $videoArray = eVideo::model()->findAll($criteria);
        $df = fopen("php://output", 'w');
        fputcsv($df, $headerArray);
        foreach ($videoArray as $row => $val) {
            if (isset($val->user->userPhones[0]->number))
                $number = $val->user->userPhones[0]->number;
            else
                $number = '';
            $row = array($val->title,
                $val->created_on,
                $val->updated_on,
                $val->user_id,
                $val->user->first_name,
                $val->user->last_name,
                $val->user->username,
                $number);
            fputcsv($df, $row);
        }
        fclose($df);
    }

    public function actionRegisteredUserReport() {
        $hayStack = array();
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=RegisteredUser_Report.csv");
        header("Content-Transfer-Encoding: binary");
        $headerArray = array('Id', 'Username', 'First Name', 'Last Name', 'Phone', 'Zip Code', 'Date Registered', 'Video Count');
        $criteria = new CDbCriteria;

        if (isset(Yii::app()->params['RegisteredUserReportStartDate'])) {
            $startDate = Yii::app()->params['RegisteredUserReportStartDate'];
        } else {
            $startDate = "2012-10-01 00:00:00";
        }

        $criteria->condition = 't.role = "user" AND t.created_on != "0000-00-00 00:00:00" AND t.created_on >= "' . $startDate . '"';
        $criteria->with = array('userPhones:primary' => array('select' => 'userPhones.number'), 'userLocations:primary' => array('select' => 'userLocations.postal_code'));
        $videoArray = eUser::model()->findAll($criteria);
        $df = fopen("php://output", 'w');
        fputcsv($df, $headerArray);
        foreach ($videoArray as $row => $val) {
            if (isset($val->userPhones[0]->number))
                $number = $val->userPhones[0]->number;
            else
                $number = '';
            if (isset($val->userLocations[0]->postal_code))
                $postal_code = $val->userLocations[0]->postal_code;
            else
                $postal_code = '';
            $videosCount = eVideo::model()->count("user_id=:user_id", array("user_id" => $val->id));
            $row = array($val->id,
                $val->username,
                $val->first_name,
                $val->last_name,
                $number,
                $postal_code,
                $val->created_on,
                $videosCount
            );
            fputcsv($df, $row);
        }
        fclose($df);
    }

    public function actionGamePlayesReport() {
        //Yii::import('ext.EGeoIP');
        //$geoIp = new EGeoIP();
        $game_id = (int) $_GET['game_id'];
        $city = NULL;
        //$ipbasedcity = NULL;
        //$ipaddress = NULL;

        $now = gmdate("D, d M Y H:i:s");

        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=Game_Report{$game_id}.csv");
        header("Content-Transfer-Encoding: binary");

        $responces = eGameChoiceResponse::model()->recentASC()->with('gameChoiceAnswer')->with('gameChoiceSmsOutbound')->with('user')->FindAllByAttributes(Array('game_choice_id' => $game_id));

        $headerArray = array('User ID', 'Username', 'Game ID', 'User Input', 'Input Valid/Invalid', 'Payment Type', 'Correct', 'Winner', 'Source', 'Credits Earned', 'Games Played', 'IP Address', 'Google Shared City', 'Google Shared State','IP Based City', 'IP Based State','Date/Time');

        $df = fopen("php://output", 'w');
        fputcsv($df, $headerArray);

        GameUtility::writeToFile($df, $responces);

        //get sub games if any
        $subGames = eGameChoice::model()->FindAllByAttributes(Array('g_parant_id' => $game_id));

        if(!empty($subGames)) {
            foreach($subGames as $sG) {
                $subResponces = eGameChoiceResponse::model()->recentASC()->with('gameChoiceAnswer')->with('gameChoiceSmsOutbound')->with('user')->FindAllByAttributes(Array('game_choice_id' => $sG->id));

                GameUtility::writeToFile($df, $subResponces);
            }
        }

        fclose($df);
    }

    public function actionGamePlayesReportTotal() {

        $now = gmdate("D, d M Y H:i:s");

        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=Game_ReportAll.csv");
        header("Content-Transfer-Encoding: binary");

        $responces = eGameChoiceResponse::model()->recentASC()->with('gameChoiceAnswer')->with('gameChoiceSmsOutbound')->with('user')->FindAll();

        $headerArray = array('User ID', 'Username', 'Game ID', 'User Input', 'Input Valid/Invalid', 'Payment Type', 'Correct', 'Winner', 'Source', 'Date/Time');

        $df = fopen("php://output", 'w');
        fputcsv($df, $headerArray);

        foreach ($responces as $r) {
            if ($r->gameChoiceSmsOutbound) {
                $userInput = $r->gameChoiceSmsOutbound->smstext;
            } else {
                if ($r->gameChoiceAnswer) {
                    $userInput = $r->gameChoiceAnswer->label;
                } else {
                    $userInput = 'n/a';
                }
            }

            if ($r->gameChoiceAnswer) {
                if ($r->gameChoiceAnswer->label == '#') {
                    $userInputValidInvalid = 'Invalid';
                } else {
                    $userInputValidInvalid = 'Valid';
                }

                $isCorrect = $r->gameChoiceAnswer->is_correct;
            } else {
                $userInputValidInvalid = 'n/a';
                $isCorrect = 'n/a';
            }

            if ($r->sms_id == NULL && $r->transaction_id == NULL) {
                $paymentType = 'non-paid';
            } else {
                $paymentType = 'paid';
            }
            $row = array($r->user_id, $r->user->username, $r->game_choice_id, $userInput, $userInputValidInvalid, $paymentType, $isCorrect, $r->is_winner, $r->source, $r->created_on);
            fputcsv($df, $row);
        }

        fclose($df);
    }

    public function actionGamePlayReportByHour() {

        $game_id = (int) $_GET['game_id'];

        $gamechoice = eGameChoice::model()->findByPK($game_id);
        $startdate = date('Y-m-d H:00:00', strtotime($gamechoice->start_date));
        if (!empty($gamechoice->end_date)) {
            $enddate = date('Y-m-d H:00:00', strtotime($gamechoice->end_date));
        } else {
            $enddate = date('Y-m-d H:00:00', strtotime("now"));
        }

        $now = gmdate("D, d M Y H:i:s");

        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=GamePlayReportByHour_Report{$game_id}.csv");
        header("Content-Transfer-Encoding: binary");

        $playsByHour = eGameChoiceResponse::model()->getPlaysByHourly($game_id); //var_dump($playsByHour);
        $arr = array();
        foreach ($playsByHour as $v) {
            $arr[] = date('Y-m-d H:00:00', strtotime($v->created_on));
        }

        $headerArray = array('Time', 'Web Play', 'Web Free', 'SMS Play', 'Mobile Play', 'Mobile Free', 'IVR');
        $df = fopen("php://output", 'w');
        fputcsv($df, $headerArray);
        $currentdate = $startdate;

        while ($currentdate <= $enddate) {

            $key = array_search($currentdate, $arr);
            if ($key !== FALSE) {
                $row = array(date('g a', strtotime(($playsByHour[$key]->created_on))), $playsByHour[$key]->webplays, $playsByHour[$key]->webfreeplays, $playsByHour[$key]->SMSplays, $playsByHour[$key]->mobileplays, $playsByHour[$key]->mobilefreeplays, $playsByHour[$key]->IVRplays); //var_dump($row);
            } else {
                $row = array(date('g a', strtotime(($currentdate))), 0, 0, 0, 0, 0, 0); //var_dump($row);
            }
            fputcsv($df, $row);
            $currentdate = date('Y-m-d H:00:00', strtotime('+1 hour', strtotime($currentdate))); //echo $currentdate.'<br>';
        }
        fclose($df);
    }

}
