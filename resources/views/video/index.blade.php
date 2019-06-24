@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Video</div>

                <div class="card-body">
                   @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card card-body bg-light">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="/videos/{{ $video->uid }}">
                                            <img src="{{ $video->getThumbnail() }}" class="img-thumbnail" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="muted">
                                                    @if(!$video->isProcessed())
                                                        Processing({{ $video->processedPercentage() ? $video->processedPercentage() . '%' : 'Starting up' }})
                                                    @else
                                                        <span>{{ $video->created_at->toDateTimeString() }}</span>
                                                    @endif
                                                </p>
                                                <form action="/videos/{{ $video->uid }}" method="POST">
                                                    <a href="/videos/{{ $video->uid }}/edit" class="btn btn-light">Edit</a>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>{{ ucfirst($video->visibility) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                            <br>
                        {{ $videos->links()}}
                   @else
                    <p>You have no videos.</p>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
