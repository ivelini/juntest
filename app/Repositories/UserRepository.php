<?php


namespace App\Repositories;

use App\Models\User as Model;


class UserRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

}
