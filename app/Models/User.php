<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = ["name", "email", "username", "password", "is_admin"];

    protected $hidden = ["password", "remember_token"];

    protected $casts = [
        "email_verified_at" => "datetime",
        "is_admin" => "boolean",
    ];

    /* =======================
       Relations
    ======================= */

    public function presidents()
    {
        return $this->hasMany(President::class);
    }

    public function deletedPresidents()
    {
        return $this->hasMany(President::class)->onlyTrashed();
    }

    /* =======================
       Helpers
    ======================= */

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
