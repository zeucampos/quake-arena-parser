<?php

namespace App\Http\Services;

use App\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Kill;

class PlayerService
{

    protected $model;

    public function __construct(Player $model)
    {
        $this->model = $model;
    }

    public function store($name)
    {
        Transaction()->begin($this->model);
        try {
            $player = $this->model->where(['name' => $name])->first();
            $data['name'] = $name;

            if (empty($player))
                $player = $this->model->create($data);

        } catch (\Exception $e) {
            Transaction()->rollback();
            throw $e;
        }
        Transaction()->commit();

        return $player;
    }

    public function index($data)
    {
        $query = Player::with(['kills' => function ($query) {
            $query->select(['killer', DB::raw('SUM(score) AS kills')]);
            $query->groupBy(['killer']);
        }])->with(['deads' => function ($query){
            $query->select(['dead', DB::raw('SUM(score) AS deads')]);
            $query->groupBy(['dead']);
        }]);

        if(isset($data['name']))
            $query->where('name', 'LIKE', '%'. $data['name'] .'%');

        $players = $query->get();

        $players->map(function($item, $key)  {
            $item->score = $item->kills->first()->kills + $item->deads->first()->deads;
            return $item;
        });

        return $players->sortByDesc('score');
    }
}
