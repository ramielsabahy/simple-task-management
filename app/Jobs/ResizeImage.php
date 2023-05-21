<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name,
            $path,
            $image;
    /**
     * Create a new job instance.
     */
    public function __construct($name,$path,$image)
    {
        $this->name = $name;
        $this->path = $path;
        $this->image = $image;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Image::make(public_path($this->image->attachment))->resize(150, 150)->save(public_path('uploads/'.$this->name));
    }
}
