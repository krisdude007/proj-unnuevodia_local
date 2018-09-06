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
    public static function topUsersPoints($top = 10)
    {
        //will need to convert to yii
        $result = Yii::app()->db->createCommand("SELECT SUM(A.point_value) AS total, R.user_id "
                . "FROM game_choice_answer AS A "
                . "RIGHT JOIN game_choice_response AS R ON R.game_choice_answer_id=A.id "
                . "GROUP BY R.user_id "
                . "ORDER BY total DESC LIMIT $top")->queryAll();

        $totals = array();
        $i = 0;
        foreach($result as $r)
        {
            $totals[$i]['id'] = $r['user_id'];
            $totals[$i]['total'] = $r['total'];
            $i++;
        }

        return $totals;
    }

    public static function pickWinnerRand($old_is_active, $new_is_active, $game_id) {

        if($old_is_active == 1 && $new_is_active == 0) {
            $answers = eGameChoiceAnswer::model()->with('gameChoiceResponse')->findByAttributes(array('game_choice_id' => $game_id, 'is_correct' => 1));

            if($answers != NULL && sizeof($answers->gameChoiceResponse) >= 1) //make sure there is a correct response
            {
                //get random response
                $response_id = $answers->gameChoiceResponse[rand(0,sizeof($answers->gameChoiceResponse)-1)]->id;

                $response = eGameChoiceResponse::model()->findByPK($response_id);
                $response->is_winner = 1;
                $response->save();
            }
        }
    }

    public static function getWinners()
    {
        //$games = eGameChoiceAnswer::model()->isCorrect()->with('gameChoiceResponse:isWinner')->findAll();
        //$games = eGameChoice::model()->isNotActive()->multiple()->with('gameChoiceAnswers:isCorrect')->findAll();

        /*
        $criteria = new CDbCriteria();
        $criteria->select = 't.*, a.*, r.*';
        $criteria->join = ' LEFT JOIN game_choice_answer AS a ON t.id = a.game_choice_id'
                        . ' RIGHT JOIN game_choice_response AS r ON a.id = r.game_choice_answer_id';
        $criteria->addCondition("a.is_correct = 1 AND is_winner = 1");
        $criteria->order = "t.created_on DESC";
        */

        $with = array('eGameChoiceResponse:isWinner', 'eGameChoiceAnswers:isCorrect');
        $games = eGameChoice::model()->with()->recent()->isNotActive()->multiple()->findAll();

        return $games;
    }

    public static function getActiveGameDesc()
    {
        $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();

        return $game->description;
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
}
