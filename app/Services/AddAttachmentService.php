<?php

namespace App\Services;

use App\Jobs\ResizeImage;
use App\Models\Attachment;
use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\Task\TaskRepository;
use Intervention\Image\Facades\Image;

class AddAttachmentService
{
    /**
     * @param AttachmentRepository $repository
     * @param TaskRepository $taskRepository
     */
    public function __construct(protected AttachmentRepository $repository, protected TaskRepository $taskRepository)
    {
    }


    /**
     * @param $attachment
     * @return Attachment
     */
    public function store($attachment) : Attachment | null
    {
        $checkTask = $this->taskRepository->find($attachment['task_id']);
        if (!$checkTask)
            return null;
        $image_name = uniqid() . '.' . $attachment['attachment']->getClientOriginalExtension();
        $image_path = 'uploads/' . $image_name;
        $image = Image::make($attachment['attachment'])->save(public_path($image_path));
        $attachment['attachment'] = $image_path;
        $savedAttachment =  $this->repository->create($attachment);
        ResizeImage::dispatch($image_name,$image_path,$savedAttachment);
        return $savedAttachment;
    }
}
