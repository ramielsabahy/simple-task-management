<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class TaskDetailsService
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
    public function find($id) : Task|null
    {
        return $this->repository->find($id);
    }
}
