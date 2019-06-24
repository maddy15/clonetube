@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
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
                                    <li>
                                        <subscribe-button channel-slug="{{ $channel->slug }}"></subscribe-button>
                                    </li>
                                    <li>
                                        <b>{{ $channel->totalVideoViews() }} video {{ str_plural('view',$channel->totalVideoViews()) }}</b>
                                    </li>
                                </ul>
                                @if($channel->description)
                                    <hr>
                                    <p>{{ $channel->description }}</p>
                                @endif
                            </div>
                        </div>                                
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card">
                                @include('video.partials.__video_result',$video)
                            </div>
                        @endforeach
                    {{ $videos->links() }}
                    @else
                            <p>{{ $channel->name }} has no video.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
