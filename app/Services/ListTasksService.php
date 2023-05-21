<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class ListTasksService
{
    /**
     * @param TaskRepository $repository
     */
    public function __construct(protected TaskRepository $repository)
    {
    }

    public function all($request)
    {
        return $this->repository->all($request);
    }
}
