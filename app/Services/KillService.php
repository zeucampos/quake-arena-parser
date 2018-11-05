<?php

namespace App\Http\Services;

use App\Kill;

class KillService {

    protected $model;

    public function __construct(Kill $model) {
        $this->model = $model;
    }

    public function store($data) {
        Transaction()->begin($this->model);
        try {
            $result = $this->model->create($data);
        } catch (\Exception $e) {
            Transaction()->rollback();
            throw $e;
        }
        Transaction()->commit();

        return $result;
    }
}
