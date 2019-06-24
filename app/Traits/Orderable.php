<?php

namespace App\Traits;

trait Orderable
{
    public function scopeLatestFirst($builder)
    {
        return $builder->orderBy('created_at','desc');
    }
}