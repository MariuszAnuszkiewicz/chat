@extends('layouts.app')

@section('content')
    @auth
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">send message</div>
                    @include('application.profile.label_profile')
                    <div class="card-body">
                        <div class="form-chat">
                          {!! Form::open(['route' => ['chat'], 'method' => 'POST', 'id' => 'chatForm']) !!}
                              @csrf
                             <div class="col-md-3" id="message-label">
                                 {!! Html::decode(Form::label("message", '<h5><b>Message:</b></h5>', ['class' => 'message-label-elem'])) !!}
                             </div>
                            {{ Form::hidden('data-profile-value', $idGuest, ['id' => 'dpv']) }}
                            {{ Form::textarea("message", old("message") ? old("message") : (!empty($user) ? null : null), [ "class" => "textarea-message"]) }}
                            {{ Form::submit('send', ['name' => 'send-btn', 'id' => 'send-chat-btn', 'class' => 'btn btn-primary']) }}
                          {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('application.profile.list_profiles')
    @endauth
@endsection