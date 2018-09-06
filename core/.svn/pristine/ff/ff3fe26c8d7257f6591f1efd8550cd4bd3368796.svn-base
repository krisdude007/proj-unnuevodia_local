<?php

class GameUtility {

    //get total points for a user
    public static function totalUserPoints($user_id) {
        //will need to convert to yii
        $total = Yii::app()->db->createCommand("SELECT SUM(A.point_value) "
                        . "FROM game_choice_answer AS A "
                        . "RIGHT JOIN game_choice_response AS R ON R.game_choice_answer_id=A.id AND R.user_id=$user_id")->queryScalar();

        return $total;
    }

    //get top users according to points
    public static function topUsersPoints($top = 10) {
        //will need to convert to yii
        $result = Yii::app()->db->createCommand("SELECT SUM(A.point_value) AS total, R.user_id "
                        . "FROM game_choice_answer AS A "
                        . "RIGHT JOIN game_choice_response AS R ON R.game_choice_answer_id=A.id "
                        . "GROUP BY R.user_id "
                        . "ORDER BY total DESC LIMIT $top")->queryAll();

        $totals = array();
        $i = 0;
        foreach ($result as $r) {
            $totals[$i]['id'] = $r['user_id'];
            $totals[$i]['total'] = $r['total'];
            $i++;
        }

        return $totals;
    }

    public static function pickWinnerRand($old_is_active, $new_is_active, $game_id) {

        if ($old_is_active == 1 && $new_is_active == 0) {

            $settings = eAppSetting::model()->active()->findAll();
            foreach ($settings as $k => $v) {
                $pageSettings[$v->attribute] = $v->value;
            }

            //$answers = eGameChoiceAnswer::model()->with('gameChoiceResponse:isPaid')->findByAttributes(array('game_choice_id' => $game_id, 'is_correct' => 1));
            $answers = eGameChoiceAnswer::model()->with('gameChoiceResponse')->findByAttributes(array('game_choice_id' => $game_id, 'is_correct' => 1));

            if($answers != NULL) {
                $validResponseArray = Array();
                $i = 0;

                if(!empty($pageSettings['game_free_credit_in_sweep']) && $pageSettings['game_free_credit_in_sweep'] == 1) {
                    foreach($answers->gameChoiceResponse as $response) {
                        //if($response->transaction_id != NULL) {
                            //$transaction = eTransaction::model()->findByPK($response->transaction_id);

                            //if($transaction->processor != 'credit')
                            //{
                                //for($j=1; $j<=$transaction->raffle_value; $j++) {
                                    $validResponseArray[$i] = $response->id;
                                    $i++;
                                //}
                            //}
                        //}
                    }
                }
                else {
                    foreach($answers->gameChoiceResponse as $response) {
                        //if($response->transaction_id != NULL) {
                            //$transaction = eTransaction::model()->findByPK($response->transaction_id);

                            //for($j=1; $j<=$transaction->raffle_value; $j++) {
                                $validResponseArray[$i] = $response->id;
                                $i++;
                            //}
                        //}
                    }
                }

                if(sizeof($validResponseArray) >= 1) {
                    $response_id = $validResponseArray[rand(0, sizeof($validResponseArray) - 1)];

                    $responseWin = eGameChoiceResponse::model()->findByPK($response_id);
                    $responseWin->is_winner = 1;
                    $responseWin->save();

                    //GameUtility::sendEmailToWinner($game_id);
                }
            }

            //Old
//            if ($answers != NULL && sizeof($answers->gameChoiceResponse) >= 1) { //make sure there is a correct response
//                //get random response
//                $response_id = $answers->gameChoiceResponse[rand(0, sizeof($answers->gameChoiceResponse) - 1)]->id;
//                $response_id = !empty($response_id) ? $response_id : 0;
//                $response = eGameChoiceResponse::model()->findByPK($response_id);
//                $response->is_winner = 1;
//                $response->save();
//            } else {
//                //GameUtility::sendEmailEndGame($game_id);
//            }

            //GameUtility::sendEmailToWinner($game_id);
            //GameUtility::sendEmailEndGame($game_id);
        }
    }

