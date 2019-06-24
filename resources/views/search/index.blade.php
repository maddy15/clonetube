@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search for "{{ Request::get('q') }}"</div>

                <div class="card-body">
                    @if($channels->count())
                        <h4>Channels</h4>
                        @foreach($channels as $channel)
                            <div class="card card-body bg-light">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="/channel/{{ $channel->slug }}">
                                            <img src="{{$channel->getImage()}}" alt="" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4><a href="/channel/{{ $channel->slug }}">{{ $channel->name }}</a></h4>
                                        <ul class="list-inline">
                                            <li>{{ $channel->subscriptionCount() }} {{ str_plural('Subscriber',$channel->subscriptionCount() )}}</li>
                                        </ul>
                                    </div>
                                </div>                                
                            </div>
                        @endforeach
                   @endif

                   @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card card-body bg-light">
                                @include('video.partials.__video_result',[
                                    'video' => $video
                                ])
                            </div>
                        @endforeach
                   @else
                            <p>No Videos found.</p>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
