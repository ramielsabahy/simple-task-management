<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class StoreTaskService
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
    public function store($task) : Task
    {
        $task['user_id'] = request()->user()->id;
        return $this->repository->create($task);
    }
}
