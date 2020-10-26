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

class PostImages implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $images;
    private $title; 
    private $category;
    private $text; 
    private $price; 
    private $phone;
    private $region_id;
    private $place_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images, $title, $category, $text, $price, $phone, $region_id, $place_id) {
        $this->images = $images;        
        $this->title = $title;
        $this->category = $category;
        $this->text = $text;
        $this->price = $price;
        $this->phone = $phone;
        $this->region_id = $region_id;
        $this->place_id = $place_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        foreach($this->images as $img) {         
        }        
    }
}
