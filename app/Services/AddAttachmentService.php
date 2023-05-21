<?php

namespace App\Services;

use App\Jobs\ResizeImage;
use App\Models\Attachment;
use App\Repositories\Attachment\AttachmentRepository;
use Intervention\Image\Facades\Image;

class AddAttachmentService
{
    /**
     * @param AttachmentRepository $repository
     */
    public function __construct(protected AttachmentRepository $repository)
    {
    }


    /**
     * @param $attachment
     * @return Attachment
     */
    public function store($attachment) : Attachment
    {
        $image_name = uniqid() . '.' . $attachment['attachment']->getClientOriginalExtension();
        $image_path = 'uploads/' . $image_name;
        $image = Image::make($attachment['attachment'])->save(public_path($image_path));
        $attachment['attachment'] = $image_path;
        $savedAttachment =  $this->repository->create($attachment);
        ResizeImage::dispatch($image_name,$image_path,$savedAttachment);
        return $savedAttachment;
    }
}
