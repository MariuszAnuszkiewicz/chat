<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Chat extends Model
{
    const DATA_USER_PROFILE_PATH = '/data/profiles/';

    protected $fillable = ['message'];

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

    public function insertDataToChat($user_id, $message)
    {
        DB::table('chat')->insert([
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => $this->getCreatedAtAttribute(),
            'updated_at' => $this->getUpdatedAtAttribute()
        ]);
    }

    public function getMessagesByUserId($user_id)
    {
        return DB::select('SELECT message FROM chat WHERE user_id = ?', [$user_id]);
    }

    public function deleteByUserId($id)
    {
        return DB::delete('DELETE FROM chat WHERE user_id = ?', [$id]);
    }
}