    public static function sendEmailToWinner($game_id) {

        $responses = eGameChoiceResponse::model()->isPaid()->findByAttributes(array('game_choice_id' => $game_id, 'is_winner' => 1));

        if($responses != NULL) {
            $user = eUser::model()->findByPk($responses->user_id);
            $userEmail = clientUserEmail::model()->findByAttributes(array('user_id' => $user->id, 'type' => 'primary'));

            $result = MailUtility::send('winner', $userEmail->email, array('link' => 'mailto: youtootechsupport@youtootech.com'), false);
                if ($result) {

                }
        }
    }

    public static function sendEmailEndGame($game_id) {
        $game = eGameChoice::model()->findByPk($game_id);

        if(getenv('YOUTOO_ENVIRONMENT') == 'aws-development') {
            //$to = array('krisdude007@gmail.com');
            $to = Array('philip@philipgura.com', 'kris.naladi@gmail.com', 'mark@youtootech.com');
        }
        else {
            //$to = array('krisdude007@gmail.com');
            //$to = Array('mark@youtootech.com', 'philip@philipgura.com', 'kris.naladi@gmail.com');
            $to = Array('mark@youtootech.com', 'kris.naladi@gmail.com', 'philip@philipgura.com',
                        'Danny.ohman@youtootech.com',
                        'Heidi.Miller@youtootech.com',
                        'frank@youtootech.com');
        }

        if (!empty($game->winner_username)) {
        $total_plays = $game->num_plays_sms_paid + $game->num_plays_ivr_paid + $game->num_plays_web_paid + $game->num_plays_web_free + $game->num_plays_free_anonymous;

        $report = "
        <h3>Game Statistics</h3>

    <table border=\"1\">
        <thead>
            <tr>
                <th>Paid Plays</th>
                <th>None Paid Plays</th>
                <th>Paid Unique Users</th>
                <th>None Paid Unique Users</th>
            </tr>
        </thead>
        <tr>
            <td>{$game->num_plays_paid}</td>
            <td>{$game->num_plays_free}</td>
            <td>{$game->num_users_paid}</td>
            <td>{$game->num_users_free}</td>
        </tr>
        <tr></tr>
    </table>
    <br/>
    <table border=\"1\">
        <thead>
            <tr>
                <th>Total Plays</th>
                <th>SMS Plays</th>
                <th>IVR Plays</th>
                <th>Web Plays</th>
                <th>Web Non-Paid Plays</th>
                <th>Web Anonymous Plays</th>
            </tr>
        </thead>
            <tr>
            <td>{$total_plays}</td>
            <td>{$game->num_plays_sms_paid}</td>
            <td>{$game->num_plays_ivr_paid}</td>
            <td>{$game->num_plays_web_paid}</td>
            <td>{$game->num_plays_web_free}</td>
            <td>{$game->num_plays_free_anonymous}</td>
            </tr>
        <tr></tr>
    </table>";

        foreach ($to as $t) {
            MailUtility::send('endgame', $t,
                                array('game_id' => $game->id,
                                      'game_title' => $game->question,
                                      'start_date' => $game->start_date,
                                      'end_date' => $game->end_date,
                                      'winner_link' => Yii::app()->createAbsoluteUrl('adminGame/printInvoice', array('type' => 'game', 'id' => $game->id)),
                                      'winner' => !empty($game->winner_username) ? $game->winner_username : 'Winner is yet to be announced.',
                                      //'game_link' => Yii::app()->createAbsoluteUrl('admin/gamereport', array('id' => $game->id)),
                                      //'game_title' => $game->question,
                                      'report' => $report
                                      ), false, false);
            }
        } else {
            $report = 'Game not Initated. No Winner Declared'.
            MailUtility::send('endgame', $t,
                                array('game_id' => $game->id,
                                      'game_title' => $game->question,
                                      'start_date' => $game->start_date,
                                      'end_date' => $game->end_date,
                                      //'winner_link' => Yii::app()->createAbsoluteUrl('adminGame/printInvoice', array('type' => 'game', 'id' => $game->id)),
                                      'winner' => 'No Winner Declared',
                                      //'game_link' => Yii::app()->createAbsoluteUrl('admin/gamereport', array('id' => $game->id)),
                                      //'game_title' => $game->question,
                                      'report' => $report
                                      ), false, false);
        }
    }

