<?php

namespace App\Jobs;

use Storage;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Channel;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;

    public $fileId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel,$fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get the image
        $path = storage_path() . '\\uploads\\' . $this->fileId;
        $fileName = $this->fileId . '.png';

        //resize
        Image::make($path)->encode('png')->fit(40,40,function($c){
            $c->upsize();
        })->save();
        //upload to s3
        if(Storage::disk('s3images')->put('profile/'. $fileName,fopen($path,'r+')))
        {
            //delete temp file
            // @unlink(storage_path() . '\\uploads\\' . $this->fileId);
            File::delete($path);
        }
        
        //update channel image
        $this->channel->image_filename = $fileName;
        $this->channel->save();
        
    }
}
