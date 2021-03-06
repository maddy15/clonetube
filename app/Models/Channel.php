<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\models\VideoView;

class Channel extends Model
{
    use Searchable;
    
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'image_file',
        
    ];

    public function getRouteKeyName()
    {
        return 'slug';    
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        if(!$this->image_filename)
        {
            return config('codetube.buckets.images') . '/profile/default_thumbnail.png';
        }
        return config('codetube.buckets.images') . '/profile/' . $this->image_filename;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }

    public function totalVideoViews()
    {
        return $this->hasManyThrough(VideoView::class,Video::class)->count();
    }
}
