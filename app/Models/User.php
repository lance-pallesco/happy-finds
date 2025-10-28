<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasEmailAuthentication, HasAvatar
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
        'avatar',
        'has_email_authentication',
        'password',
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
            'has_email_authentication' => 'boolean'
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function hasEmailAuthentication(): bool {
        return $this->has_email_authentication;
    }

    public function toggleEmailAuthentication(bool $condition): void {
        $this->has_email_authentication = $condition;
        $this->save();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function socialMediaDetail() {
        return $this->hasOne(SocialMediaDetail::class);
    }
}
