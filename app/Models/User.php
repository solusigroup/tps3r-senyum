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
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is Superuser (can do everything)
     */
    public function isSuperuser(): bool
    {
        return $this->role === 'superuser';
    }

    /**
     * Check if user is Administrasi (can manage data)
     */
    public function isAdministrasi(): bool
    {
        return $this->role === 'administrasi';
    }

    /**
     * Check if user is Peninjau (view reports only)
     */
    public function isPeninjau(): bool
    {
        return $this->role === 'peninjau';
    }

    /**
     * Check if user can manage data (create, update, delete)
     */
    public function canManageData(): bool
    {
        return in_array($this->role, ['superuser', 'administrasi']);
    }

    /**
     * Check if user can manage users
     */
    public function canManageUsers(): bool
    {
        return $this->role === 'superuser';
    }

    /**
     * Get role display name
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'superuser' => 'Superuser',
            'administrasi' => 'Administrasi',
            'peninjau' => 'Peninjau',
            default => 'Unknown',
        };
    }
}
