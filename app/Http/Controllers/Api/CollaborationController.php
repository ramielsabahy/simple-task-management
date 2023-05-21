<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\AddAttachmentRequest;
use App\Http\Requests\Collaborator\AddCollaboratorRequest;
use App\Http\Resources\Task\TaskResource;
use App\Repositories\Attachment\AttachmentRepository;
use App\Services\AddAttachmentService;
use App\Services\AddCollaboratorService;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    /**
     * @var AddCollaboratorService
     */
    private AddCollaboratorService $addCollaboratorService;

    /**
     * @param AddCollaboratorService $addCollaboratorService
     */
    public function __construct(AddCollaboratorService $addCollaboratorService)
    {
        $this->addCollaboratorService = $addCollaboratorService;
    }

    public function store(AddCollaboratorRequest $request)
    {
        $attachment = $this->addCollaboratorService->store($request->only('user_id', 'task_id'));
        return customResponse((object)[], 'Collaborator added successfully');
    }
}