    public static function setPeriodWinner($type, $day, $week, $month, $year) {

        $flagValidDate = false;

        //validate date
        if ($type == 'week') {
            if ($year < date('Y') || ($year == date('Y') && $week < date('W'))) {
                $flagValidDate = true;
            }
        } else if ($type == 'month' || $type == 'year') {
            if ($year < date('Y') || ($year == date('Y') && $month < date('n'))) {
                $date = new DateTime();
                $date->setDate($year, $month, $day);

                $flagValidDate = true;
            }
        }

//        if (($year <= date('Y') && $month <= 12 && $month >= 1 && $day <= 31 && $day >= 1 && $week >= 0 && $week <= 52)) {
//            $date = new DateTime();
//            $date->setDate($year, $month, $day);
//        } else {
//            echo 'Invalid date, only past dates can be run, NOT future or present.';
//            exit;
//        }

        if ($flagValidDate) {
            if ($type == 'week') { //week
                $starEnd = DateTimeUtility::getStartAndEndDateWeek($week, $year);

                $from = "{$starEnd[0]} 00:00:00";
                $to = "{$starEnd[1]} 23:59:59";

                $name = "{$week}-{$year}";
            } else if ($type == 'month') { //month
                $from = "{$date->format('Y-m')}-01 00:00:00";
                $to = "{$date->format('Y-m-t')} 23:59:59";

                $name = $date->format('F-Y');
            } else if ($type == 'year') { //year
                $from = "{$date->format('Y')}-01-01 00:00:00";
                $to = "{$date->format('Y')}-12-31 23:59:59";

                $name = $date->format('Y');
            } else {
                exit;
            }

            $winner = eGameWinner::model()->{$type}()->notdeleted()->findByAttributes(array('from_date' => $from, 'to_date' => $to));

            if ($winner == NULL) {
                GameUtility::pickWinnerRandPeriod($type, $name, $from, $to);
            } else if ($winner->user_id == NULL) {
                GameUtility::pickWinnerRandPeriod($type, $name, $from, $to, false, $winner->id);
            } else {
                //echo 'This period already exists.';
            }
        }
    }

    public static function pickWinnerRandPeriod($type, $name, $from, $to, $isNew = true, $winnerID = NULL) {
        //YYYY-MM-DD HH:MM:SS
        //$from = '2015-01-01 00:00:00';
        //$to = '2015-01-15 00:00:00';

        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('t.created_on', $from, $to);

        $answers = eGameChoiceAnswer::model()->with('gameChoiceResponse:isPaid')->findByAttributes(array('is_correct' => 1), $criteria);

        if ($isNew) {
            $winner = new eGameWinner;
        } else if ($winnerID != NULL) {
            $winner = eGameWinner::model()->findByPk($winnerID);
        } else {
            exit;
        }

        $num_games = 0;
        $num_plays = 0;
        $num_users = 0;
        $num_correct_plays = 0;

        if ($answers != NULL && sizeof($answers->gameChoiceResponse) >= 1) {
            $num_correct_plays = sizeof($answers->gameChoiceResponse);
            $winner->user_id = $answers->gameChoiceResponse[rand(0, sizeof($answers->gameChoiceResponse) - 1)]->user_id;
            $winner->type = $type;
        } else {
            $winner->user_id = NULL;
        }

        $winner->type = $type;
        $winner->contest_name = $name;
        $winner->num_games = $num_games;
        $winner->num_plays = $num_plays;
        $winner->num_correct_plays = $num_correct_plays;
        $winner->num_users = $num_users;
        $winner->from_date = $from;
        $winner->to_date = $to;
        $winner->save();
    }

    public static function getWinners() {
        //$with = array('eGameChoiceResponse:isWinner', 'eGameChoiceAnswers:isCorrect');
        //$games = eGameChoice::model()->recent()->isNotActive()->notdeleted()->multiple()->with('gameChoiceResponse')->with('gameChoiceAnswers:isCorrect')->findAll();
        $games = eGameChoice::model()->recent()->isNotActive()->notdeleted()->multiple()->with('gameChoiceAnswers:isCorrect')->findAll();

        return $games;
    }

    public static function getPeriodWinners() {
        $winners = eGameWinner::model()->notdeleted()->findAll();

        return $winners;
    }

    public static function getActiveGameDesc() {
        $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        if (isset($game)) {
        return $game->description;
        }
    }

