<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HChatLog extends Model
{
    protected $table = 'h_chatlog';
    protected $primaryKey = 'chatlog_id';
    public $timestamps = false;

    protected $fillable = [
        'question',
        'answer',
        'api_key',
        'status',
        'created_at',
    ];

    // public function fk_user()
    // {
    //     return $this->belongsTo(User::class, 'id_user', 'id_user');
    // }

    // public function fk_action()
    // {
    //     return $this->belongsTo(MAction::class, 'id_action', 'id_action');
    // }
}
