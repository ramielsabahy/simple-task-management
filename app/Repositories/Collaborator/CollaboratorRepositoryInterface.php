<?php

namespace App\Repositories\Collaborator;

use App\Models\Collaboration;

interface CollaboratorRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Collaboration
     */
    public function create(array $attributes) : Collaboration;

}
