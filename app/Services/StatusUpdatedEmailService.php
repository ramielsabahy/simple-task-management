<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Task;
use App\Notifications\TaskStatusUpdated;
use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\Task\TaskRepository;
use Intervention\Image\Facades\Image;

class StatusUpdatedEmailService
{
//    private $id;
    private $repository;
    public function __construct(TaskRepository $repository)
    {
//        $this->id = $id;
        $this->repository = $repository;
    }

    public function send($id)
    {
        $task = $this->repository->find($id);
        request()->user()->notify(new TaskStatusUpdated($task));
    }
}
