<?php

namespace Larasoft\PasswordExpiry\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PreviousPasswordHash extends Model
{
    protected $fillable = ['user_id', 'password_hash'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
