<?php

/*
 * The MIT License
 *
 * Copyright 2014 pheadington.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace OnyxPrize\Service;

/**
 * Description of PrizePicker
 *
 * @author pheadington
 */
class PrizePicker {
    
    protected $prizePickerTable;
    private $serviceManager;
    private $userModelTable;
    private $user = array(
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    );
    private $activePrizes = array();
    
    public function __construct($sm)
    {
        $this->serviceManager = $sm;
        $this->getActivePrizes();
        $this->arePrizesSet();
    }
    
    public function setUserModel($model){
        $this->userModelTable = $model;
    }

    public function pickWinner($firstName, $lastName, $email){
        $this->user['first_name'] = $firstName;
        $this->user['last_name'] = $lastName;
        $this->user['email'] = $email;
        if($this->isPastWinner()){
            return 0;
        }
        return $this->checkPrizePick();
    }
    
    private function checkPrizePick(){
        $check = $this->getPrizePickTable()->isThereAPrizeForMe();
        return $check->getAffectedRows();
    }
    
    private function isPastWinner(){
        
        //todo add check to win period from settings
        $modelTable = $this->serviceManager->get($this->userModelTable);
        if($modelTable->winnerByEmail($this->user['email']) === false){
            return false;
        }   
        return true;
    }
    
    private function arePrizesSet(){
        foreach($this->activePrizes as $prize){
            if($this->getPrizePickTable()->checkIfTodayPicked($prize->id)){
            }else{
                $this->setTodaysPrizes($prize);
            }
        }
    }
    
    private function setTodaysPrizes($prize){
        $prizeInHour = array();
        //echo "today: ".date('Y-m-d').PHP_EOL;
        //echo "end: ".$prize->end_date.PHP_EOL;
        $daysToGo = $this->dateDifferenceDays(date('Y-m-d'), $prize->end_date . "23:59:59");
        //echo "days: ".$daysToGo.PHP_EOL;
        $perday = round($prize->current / $daysToGo);
        //echo "per day: ".$perday.PHP_EOL;
        
        $hourWeight = json_decode($prize->hour_weight);
        $sum = 0;
        
        foreach($hourWeight as $hour){
            $sum+=$hour->value;
        }
        $weightValue = round($perday/$sum ,3);
        //echo "per day weightValue: ".$weightValue.PHP_EOL;
        $checkSum = 0;
        
        foreach($hourWeight as $hour){
            $prizeInHour[$hour->time] = round($weightValue * $hour->value);
            $checkSum+=$prizeInHour[$hour->time];
        }
        
        //var_dump($prizeInHour);
        
        //echo "checksum: ".$checkSum;
        
        foreach ($prizeInHour as $hour => $number){
            $hour = $hour / 100;
            for($i = 0; $i < $number; $i++){
                $mins = rand(1, 55);
                $prizePick = $this->serviceManager->get('OnyxPrizePick');
                $prizePick->id = null;
                $prizePick->claimed = 0;
                $prizePick->onyx_prize_id = $prize->id;
                $prizePick->win_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d " . $hour . ":" . $mins .":00")));
                //echo "save prize " .$prizePick->win_time.PHP_EOL;
                $this->getPrizePickTable()->save($prizePick);
            }
        }
        //exit();
        
    }
    
    private function dateDifferenceDays($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
      }


    private function getActivePrizes(){
        $OnyxPrizeTable = $this->serviceManager->get('OnyxPrizeTable');
        $this->activePrizes = $OnyxPrizeTable->getAllActive();
        
    }
    
    public function getPrizePickTable(){
        if (!$this->prizePickerTable) {
            $this->prizePickerTable = $this->serviceManager->get('OnyxPrizePickTable');
        }
        return $this->prizePickerTable;
    }
    
}
