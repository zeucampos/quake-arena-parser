<?php

namespace App\Services\Data;

use App\Http\Services\GameService;
use App\Http\Services\KillService;
use App\Http\Services\PlayerService;
use App\Game;


class ActionType
{

    protected $gameService;
    protected $playerService;
    protected $killService;

    private $resultObject;
    private $gameIndex;
    private $gameName;

    public $debug = false;

    public $actions = [
        'Kill' => ['exec' => 'countKill'],
        'InitGame' => ['exec' => 'newGame'],
        'ShutdownGame' => ['exec' => 'endGame']
    ];

    public function __construct(GameService $gameService, KillService $killService, PlayerService $playerService)
    {
        $this->gameService = $gameService;
        $this->killService = $killService;
        $this->playerService = $playerService;

        $this->resultObject = [];
        $this->gameIndex = 0;
    }

    public function performAction($actionRaw, $obj, $rawLine)
    {
        if (isset($this->actions[$actionRaw])) {
            $action = $this->actions[$actionRaw]['exec'];
            call_user_func_array([$this, $action], [$obj, $rawLine]);
        }
    }

    public function newGame()
    {
        $init = [
            'id' => 0,
            'total_kills' => 0,
            'players' => [],
            'kills' => [],
            'kills_by_means' => []
        ];
        array_push($this->resultObject, $init);
    }

    public function endGame()
    {
        $this->resultObject[$this->gameIndex]['id'] = $this->gameIndex;

        $this->gameService->store($this->resultObject[$this->gameIndex]);

        $this->gameIndex++;
    }

    public function getResult()
    {
        return $this->resultObject;
    }

    public function countKill($obj, $rawLine)
    {
        // SE FOR MORTDE DO MUNDO //
        if (strpos($rawLine, '1022'))
            $this->setWorldKillName($rawLine);
        else
            $this->setDefaultKillName($rawLine);

        $this->resultObject[$this->gameIndex]['total_kills']++;
    }

    private function setDefaultKillName($rawLine)
    {
        $init = strrpos($rawLine, ':') + 2;
        $filter = substr($rawLine, $init, strlen($rawLine));
        $parts = explode('killed', $filter);
        $kill = explode('by', $parts[1]);

        $this->clearSpaces($parts);
        $this->clearSpaces($kill);

        $final['game_id'] = $this->gameIndex;
        $final['killer'] = $parts[0];
        $final['score'] = 1;

        $type = str_replace(["\n", "\r"], "", $kill[1]);

        $playerName = $final['killer'];

        $this->setPlayers($playerName);
        $this->killByMean($type);

        $final['type'] = 'O player ' . $final['killer'] . ' matou ' . $kill[0] . ' ' . MeansDeath::$dictionary[$type];

        if (!isset($this->resultObject[$this->gameIndex]['kills'][$playerName])) {
            $this->resultObject[$this->gameIndex]['kills'][$playerName] = 1;
        } else {
            $this->resultObject[$this->gameIndex]['kills'][$playerName]++;
        }

        $this->killService->store($final);
    }

    private function killByMean($kill)
    {
        if (!isset($this->resultObject[$this->gameIndex]['kills_by_means'][$kill])) {
            $this->resultObject[$this->gameIndex]['kills_by_means'][$kill] = 1;
        } else {
            $this->resultObject[$this->gameIndex]['kills_by_means'][$kill]++;
        }
    }

    private function setWorldKillName($rawLine)
    {
        $init = strpos($rawLine, 'killed') + 6;
        $filter = substr($rawLine, $init, strlen($rawLine));
        $parts = explode('by', $filter);

        $this->clearSpaces($parts);

        $playerName = $parts[0];

        $final['game_id'] = $this->gameIndex;
        $final['killer'] = 1022;
        $final['dead'] = $parts[0];
        $final['score'] = -1;

        $type = str_replace(["\n", "\r"], "", $parts[1]);

        $final['type'] = 'O player ' . $final['dead'] . ' morreu ' . MeansDeath::$dictionary[$type];

        $this->setPlayers($playerName);
        $this->killByMean($type);

        if (!isset($this->resultObject[$this->gameIndex]['kills'][$playerName])) {
            $this->resultObject[$this->gameIndex]['kills'][$playerName] = -1;
        } else {
            $this->resultObject[$this->gameIndex]['kills'][$playerName]--;
        }

        $this->killService->store($final);
    }

    private function clearSpaces(&$item)
    {
        foreach ($item as $key => $value) {
            $item[$key] = str_replace(' ', '', $item[$key]);
        }
    }

    private function setPlayers($playerName)
    {
        if (!in_array($playerName, $this->resultObject[$this->gameIndex]['players'])) {
            array_push($this->resultObject[$this->gameIndex]['players'], $playerName);
        }

        $this->playerService->store($playerName);
    }
}
