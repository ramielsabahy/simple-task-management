<?php

namespace App\Services;

use App\Jobs\ResizeImage;
use App\Models\Attachment;
use App\Models\Collaboration;
use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\Collaborator\CollaboratorRepository;
use Intervention\Image\Facades\Image;

class AddCollaboratorService
{
    /**
     * @param CollaboratorRepository $repository
     */
    public function __construct(protected CollaboratorRepository $repository)
    {
    }


    /**
     * @param $data
     * @return Collaboration
     */
    public function store($data) : Collaboration
    {
        return $this->repository->create($data);
    }
}
