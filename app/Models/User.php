<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
   use Notifiable; 
   protected $fillable = [
    'name', 'email', 'password', 'gender', 'phone', 'birth_date','avatar','is_admin', 'is_staff',
];

protected $hidden = [
    'password', 'remember_token',
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'birth_date' => 'date',
];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }
    public function handle(Request $request, Closure $next, $role)
{
    \Log::info('Checking role: ' . $role . ' for user: ' . (Auth::check() ? Auth::user()->email : 'null'));
    if (!Auth::check() || !Auth::user()->is_staff || !Auth::user()->hasRole($role)) {
        \Log::warning('Access denied for role: ' . $role);
        return redirect('/')->with('error', 'Bạn không có quyền truy cập.');
    }

    return $next($request);
}
}