<?php

namespace App\Repositories\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all($request);


    /**
     * @param $id
     * @return Task|null
     */
    public function find($id) : Task|null;

    /**
     * @param array $attributes
     * @return Task
     */
    public function create(array $attributes) : Task;

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes) : bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool|null;
}
