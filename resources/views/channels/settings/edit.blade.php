@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Channel Settings</div>

                <div class="card-body">
                    <form action="/channel/{{ $channel->slug }}/edit" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ? old('name') : $channel->name }}">

                            @if($errors->has('name'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">{{ config('app.url') }}/channel</span>
                                </div>
                                <input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                            </div>
                            @if($errors->has('slug'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('slug') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                            @if($errors->has('description'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="image">Channel Image</label>
                            <input type="file" name="image" id="image">

                            @if($errors->has('image'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('image') }}
                                </div>
                            @endif
                        </div>

                        <button class="btn btn-default" type="submit">Submit</button>

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
