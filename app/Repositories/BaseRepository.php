<?php

namespace App\Repositories;

abstract class BaseRepository {

    protected $model;

    public function getNumber() {
        $total = $this->model->count();
        $new = $this->model->whereSeen(0)->count();
        return compact('total', 'new');
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

    public function getById($id) {
        return $this->model->findOrFail($id);
    }

}
