<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\AddAttachmentRequest;
use App\Http\Resources\Task\TaskResource;
use App\Repositories\Attachment\AttachmentRepository;
use App\Services\AddAttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * @var AddAttachmentService
     */
    private AddAttachmentService $addAttachmentService;

    /**
     * @param AddAttachmentService $addAttachmentService
     */
    public function __construct(AddAttachmentService $addAttachmentService)
    {
        $this->addAttachmentService = $addAttachmentService;
    }

    public function store(AddAttachmentRequest $request)
    {
        $attachment = $this->addAttachmentService->store($request->only('attachment', 'task_id'));
        return customResponse(new TaskResource($attachment->task->load('images')));
    }
}
