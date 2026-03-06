<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi (Mass Assignable).
     * Termasuk field gamifikasi like koban, streak, dan mood.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'koban',
        'current_streak',
        'highest_streak',
        'active_theme',
        'active_mascot_skin',
        'mood',
        'paw_points',
        'last_daily_claim',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function inventories()
    {
        return $this->hasMany(UserInventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function blackBooks()
    {
        return $this->hasMany(BlackBook::class);
    }
}
