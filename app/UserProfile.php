<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProfile extends Model
{
    const AVATAR_USER_PROFILE_PATH = '/img/profiles/';
    const LIMIT_USER_PROFILE = 1;

    protected $fillable = [
        'user_id',
        'hash_user_id',
        'username',
        'login_status',
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function getCreatedAtAttribute()
    {
        return $this->dates['created_at'] = Carbon::now("Europe/Warsaw");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->dates['updated_at'] = Carbon::now("Europe/Warsaw");
    }

    public function insertDataToUserProfile($user_id, $hash_user_id, $username, $login_status, $avatar)
    {
        DB::table('user_profile')->insert([
            'user_id' => $user_id,
            'hash_user_id' => $hash_user_id,
            'username' => $username,
            'login_status' => $login_status,
            'avatar' => $avatar,
            'created_at' => $this->getCreatedAtAttribute(),
            'updated_at' => $this->getUpdatedAtAttribute()
        ]);
    }

    public function getUserIdByName($name)
    {
        return DB::select('SELECT user_id FROM user_profile WHERE username = ?', [$name]);
    }

    public function getUserIdByNamesExceptHost($name)
    {
        return DB::select('SELECT * FROM user_profile WHERE username != ?', [$name]);
    }

    public function getUsernameByUserId($id)
    {
        return DB::select('SELECT username FROM user_profile WHERE user_id = ?', [$id]);
    }

    public function getAllResults()
    {
        return DB::select('SELECT * FROM user_profile');
    }

    public function getHashUserId($id)
    {
        return DB::select('SELECT hash_user_id FROM user_profile WHERE user_id = ?', [$id]);
    }

    public function deleteById($id)
    {
        return DB::delete('DELETE FROM user_profile WHERE user_id = ?', [$id]);
    }

    public function updateByUserId($value, $id)
    {
        return DB::update('UPDATE user_profile SET login_status = ? WHERE user_id = ?', [$value, $id]);
    }

    public function updateImageUserProfile($value, $id)
    {
        return DB::update('UPDATE user_profile SET avatar = ? WHERE user_id = ? ', [$value, $id]);
    }

    public function getAvatarImage($id)
    {
        return DB::select('SELECT avatar FROM user_profile WHERE user_id = ?', [$id]);
    }
}
