<?php

namespace App\Http\Services;

use App\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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
        $query = $this->model->select('*');

        if(!empty($data['name']))
            $query->where('name', $data['name']);

        return $query->get();
    }
}
