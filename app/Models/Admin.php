<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'password',
        'profile_photo',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'admin_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function scopeByRole($query, $roleSlug)
    {
        return $query->whereHas('role', function ($q) use ($roleSlug) {
            $q->where('slug', $roleSlug);
        });
    }

    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->slug === 'super-admin';
    }

    public function hasPermission(string $permissionSlug): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->role && $this->role->hasPermission($permissionSlug);
    }

    public function hasAnyPermission(array $permissionSlugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->role && $this->role->hasAnyPermission($permissionSlugs);
    }

    public function hasAllPermissions(array $permissionSlugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->role && $this->role->hasAllPermissions($permissionSlugs);
    }

    public function canAccessModule(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->role && $this->role->permissions()
            ->where('module', $module)
            ->exists();
    }

    public function getModulePermissions(string $module): array
    {
        if ($this->isSuperAdmin()) {
            return [];
        }
        return $this->role ? $this->role->getModulePermissions($module) : [];
    }

    public function hasModuleAction(string $module, string $action): bool
    {
        return $this->hasPermission($module . '_' . $action);
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}