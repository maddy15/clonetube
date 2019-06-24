<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Channel;

class ChannelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user,Channel $channel)
    {
        return $channel->user_id === $user->id;
    }

    public function edit(User $user,Channel $channel)
    {
        return $channel->user_id === $user->id;
    }

    public function subscribe(User $user,Channel $channel)
    {
        if($user->isSubscribedTo($channel))
        {
            return false;
        }
        return !$user->ownsChannel($channel) ;
    }

    public function unsubscribe(User $user,Channel $channel)
    {
        return $user->isSubscribedTo($channel);
    }
}