    public static function actionGameSMS($phone = NULL) { //TO-DO
        $smssender = eGameChoiceSmsOutbound::model()->findByPk($phone);

        //to-do: check if the given smssender is a current user, registered in our system.
        //If so, send sms, that his answer his recorded, else register the user and send temporary password.
        //Record answer in the game_choice_answer table along with the user_id.

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }


        $user = eUser::model()->findByAttributes(array('username' => $smssender));
        if (isset($user) != NULL) {
            //Send sms that user answer is recorded.
        } else {
            //register user and send temporary password sms. Then record the answer.
        }

        $answers = array('#answer 1', '#answer 2', '#answer 3', '#answer 4');
        if (in_array($gamesms, $answers)) {
            //functionality to record answer is here.
        }
    }

    public static function getNextGame($user_id, $last_game_id) {
        $games = eGameChoice::model()->isActive()->asc()->findAll();
        $flagLastGame = false;
        $next_game_id = 0;

        foreach ($games as $game) {
            if($flagLastGame) {
                $next_game_id = $game->id;
                break;
            }

            if($game->id == $last_game_id) {
                $flagLastGame = true;
            }
        }

        if($next_game_id == 0) {
            $next_game_id = $games[0]->id;
        }

        //user played the last game, there are no more active games
        if($last_game_id == $next_game_id) {
            $next_game_id = 0;
        }

        return $next_game_id;
    }

    public static function getSubGames($main_game_id)
    {
        $games = eGameChoice::model()->isActive()->findAllByAttributes(array('g_parant_id' => $main_game_id));
        return $games;
    }

    public static function getGameResponse($game_id, $user_id)
    {
        $responses = eGameChoiceResponse::model()->findAllByAttributes(array('game_choice_id' => $game_id, 'user_id' => $user_id));

        return $responses;
    }

    public static function getRandomSubGames($id, $user_id)
    {
        $gameIDArray = array();

        //make sure the game id is main game id
        $mainGame = eGameChoice::model()->isActive()->findByPk($id);

        if(is_null(Yii::app()->session['subGameCount'])) {
            Yii::app()->session['subGameCount'] = 1;
        }

        if($mainGame->type != "sub")
        {
            $main_game_id = $mainGame->id;
            Yii::app()->session['subGameCount'] = 1;
        } else {
            $main_game_id = $mainGame->g_parant_id;
            Yii::app()->session['subGameCount'] = Yii::app()->session['subGameCount'] + 1;
        }

        $games = self::getSubGames($main_game_id);

        $mainResponses = self::getGameResponse($main_game_id, $user_id);

        if($games) {
            if(Yii::app()->session['subGameCount'] <= sizeof($games)) {
                foreach($games as $game) {
                    $subResponses = self::getGameResponse($game->id, $user_id);

                    if(sizeof($mainResponses) >= sizeof($subResponses)) {
                        $gameIDArray[] = $game->id;
                    }
                }
            }
        }

        if(sizeof($gameIDArray) == 0) {
            $gameIDArray[] = NULL;
        }

        return $gameIDArray[rand(0,  sizeof($gameIDArray)-1)];
    }

    public static function getAllowedPlays($user_id, $playsPerPay, $startDate, $endDate) {
        $allowedPlays = 0;

        $transactionCount = eTransaction::model()->game()->isResponse()->filterByDates($startDate, $endDate)->countByAttributes(array('user_id' => $user_id));

        for($i=0; $i<$transactionCount; $i++) {
            $allowedPlays = $allowedPlays + $playsPerPay[$i];
        }

        return $allowedPlays;
    }

    public static function getTransactionID($user_id, $startDate, $endDate) {
        $transactions = eTransaction::model()->game()->isResponse()->filterByDates($startDate, $endDate)->recent()->findAllByAttributes(array('user_id' => $user_id));

        if(!empty($transactions)) {
            return $transactions[0]->id;
        }
        else {
             return NULL;
        }
    }

    public static function getPlayerPlays($user_id, $startDate, $endDate) {
        $games = eGameChoice::model()->isActive()->findAll();

        $gameIDArray = array();
        $last_game_id = 0;
        $last_response_id = 0;
        $paidResponseTotal = 0;
        $unpaidResponseTotal = 0;

        foreach ($games as $game) {
            $gameIDArray[] = $game->id;
        }

        $responses = eGameChoiceResponse::model()->filterByDates($startDate, $endDate)->findAllByAttributes(array('game_choice_id' => $gameIDArray, 'user_id' => $user_id));

        foreach ($responses as $response) {
            //check to see if resonse was paid for
            if($response->transaction_id != NULL) {
                $paidResponseTotal++;
            }
            else {
                $unpaidResponseTotal++;
            }

            $last_response_id = $response->id;
            $last_game_id = $response->game_choice_id;
        }

        return array('unpaid_responses' => $unpaidResponseTotal, 'paid_responses' => $paidResponseTotal, 'last_response_id' => $last_response_id, 'last_game_id' => $last_game_id);
    }

    public static function getSetInfo($playsPerPay, $paidResponses, $allowedPlays)
    {
        $onSet = 0;
        $paidResponsesTmp = $paidResponses;

        if($paidResponses != array_sum($playsPerPay)) {
            for($i=0; $i<sizeof($playsPerPay); $i++)
            {
                $paidResponses = $paidResponses - $playsPerPay[$i];

                if($paidResponses < 0) {
                    $onSet = $i+1;
                    $onQ = $paidResponses + $playsPerPay[$i]+1;
                    break;
                }
            }

            $numberInSet = $playsPerPay[$onSet-1];
        }
        else {
            $onSet = 0;
            $onQ = 0;
            $numberInSet = 0;
        }

        Yii::app()->session['game_on_set'] = $onSet;
        Yii::app()->session['game_num_in_set'] = $numberInSet;

        return array('on' => $onSet, 'num' => $numberInSet, 'on_q' => $onQ);
    }

    public static function gameManager($user_id) {
        $playsPerPay = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
        $countdown = 15; //sec
        $isCountdown = false;
        $isPaid = false;

        //'2015-01-01 00:00:00'
        //trailing 24 hours
        //$startDate = date("Y-m-d H:i:s", strtotime("-1 day"));
        //$endDate =  date('Y-m-d H:i:s');

        //reset @ 00:00:00 each day
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $endDate =  date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y")));

        $allowedPlays = self::getAllowedPlays($user_id, $playsPerPay, $startDate, $endDate);
        $userResponse = self::getPlayerPlays($user_id, $startDate, $endDate);
        $transactionID = self::getTransactionID($user_id, $startDate, $endDate);
        $lastGameID = self::getNextGame($user_id, $userResponse['last_game_id']);
        $isPaid = false;
        $setInfo = self::getSetInfo($playsPerPay, $userResponse['paid_responses'], $allowedPlays);

//        if($userResponse['unpaid_responses'] == 1)
//        {
//            $isPaid = false;
//        }
//        else if($userResponse['paid_responses'] == 0 || $userResponse['paid_responses'] < $allowedPlays) {
//            $isPaid = true;
//        }

        if($userResponse['paid_responses'] < $allowedPlays) {
            $isPaid = true;
        }

        //if($userResponse['paid_responses'] == 0) {
            //$isCountdown = false;
        //}

        return array('is_paid' => $isPaid,
                    'user_id' => $user_id,
                    'allowed_plays' => $allowedPlays,
                    'user_response' => $userResponse,
                    'set' => $setInfo,
                    'game_id' => $lastGameID,
                    'transaction_id' => $transactionID,
                    'countdown' => $countdown,
                    'is_countdown' => $isCountdown);
    }

    public static function updateResponseUser($user_id)
    {
        if(!is_null(Yii::app()->session['gamechoiceresponseId'])) {
            $response = eGameChoiceResponse::model()->findByPK(Yii::app()->session['gamechoiceresponseId']);
            $response->user_id = $user_id;

            if($response->validate()) {
                $response->update(array('user_id'));
            }

            return true;
        }
        else {
            return false;
        }
    }

    public static function isDuplicateUserGame($user_id, $game_id)
    {
        //reset @ 00:00:00 each day
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $endDate =  date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y")));

        $responses = eGameChoiceResponse::model()->filterByDates($startDate, $endDate)->findAllByAttributes(array('game_choice_id' => $game_id, 'user_id' => $user_id));

        if(empty($responses)) {
            return false;
        }
        else {
            return true;
        }
    }

    public static function getCashBalance($user_id){

        return self::getTotalUserTransactionBalance($user_id) - self::getTotalUserResponses($user_id);
    }

    public static function getNextTransactionID($user_id) {

        $totalResponses = self::getTotalUserResponses($user_id);
        $nextTransactionID = NULL;

        $transactions = eTransaction::model()->prepay()->isResponse()->findAllByAttributes(array('user_id' => $user_id));

        foreach($transactions as $transaction) {
            $totalResponses = $totalResponses - $transaction->price;

            if($totalResponses < 0) {
                $nextTransactionID = $transaction->id;
                break;
            }
        }

        return $nextTransactionID;
    }

    public static function getTotalUserResponses($user_id) {
//        $totalResponses = 0;
//
//        $games = eGameChoice::model()->findAllByAttributes(array('price' => 1));
//
//        foreach($games as $game) {
//            $totalResponses = $totalResponses + eGameChoiceResponse::model()->countByAttributes(array('game_choice_id' => $game->id, 'user_id' => $user_id));
//        }
        
        $result = Yii::app()->db->createCommand("SELECT COUNT(*) AS total_responses
                FROM game_choice AS G
                RIGHT JOIN game_choice_response AS GR ON GR.game_choice_id = G.id AND GR.user_id = {$user_id}
                WHERE G.price = 1")->queryAll();

        return $result[0]['total_responses'];
    }

    public static function getTotalUserTransactionBalance($user_id) {
        $transactionBalance = 0;

        $transactions = eTransaction::model()->prepay()->isResponse()->findAllByAttributes(array('user_id' => $user_id));

        foreach($transactions as $transaction) {
            $transactionBalance = $transactionBalance + $transaction->price;
        }

        return $transactionBalance;
    }

    public static function managerPayPlay($user_id) {
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $endDate =  date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d"), date("Y")));

        $manageGameID = NULL;
        $manageIsPayed = false;
        $manageTransactionID = NULL;
        $manageTransactionNum = 0;
        $isCountdown = false;

        //get all active games
        $games = eGameChoice::model()->isActive()->findAll();

        foreach($games as $game) {
            $userResponse = eGameChoiceResponse::model()->filterByDates($startDate, $endDate)->findAllByAttributes(array('game_choice_id' => $game->id, 'user_id' => $user_id));

            if(empty($userResponse)) {
                $manageGameID = $game->id;
                break;
            }
        }

        if($manageGameID == NULL) {
            $manageGameID = 0;
        }

        $transaction = eTransaction::model()->gameChoice()->isResponse()->filterByDates($startDate, $endDate)->findAllByAttributes(array('user_id' => $user_id, 'item_id' => $manageGameID));

        if(!empty($transaction)) {
            $manageIsPayed = true;
            $manageTransactionID = $transaction[0]->id;
            $manageTransactionNum = sizeof($transaction);
        }

        return array("game_id" => $manageGameID,
                    "is_payed" => $manageIsPayed,
                    "transaction_id" => $manageTransactionID,
                    "transaction_num" => $manageTransactionNum,
                    "is_countdown" => $isCountdown
                );

    }

    public static function revealGetGrid($grid_id) {
        if (isset($grid_id)) {
            $revealGrid = eGameRevealGrid::model()->orderByUpdatedAsc()->findAllByAttributes(array('reveal_id' => $grid_id));
            if ($revealGrid) {
                $rows = array();

                foreach ($revealGrid as $grid) {
                    $rows[] = $grid->attributes;
                }

                return $rows;
            }
        }
    }

    public static function revealGetInfo($grid_id, $transaction_num = 1) {
        $numShown = 1;
        $numToShowUser = 4;

        if($grid_id == 3) {
            $numToShowAuto = ($transaction_num*4)+4;
        } else {
            $numToShowAuto = $transaction_num*4;
        }

        return array("num_shown" => $numShown,
                     "num_to_show_auto" => $numToShowAuto,
                     "num_to_show_user" => $numToShowUser);
    }

    public static function getCurrentMultipleChoiceGame($games) {

        $currentMultipleChoiceGame['url'] = "#";
        $currentMultipleChoiceGame['message'] = "";
        $currentMultipleChoiceGame['close_date'] = "";
        $currentMultipleChoiceGame['id'] = NULL;
        $currentMultipleChoiceGame['totnum_plays'] = NULL;
        $currentMultipleChoiceGame['price'] = "";
        $currentMultipleChoiceGame['prize'] = "";

        foreach($games as $game) {
            if(date('U') > strtotime($game->open_date) && date('U') < strtotime($game->close_date)) {
                if(sizeof($game->gameChoiceAnswers) != 5) {
                    $currentMultipleChoiceGame['url'] = '/multiplechoice/'.$game->id;
                    $currentMultipleChoiceGame['message'] = "Get Started";
                    $currentMultipleChoiceGame['close_date'] = $game->close_date;
                    $currentMultipleChoiceGame['id'] = $game->id;
                    $currentMultipleChoiceGame['totnum_plays'] = $game->num_plays_free + $game->num_plays_paid;
                    $currentMultipleChoiceGame['price'] = $game->price;
                    $currentMultipleChoiceGame['prize'] = $game->prize;
                    break;
                }
            }
        }

        return $currentMultipleChoiceGame;
    }

    public static function getCurrentWinLooseOrDrawGame($games) {

        $currentWinLooseOrDrawGame['url'] = "#";
        $currentWinLooseOrDrawGame['message'] = "";
        $currentWinLooseOrDrawGame['disabled'] = "";
        $currentWinLooseOrDrawGame['close_date'] = "";
        $currentWinLooseOrDrawGame['totnum_plays'] = NULL;
        $currentWinLooseOrDrawGame['price'] = "";
        $currentWinLooseOrDrawGame['prize'] = "";
        $currentWinLooseOrDrawGame['desrciption'] = "";

        //$geoLocation = GeoUtility::GeoLocation();

        foreach($games as $game) {
            if(date('U') > strtotime($game->open_date) && date('U') < strtotime($game->close_date)) {
                if(sizeof($game->gameChoiceAnswers) == 5) {

                    if(date('U') < strtotime($game->close_date)) {
                        $currentWinLooseOrDrawGame['url'] = "/winlooseordraw/".$game->id;
                        $currentWinLooseOrDrawGame['message'] = "Get Started";
                    } else {
                        $currentWinLooseOrDrawGame['url'] = "/winlooseordraw/".$game->id;
                        $currentWinLooseOrDrawGame['message'] = "Get Started";
                        $currentWinLooseOrDrawGame['disabled'] = "disabled";
                    }

                    $currentWinLooseOrDrawGame['close_date'] = $game->close_date;
                    $currentWinLooseOrDrawGame['description'] = $game->description;
                    $currentWinLooseOrDrawGame['totnum_plays'] = $game->num_plays_free + $game->num_plays_paid;;
                    $currentWinLooseOrDrawGame['price'] = $game->price;
                    $currentWinLooseOrDrawGame['prize'] = $game->prize;

//                    if(!$geoLocation['isValid']) {
//                        if($game->price > 0) {
//                            $currentWinLooseOrDrawGame['message'] = "Not Eligible";
//                            $currentWinLooseOrDrawGame['disabled'] = "disabled";
//                        }
//                    }

                    break;
                }
            }
        }

        return $currentWinLooseOrDrawGame;
    }

    public static function getAllDisplayedGames($games) {
        $allDisplayedGames = Array();
        //$geoLocation = GeoUtility::GeoLocation();
        $isCashBalance = true;
        $isGuestTrue = Yii::app()->user->isGuest;
        
        if(!$isGuestTrue)
        {
            if(self::getCashBalance(Yii::app()->user->getId()) <= 0) {
                $isCashBalance = false;
            }
        }

        foreach($games as $game)
        {
            $id = $game->id;
            $allDisplayedGames[$id]['url'] = "#";
            $allDisplayedGames[$id]['message'] = "";
            $allDisplayedGames[$id]['disabled'] = "";
            $allDisplayedGames[$id]['close_date'] = "";
            $allDisplayedGames[$id]['is_show'] = true;

            if(date('U') > strtotime($game->open_date) && date('U') < strtotime($game->close_date))
            {

                $allDisplayedGames[$id]['message'] = "Play Now";

                if($game->reveal_id != NULL)
                {
                    $allDisplayedGames[$id]['url'] = '/game/reveal/'.$game->id;
                }
                else if(sizeof($game->gameChoiceAnswers) == 5)
                {
                    if(!$isGuestTrue)
                    {
                        if(!$isCashBalance)
                        {
                            $allDisplayedGames[$id]['message'] = "Add Funds";
                            $allDisplayedGames[$id]['url'] = '/winlooseordraw/'.$game->id;
                        }
                        else
                        {
                            $allDisplayedGames[$id]['url'] = '/winlooseordraw/'.$game->id;
                        }

                        //if($geoLocation['isExists'])
                        //{
//                            if(!$geoLocation['isShared'])
//                            {
//                                if($game->price > 0)
//                                {
//                                    $allDisplayedGames[$id]['message'] = "Share Location";
//                                    $allDisplayedGames[$id]['url'] = '/geocoordinates';
//                                }
//                            }
                            //else
//                            if(!$geoLocation['isValid'])
//                            {
//                                if($game->price > 0)
//                                {
//                                    $allDisplayedGames[$id]['message'] = "Not Eligible";
//                                    $allDisplayedGames[$id]['disabled'] = "disabled";
//                                }
//                            }
                        //}
                    }
                    else
                    {
                        $allDisplayedGames[$id]['url'] = '/winlooseordraw/'.$game->id;
                    }

                }
                else
                {
                    $allDisplayedGames[$id]['url'] = '/multiplechoice/'.$game->id;
                }

            }
            else if(date('U') < strtotime($game->open_date))
            {
                $allDisplayedGames[$id]['message'] = "Opening Soon";
                $allDisplayedGames[$id]['disabled'] = "disabled";
            }
            else
            {
                $allDisplayedGames[$id]['message'] = "Game Closed";
                $allDisplayedGames[$id]['disabled'] = "disabled";
                $allDisplayedGames[$id]['is_show'] = false;
            }

            $allDisplayedGames[$id]['close_date'] = $game->close_date;

            if($allDisplayedGames[$id]['disabled'])
            {
                $allDisplayedGames[$id]['url'] = "#";
            }
        }

        return $allDisplayedGames;
    }

    public static function redirectToGame($that, $id) {

        if(isset($id)) {

            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);

            if($game)
            {
                if($game->reveal_id != NULL) {
                    $playButtonURL = '/game/reveal/'.$game->id;
                } else if(sizeof($game->gameChoiceAnswers) == 5) {
                    $playButtonURL = '/winlooseordraw/'.$game->id;
                } else {
                    $playButtonURL = '/multiplechoice/'.$game->id;
                }

                $that->redirect($that->createUrl($playButtonURL));
            }
        }
    }

    public static function writeToFile($df, $responces) {
        foreach ($responces as $r) {
            //$geoIp->locate($r->ip_address);var_dump($geoIp);exit;
            //$ipInfo = ClientUtility::getIPInfo($r->ip_address);

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

            $creditsTransaction = eCreditTransaction::model()->findByAttributes(array('trans_id' => $r->id));

            if (empty($creditsTransaction)) {
                $sum = 0;
                $total_plays = 0;
            } else {
                $criteria = New CDbCriteria;
                $criteria->select = ' SUM(t.credits) as sum, count(user_id) as total_plays';
                $criteria->condition = 'id <= :id and user_id = :user_id';
                $criteria->params = array(':id' => $creditsTransaction->id, ':user_id' => $r->user_id);
                $credit = eCreditTransaction::model()->earned()->findAll($criteria);
                $sum = $credit[0]->sum;
                $total_plays = $credit[0]->total_plays;
            }

            $geoLocation = eGeoLocationInfo::model()->findByAttributes(array('ip_address' => $r->ip_address));

            if (!empty($geoLocation)) {
                $city = $geoLocation->city;
                $state = $geoLocation->state;
            } else {
                $city = 'unknown';
                $state = 'unknown';
            }

            // if (!empty($ipInfo->city)) {
            //    $ipbasedcity = $ipInfo->city;
            // }
            //  else {
            //     $ipbasedcity = 'unknown';
            //  }

            $row = array($r->user_id, $r->user->username, $r->game_choice_id, $userInput, $userInputValidInvalid, $paymentType, $isCorrect, $r->is_winner, $r->source, $sum, $total_plays, $r->ip_address, $city, $state,$r->ip_derivedcity, $r->ip_derivedstate, $r->created_on); //var_dump($row);
            fputcsv($df, $row);
        }
    }
}
