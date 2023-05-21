<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Collection;

interface AttachmentRepositoryInterface
{

    /**
     * @param array $attributes
     * @return Attachment
     */
    public function create(array $attributes) : Attachment;
}
