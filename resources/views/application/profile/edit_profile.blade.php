@extends('layouts.app')

@section('content')
    @auth
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Upload file for your profile</div>
                <div class="form-edit">
                    {!! Form::open(['route' => ['edit_profile', 'id' => $id], 'method' => 'POST', 'id' => 'updateForm', 'enctype="multipart/form-data"', 'files' => true]) !!}
                    @csrf
                    <div class="form-group-upload-file">
                       {{ Form::file('profile_image', null, ['class' => 'btn-upload']) }}
                    </div>
                    <div class="form-group-submit">
                       {{ Form::submit('upload', ['name' => 'upload-btn', 'id' => 'upload-btn', 'class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endauth
@endsection