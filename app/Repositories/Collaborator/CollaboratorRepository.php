<?php

namespace App\Repositories\Collaborator;

use App\Models\Collaboration;
use Illuminate\Database\Eloquent\Collection;

class CollaboratorRepository implements CollaboratorRepositoryInterface
{
    protected $model;

    public function __construct(Collaboration $collaboration)
    {
        $this->model = $collaboration;
    }
    /**
     * @param array $attributes
     * @return Collaboration
     */
    public function create(array $attributes): Collaboration
    {
        return $this->model->firstOrCreate($attributes);
    }
}
