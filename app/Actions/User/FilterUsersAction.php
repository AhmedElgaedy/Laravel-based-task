<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterUsersAction
{
    public function execute(array $filters): LengthAwarePaginator
    {
        $query = User::query()
            ->with('roles');

        if (isset($filters['role'])) {
            $query->byRole($filters['role']);
        }

        if (isset($filters['active'])) {
            $query->where('is_active', $filters['active']);
        }

        return $query->latest()
            ->paginate($filters['per_page'] ?? 15);
    }
}