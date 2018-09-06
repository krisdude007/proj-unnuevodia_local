<?php

class tickerStreamCommand extends CConsoleCommand {
    public function run($args){
        $destinations = Array('web','mobile','tv');      
        $runs = eTickerRun::model()->shouldRun()->findAll();
        while(!is_null($runs)){
            foreach($destinations as $destination){
                $ticker = eTickerRun::model()->findByAttributes(Array('stopped'=>0),Array('condition'=>"{$destination}_runs > {$destination}_ran",'order'=>'t.updated_on ASC','group'=>'ticker_id'));                    
                if(!is_null($ticker)){
                    self::insertIntoQueue($ticker, $destination);
                }
            }                    
            sleep(Yii::app()->params['ticker']['sleepTime']);
            $runs = eTickerRun::model()->shouldRun()->findAll();            
        }
    }   
    
    private static function insertIntoQueue($ticker,$destination){
        $stream = new eTickerStream;
        $stream->ticker_id = $ticker->ticker_id;
        $stream->destination = $destination;
        $stream->save();                
        $ticker->{"{$destination}_ran"}  = ++$ticker->{"{$destination}_ran"} ;
        $ticker->save();        
    }
}

?>
