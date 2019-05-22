@extends('layouts.app')

@section('content')
   @auth
   <div class="card-chat">
     <div class="card-header">send message</div>
      @include('application.profile.label_profile')
         <div class="form-chat">
            {!! Form::open(['route' => ['chat'], 'method' => 'POST', 'id' => 'chatForm']) !!}
            @csrf
            <div class="col-md-3" id="message-label">
               {!! Html::decode(Form::label("message", '<h5><b>Message:</b></h5>', ['class' => 'message-label-elem'])) !!}
            </div>
            {{ Form::hidden('data-profile-value', $idGuest, ['id' => 'dpv']) }}
            {{ Form::textarea("message", old("message") ? old("message") : (!empty($users) ? null : null), [ "class" => "textarea-message", ]) }}
            {{ Form::submit('send', ['name' => 'send-btn', 'id' => 'send-chat-btn', 'class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
         </div>
      <div id="save_status"></div>
   </div>
      @if(isset($messages))
         <div class="messages">
            <div class="header-setting">
               <div class="form-chat-clear">
                  {!! Form::open(['route' => ['clear'], 'method' => 'DELETE', 'id' => 'chatClearForm']) !!}
                  @csrf
                  {{ Form::submit('clear', ['name' => 'clear-btn', 'class' => 'btn btn-warning']) }}
                  {!! Form::close() !!}
               </div>
               <div class="setting-fonts">
                  <span class="plus"></span>
                  <span class="minus"></span>
               </div>
            </div>
            <div class="username-header-host">
               @foreach ($users as $key => $user)
                  @if ($key == 'host')
                    <p class="username">{{ $user }}</p>
                  @endif
               @endforeach
            </div>
            @foreach ($messages as $key => $message)
               @if ($key == 'host')
                  <div class="message-host"></div>
               @endif
            @endforeach
         </div>
         @foreach ($messages as $key => $message)
            @if ($key == 'guest')
               <div class="guest-cloud"><span>{{ $user }}</span>
                  @include('application.chat.guest_profile')
               </div>
            @endif
         @endforeach
      @endif
   @endauth
@endsection
