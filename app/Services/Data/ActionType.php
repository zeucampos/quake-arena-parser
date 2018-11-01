<?php

namespace App\Services\Data;

class ActionType {
    const KILL = 'Kill';
    const START = 'Kill';
    const END = 'Kill';
    const DISCONNECT_CLIENT = 'Kill';

    private $resultObject;
    private $gameIndex;

    public $data = [
        'Kill' => ['name' => 'morte', 'exec' => 'countKill'],
        'Kill' => ['name' => 'morte', 'exec' => 'countKill'],
        'Kill' => ['name' => 'morte', 'exec' => 'countKill'],
        'Kill' => ['name' => 'morte', 'exec' => 'countKill'],
        'InitGame' => ['exec' => 'newGame'],
        'ShutdownGame' => ['exec' => 'endGame']
    ];

    public function __construct()
    {
        $this->resultObject = [];
        $this->gameIndex = 0;
    }

    public function performAction($actionRaw, $obj, $rawLine)
    {
        if(isset($this->data[$actionRaw])){
            $action = $this->data[$actionRaw]['exec'];
            call_user_func_array([$this,$action], [$obj, $rawLine]);
        }
    }

    public function newGame()
    {
        $init = [
            'total_kills' => 0,
            'players' => [],
            'kills' => []
        ];
        array_push($this->resultObject, $init);

    }
    public function endGame()
    {
        $this->gameIndex++;
    }

    public function getResult()
    {
        return $this->resultObject;
    }

    public function countKill($obj, $rawLine)
    {
        // SE FOR MORTDE DO MUNDO //
        if(strpos($rawLine, '1022'))
            $this->setWorldKillName($rawLine);
        else
            $this->setDefaultKillName($rawLine);

        $this->resultObject[$this->gameIndex]['total_kills']++;
    }

    private function setDefaultKillName($rawLine)
    {
        $init = strrpos($rawLine, ':') + 2;
        $filter = substr($rawLine,$init, strlen($rawLine));
        $parts = explode('killed', $filter);
        $playerName = str_replace(' ','',$parts[0]);

        $this->setPlayers($playerName);

        if(!isset($this->resultObject[$this->gameIndex]['kills'][$playerName])){
            $this->resultObject[$this->gameIndex]['kills'][$playerName] = 1;
        }else{
            $this->resultObject[$this->gameIndex]['kills'][$playerName]++;
        }
    }

    private function setWorldKillName($rawLine)
    {
        $init = strpos($rawLine, 'killed');
        $filter = substr($rawLine,$init, strlen($rawLine));
        $parts = explode('by', $filter);
        $playerName = str_replace(' ', '', str_replace('killed', '', $parts[0]));

        $this->setPlayers($playerName);

        if(!isset($this->resultObject[$this->gameIndex]['kills'][$playerName])){
            $this->resultObject[$this->gameIndex]['kills'][$playerName] = -1;
        }else{
            $this->resultObject[$this->gameIndex]['kills'][$playerName]--;
        }
    }

    private function setPlayers($playerName)
    {
        if(!in_array($playerName, $this->resultObject[$this->gameIndex]['players'])){
            array_push($this->resultObject[$this->gameIndex]['players'], $playerName);
        }
    }
}
