<div class="guest-profile">
   <div class="guest-avatar">
       @foreach ($avatarGuest as $img)
           <img src="{{URL::asset($img->avatar)}}" height="80" width="80">
       @endforeach
   </div>
</div>