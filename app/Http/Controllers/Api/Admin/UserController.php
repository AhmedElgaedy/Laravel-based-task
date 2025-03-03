<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Users\FilterUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\FilterUsersRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(FilterUsersRequest $request, FilterUsersAction $action)
    {
        $users = $action->execute($request->validated());

        return apiResponse(
            200,
            'success',
            'Users retrieved successfully',
            UserResource::collection($users),
            getPaginationMeta($users)
        );
    }
}