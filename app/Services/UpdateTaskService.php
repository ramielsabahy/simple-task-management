<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class UpdateTaskService
{
    /**
     * @param TaskRepository $repository
     */
    public function __construct(protected TaskRepository $repository)
    {
    }


    /**
     * @param $task
     * @return Task
     */
    public function update($id,$task) : bool
    {
        return $this->repository->update($id,$task);
    }
}
