<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Carbon\Carbon;

class VideoViewController extends Controller
{

    const BUFFER = 30;

    public function create(Request $request,Video $video)
    {
        if(!$video->canBeAccessed($request->user())) return;
        
        if($request->user())
        {
            $lastUserView = $video->views()->latestByUser($request->user())->first();

            if($this->withInBuffer($lastUserView)) return;
        }

        $lastIpView = $video->views()->latestByIp($request->ip())->first();

        if($this->withInBuffer($lastIpView)) return;
        
        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip' => $request->ip()
        ]);

        return response()->json(null,200);
    }

    protected function withInBuffer($view)
    {
        return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
