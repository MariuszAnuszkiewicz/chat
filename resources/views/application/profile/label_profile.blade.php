 <div class="user-profile">
   <div class="header-user-profile">
      <h5>{{ "Profil Username: " }}</h5>
   </div>
   <div class="username-user-profile">
      @foreach ($users as $key => $user)
         @if($key == 'username_host')
            <p class="fat">{{ $user }}</p>
         @endif
      @endforeach
   </div>
   <div class="avatar">
      @foreach ($avatarHost as $img)
         <img src="{{URL::asset($img->avatar)}}">
      @endforeach
   </div>
 </div>
