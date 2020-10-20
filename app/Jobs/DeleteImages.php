<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Images;

class DeleteImages implements ShouldQueue {
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
            File::delete($img["path"].$img["name"]);            
        }        
    }

}
