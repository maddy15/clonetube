<div class="row">
    <div class="col-sm-3">
        <a href="/videos/{{ $video->uid }}">
            <img src="{{ $video->getThumbnail() }}" alt="" class="img-thumbnail">
        </a>
    </div>
    <div class="col-sm-9">
        <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>

        @if($video->description)
            <p>{{ $video->description }}</p>
        @else
            <p class="muted">No description.</p>
        @endif

        <ul class="list-inline">
            <li><a href="/channel/{{ $video->channel->slug }}">{{ $video->channel->name }}</a></li>
            <li>{{ $video->created_at->diffForHumans() }}</li>
            <li>{{ $video->viewCount() }} {{ str_plural('View',$video->viewCount()) }}</li>
        </ul>
    </div>
</div>