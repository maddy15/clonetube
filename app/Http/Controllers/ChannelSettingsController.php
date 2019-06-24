<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use Illuminate\Support\Facades\File;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
       $this->authorize('edit',$channel);

       return view('channels.settings.edit',[
           'channel' => $channel
           ]);
    }

    public function update(Channel $channel,ChannelUpdateRequest $request)
    {
        $this->authorize('update',$channel);

        $channel->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        if($request->file('image'))
        {
            //move to temp location
            $request->file('image')->move(storage_path() . '/uploads', $fileId = uniqid(true));
            //dispatch job
            
            $this->dispatch(new UploadImage($channel,$fileId));
        }
        //  dd(storage_path() . '/uploads/' . '15cb4491d88bf7');
        // @unlink(storage_path() . '\\uploads\\' . '15cb44a3902330');
        
        return redirect()->to("/channel/" . $channel->slug . "/edit");
    }
}
