@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Video "{{ $video->title }}"</div>

                <div class="card-body">
                   <form action="/videos/{{ $video->uid }}" method="POST">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') ? old('title') : $video->title }}">

                            @if($errors->has('title'))
                                <div class="help-block">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $video->description }}</textarea>
                            @if($errors->has('description'))
                                <div class="help-block">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('visibility') ? 'has-error' : ''}}">
                            <label for="visibility">visibility</label>
                            <select name="visibility" id="visibility" value="{{ old('visibility') ? old('visibility') : $video->visibility }}" class="form-control">
                                @foreach(['public','unlisted','private'] as $visibility)
                                    <option value="{{ $visibility }}" {{$video->visibility === $visibility ? 'selected' : '' }}>{{ ucfirst($visibility) }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('visibility'))
                                <div class="help-block">
                                    {{ $errors->first('visibility') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="allow_votes">
                                <input type="checkbox" name="allow_votes" id="allow_votes" {{$video->votesAllowed() ? 'checked' : '' }}> Allow votes
                            </label> 
                        </div>

                        <div class="form-group">
                            <label for="allow_comments">
                                <input type="checkbox" name="allow_comments" id="allow_comments" {{$video->commentsAllowed() ? 'checked' : '' }}> Allow comments
                            </label> 
                        </div>

                        <button type="submit" class="btn btn-light">Update</button>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
