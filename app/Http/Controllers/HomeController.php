<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepository;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request,UserRepository $users)
    {
        
        // return $users->videoFromSubscriptions($request->user());
        return view('home',[
            'subscriptionVideos' => $users->videoFromSubscriptions($request->user())
        ]);
    }
}
