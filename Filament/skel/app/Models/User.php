<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'username',
    'name',
    'email',
    'password',
    'expires_at',
    'is_active',
    'avatar',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'expires_at' => 'datetime',
  ];

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = Hash::make($value);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function canAccessFilament(): bool
  {
    return true;
    // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
  }

  public function scopeActive($query, $state = true)
  {
    $query->where('is_active', $state);
  }

  public function scopeBlocked($query, $state = true)
  {
    $query->where('is_blocked', $state);
  }

  public function hasPermission($uperm)
  {
    $perm = $this->Role?->perm;
    $isAdminRole = (bool) ($this->Role?->is_admin ?? false);
    // if ($uperm == "set-password") {
    //   dump($uperm);
    //   dd($perm);
    // }
    // dd($isAdminRole, $uperm, $perm);
    if ($isAdminRole) return true;
    if (!$perm) return false;
    $allowed =  in_array($uperm, $perm);
    // dd($allowed, $uperm, $perm);
    return $allowed;
  }

  public function isAdmin() {
    if ($this->Role?->is_admin) return true;
  }

  public function getFilamentAvatarUrl(): ?string
  {
    $url = ($this->avatar) ? Storage::url($this->avatar) : null;
    return $url;
  }

  public function lastLogin($ip) {
    $this->last_login_ip = $ip;
    $this->last_login_at = now();
    $this->save();
  }
}
