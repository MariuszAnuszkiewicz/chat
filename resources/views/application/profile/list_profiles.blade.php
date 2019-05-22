<div class="user-profiles">
    <div class="title-header-profile"><h5>Get profile with you want conversation</h5></div>
    <table border='1' id='table-profiles' style='border-collapse: collapse;'>
        <thead class="thead-dark">
        <tr>
            <th>User Id</th>
            <th>Username</th>
            <th>Login Status</th>
            <th>Avatar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($guestProfiles as $profile)
            @if ($profile->user_id == $idGuest)
              <tr class="profile active" data-profile="{{ $profile->user_id }}">
            @else
              <tr class="profile" data-profile="{{ $profile->user_id }}">
            @endif
                <td class="cell-profiles">{{ $profile->user_id }}</td>
                <td class="cell-profiles">{{ $profile->username }}</td>
                <td class="cell-profiles">{{ $profile->login_status }}</td>
                <td class="cell-profiles"><img src="{{ $profile->avatar }}" height="80" width="80"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>