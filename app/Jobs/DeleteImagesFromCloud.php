<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Images;

class DeleteImagesFromCloud implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $images;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images) {
	    $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

	    foreach($this->images as $img) { 
                               
            if (Storage::disk('s3')->delete("images/normal/".$img["name"]) && Storage::disk('s3')->delete("images/small/".$img["name"])) {
                Images::where("name", $img["name"])->delete();
            }
        }

    }
}
