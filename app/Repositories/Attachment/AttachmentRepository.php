<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Collection;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    protected $model;

    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
    }

    /**
     * @param array $attributes
     * @return Attachment
     */
    public function create(array $attributes): Attachment
    {
        return $this->model->create($attributes);
    }
}
