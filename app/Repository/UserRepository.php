<?php

namespace App\Repository;

use App\Models\User;


class UserRepository
{
    public function videoFromSubscriptions(User $user,$limit = 2)
    {
        return $user->subscribedChannels()->with(['videos' => function($query) use ($limit){
            $query->visible()->take($limit);
        }])->get()->pluck('videos')->flatten()->sortByDesc('created_at');
    }
}