<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class DeleteTaskService
{
    /**
     * @param TaskRepository $repository
     */
    public function __construct(protected TaskRepository $repository)
    {
    }


    /**
     * @param $id
     */
    public function destroy($id) : bool
    {
        return $this->repository->delete($id);
    }
}
