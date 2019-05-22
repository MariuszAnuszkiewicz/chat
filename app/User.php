<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function getAllResults()
    {
        return DB::select('SELECT name FROM users');
    }

    public function getUsernameById($id)
    {
        return DB::select('SELECT name FROM users WHERE id = ?', [$id]);
    }

    public function getIdByUserId($userId)
    {
        return DB::select('SELECT id FROM users WHERE id = ?', [$userId]);
    }

}
