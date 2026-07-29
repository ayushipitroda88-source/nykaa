<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Role;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffService
{
    public function createStaff(array $data, ?int $superAdminId = null): Admin
    {
        return DB::transaction(function () use ($data, $superAdminId) {
            $admin = Admin::create([
                'role_id' => $data['role_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'status' => $data['status'] ?? true,
            ]);

            if (isset($data['profile_photo'])) {
                $path = $data['profile_photo']->store('profile-photos', 'public');
                $admin->update(['profile_photo' => $path]);
            }

            ActivityLog::create([
                'admin_id' => $superAdminId ?? $admin->id,
                'activity' => 'Created Staff: ' . $admin->name,
                'ip_address' => request()->ip(),
            ]);

            return $admin;
        });
    }

    public function updateStaff(Admin $admin, array $data): Admin
    {
        return DB::transaction(function () use ($admin, $data) {
            $updateData = [
                'name' => $data['name'] ?? $admin->name,
                'email' => $data['email'] ?? $admin->email,
                'phone' => $data['phone'] ?? $admin->phone,
                'role_id' => $data['role_id'] ?? $admin->role_id,
                'status' => $data['status'] ?? $admin->status,
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            if (isset($data['profile_photo'])) {
                if ($admin->profile_photo) {
                    Storage::disk('public')->delete($admin->profile_photo);
                }
                $path = $data['profile_photo']->store('profile-photos', 'public');
                $updateData['profile_photo'] = $path;
            }

            $admin->update($updateData);

            ActivityLog::create([
                'admin_id' => auth('admin')->id(),
                'activity' => 'Updated Staff: ' . $admin->name,
                'ip_address' => request()->ip(),
            ]);

            return $admin->fresh();
        });
    }

    public function deleteStaff(Admin $admin): bool
    {
        return DB::transaction(function () use ($admin) {
            $name = $admin->name;

            if ($admin->profile_photo) {
                Storage::disk('public')->delete($admin->profile_photo);
            }

            $admin->activityLogs()->delete();
            $deleted = $admin->delete();

            if ($deleted) {
                ActivityLog::create([
                    'admin_id' => auth('admin')->id(),
                    'activity' => 'Deleted Staff: ' . $name,
                    'ip_address' => request()->ip(),
                ]);
            }

            return $deleted;
        });
    }

    public function logActivity(Admin $admin, string $activity, ?string $details = null): ActivityLog
    {
        return ActivityLog::create([
            'admin_id' => $admin->id,
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'details' => $details,
        ]);
    }

    public function getDashboardStats(): array
    {
        return [
            'total' => Admin::count(),
            'active' => Admin::active()->count(),
            'inactive' => Admin::inactive()->count(),
            'byRole' => Role::withCount('admins')->get()->map(function ($role) {
                return [
                    'name' => $role->name,
                    'count' => $role->admins_count,
                ];
            }),
        ];
    }
}