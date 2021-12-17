<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Image;

class ThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $hashName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, $hashName)
    {
        $this->path = $path;
        $this->hashName = $hashName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image_file = Image::make($this->path);
        $path = storage_path('app/public/'.$this->hashName);
        $image_file->resize(80, 80)->save($path);
    }
}
