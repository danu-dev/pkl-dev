<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\Division;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::with('profile')->find($id);
    }

    public function getPendingStudents(int $perPage = 10): LengthAwarePaginator
    {
        return User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'pending')
            ->latest()
            ->paginate($perPage);
    }

    public function getStudentsFiltered(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function updateStatus(User $user, string $status, bool $isApproved): void
    {
        $user->update([
            'status' => $status,
            'is_approved' => $isApproved,
        ]);
    }

    public function updateUser(User $user, array $userData, array $profileData): void
    {
        $user->update($userData);

        if ($user->profile) {
            if (! empty($profileData['division_id'])) {
                $division = Division::find($profileData['division_id']);
                $profileData['division_name'] = $division?->name;
            } else {
                $profileData['division_name'] = null;
            }

            $user->profile->update($profileData);
        }
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function countApprovedStudents(): int
    {
        return User::where('role', 'siswa_pkl')->where('status', 'approved')->count();
    }

    public function countPendingStudents(): int
    {
        return User::where('role', 'siswa_pkl')->where('status', 'pending')->count();
    }

    public function getRecentPendingStudents(int $limit = 5): Collection
    {
        return User::with('profile')
            ->where('role', 'siswa_pkl')
            ->where('status', 'pending')
            ->latest()
            ->take($limit)
            ->get();
    }
}
