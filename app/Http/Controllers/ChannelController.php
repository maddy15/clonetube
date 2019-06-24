<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;

class ChannelController extends Controller
{
    public function show(Request $request,Channel $channel)
    {
        return view('channels.show',[
            'channel' => $channel,
            'videos' => $channel->videos()->latestFirst()->visible()->paginate(1),
        ]);
    }
}
