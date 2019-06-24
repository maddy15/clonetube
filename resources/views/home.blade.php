@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subscription Videos</div>

                <div class="card-body">
                   @if($subscriptionVideos->count())
                        @foreach($subscriptionVideos as $video)
                            <div class="card">
                                @include('video.partials.__video_result',$video)
                            </div>
                        @endforeach
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
