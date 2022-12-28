<?php

namespace App\Repositories;


abstract class CoreRepository
{
    protected $model;

    abstract public function getModelClass();

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    public function startConditions()
    {
        return clone $this->model;
    }

    public function getModelForAttributes(array $attributes)
    {
        $model = $this->startConditions();

        foreach ($attributes as $key => $value) {
            $model = $model->where($key, $value);
        }

        return $model->first();
    }
}
