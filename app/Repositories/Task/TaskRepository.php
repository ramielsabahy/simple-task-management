<?php

namespace App\Repositories\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    protected $model;

    public function __construct(Task $task)
    {
        $this->model = $task;
    }


    /**
     * @return mixed
     */
    public function all($request)
    {
        return $this->model->owner()->search()->filter()->get();
    }

    /**
     * @return Task|null
     */
    public function find($id): Task|null
    {
        return $this->model->owner()->find($id);
    }

    /**
     * @param array $attributes
     * @return Task
     */
    public function create(array $attributes): Task
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->model->owner()->where(['id' => $id])->update($attributes);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool|null
    {
        return $this->model->owner()->where(['id' => $id])->delete();
    }
}
