<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;


class Account extends Authenticatable  implements CanResetPassword
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'email', 'name', 'password', 'description', 'age', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function isBanned()
    {
        $bans = Ban::where('user_id', $this->id)->get();
        if ($bans->count() == 0) return false;
        foreach ($bans as $ban) {
            if ($ban->expired_at == null) {
                return true;
            }
        }
        return false;
    }
}
