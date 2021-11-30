<?php

namespace App\Repositories\Implementations\Eloquent;

class BaseRepository
{
    public object $model;

    protected function __construct(object $model)
    {
        $this->model = $model;
    }

    public function all(): object
    {
        return $this->model->all();
    }

    public function find(int $id): object
    {
        return $this->model->find($id);
    }

    public function findByColumn(string $column, $value): object
    {
        return $this->model->where($column, $value)->get();
    }

    public function save(array $attributes): object
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    public function findOneByColumn(string $column, $value): object
    {
        return $this->model->where($column, $value)->get()->first();
    }
}
