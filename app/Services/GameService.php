<?php

namespace App\Http\Services;

use App\Game;
use Illuminate\Support\Facades\Request;

class GameService {

    protected $model;

    public function __construct(Game $model) {
        $this->model = $model;
    }

    public function store(Request $request) {
        Transaction()->begin($this->model);
        try {
            $result = $this->model->create($request->all());
        } catch (\Exception $e) {
            Transaction()->rollback();
            throw $e;
        }
        Transaction()->commit();

        return $result;
    }
}
