
<style>
    html {
        font-family: Arial, Helvetica, sans-serif;
    }
    
    body {
        
    }
    
    .main {
        position: relative;
        margin-left: auto;
        margin-right: auto;
        width: 70%;
    }
    
    table {
        border-collapse: collapse;
        font-size: 10pt;
        width: 100%;
    }
    
    table, th, td {
        border: 1px solid #CCC;
    }
    
    table th {
        background-color: #C9DAF8;
    }
    
    table .odd {
        background-color: #FFFFFF;
    }
    
    table .even {
        background-color: #EEEEEE;
    }
    
    table .correct td {
        background-color: #93C47D;
    }
</style>

<html>
    <body>
    <div class="main">
    <h2>Play History - Game ID #<?php echo $game->id." - ".$game->question; ?></h2>
    <h3><?php echo "Start Date: ".$game->start_date." ".date_default_timezone_get() ?></h3>
    <h3><?php echo "End Date: "; if($game->is_active){echo "Still Active";}else{echo $game->end_date." ".date_default_timezone_get();} ?></h3>
    
    <table>
        <thead>
            <tr>
                <th>Label</th>
                <th>Answer</th>
                <th>Paid Responses</th>
                <th>Non-Paid Responses</th>
            </tr>
        </thead>
        <?php
        foreach($game->gameChoiceAnswers as $answer)
        {
            if($answer->is_correct) {
                $style = 'class="correct"';
            } else {
                $style = '';
            }
            
            echo "<tr ".$style.">";
            echo "<td>".$answer->label."</td>";
            echo "<td>".$answer->answer."</td>";
            echo "<td>".$answer->responses_paid."</td>";
            echo "<td>".$answer->responses_free."</td>";
            echo "</tr>";
        }
        ?>
        <tr></tr>
    </table>
    
    <h3>Game Statistics</h3>
    
    <table>
        <thead>
            <tr>
                <th>Paid Plays</th>
                <th>Non-Paid Plays</th>
                <th>Paid Unique Users</th>
                <th>Non-Paid Unique Users</th>
                <th>Registered Users</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <?php
            echo "<tr>";
            echo "<td>".$game->num_plays_paid."</td>";
            echo "<td>".$game->num_plays_free."</td>";
            echo "<td>".$game->num_users_paid."</td>";
            echo "<td>".$game->num_users_free."</td>";
            echo "<td>".$registered."</td>";
            echo "<td>".$game->spent."</td>";
            echo "</tr>";
        ?>
        <tr></tr>
    </table>
    <br/>
    <table>
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
        <?php
            $totalPlays = $game->num_plays_sms_paid + $game->num_plays_ivr_paid + $game->num_plays_web_paid + $game->num_plays_web_free + $game->num_plays_free_anonymous;
            echo "<tr>";
            echo "<td>".$totalPlays."</td>";
            echo "<td>".$game->num_plays_sms_paid."</td>";
            echo "<td>".$game->num_plays_ivr_paid."</td>";
            echo "<td>".$game->num_plays_web_paid."</td>";
            echo "<td>".$game->num_plays_web_free."</td>";
            echo "<td>".$game->num_plays_free_anonymous."</td>";
            echo "</tr>";
        ?>
        <tr></tr>
    </table>
    
    <h3>Plays Breakdown</h3>
    
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>User Email</th>
                <th>User Input</th>
                <th>Input Valid/Invalid</th>
                <th>Payment Type</th>
                <th>Correct</th>
                <th>Winner</th>
                <th>Source</th>
                <th>Date</th>
            </tr>
        </thead>
<?php

foreach($responces as $responce)
{
    if($responce->gameChoiceSmsOutbound) {
        $userInput = $responce->gameChoiceSmsOutbound->smstext;
    } else {
        if($responce->gameChoiceAnswer) {
            $userInput = $responce->gameChoiceAnswer->label;
        }
        else {
            $userInput = 'n/a';
        }
    }
    
    if($responce->gameChoiceAnswer) {
        if($responce->gameChoiceAnswer->label == '#') {
            $userInputValidInvalid = 'Invalid';
        } else {
            $userInputValidInvalid = 'Valid';
        }
        
        $isCorrect = $responce->gameChoiceAnswer->is_correct;
    }
    else {
        $userInputValidInvalid = 'n/a';
        $isCorrect = 'n/a';
    }
    
    if($responce->sms_id == NULL && $responce->transaction_id == NULL) {
        $paymentType = 'non-paid';
    }
    else {
        $paymentType = 'paid';
    }
    
    echo "<tr>";
    
    echo "<td>".$responce->user_id."</td>";
    echo "<td>".$responce->user->username."</td>";
    echo "<td></td>";
    echo "<td style=\"max-width:150px; text-overflow: ellipsis;\">".$userInput."</td>";
    echo "<td>".$userInputValidInvalid."</td>";
    echo "<td>".$paymentType."</td>";
    echo "<td>".$isCorrect."</td>";
    echo "<td>".$responce->is_winner."</td>";
    echo "<td>".$responce->source."</td>";
    echo "<td>".$responce->created_on."</td>";
    
    echo "</tr>";
}
?>

    </table>
    </div>
    </body>
</html>