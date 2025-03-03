<?php

namespace App\Actions\Auth;

use App\Models\Role;
use App\Models\User;
use App\Mail\WelcomeEmail;
use App\Models\ActivityLog;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewUserRegistered;

class RegisterAction
{
    public function execute(array $data): User
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $defaultRole = Role::where('slug', 'user')->firstOrFail();
            $user->roles()->attach($defaultRole);

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'user_registered',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "New user registration: {$user->email}"
            ]);

            // Notify admins
            $admins = User::whereHas('roles', function ($query) {
                $query->where('slug', 'admin');
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegistered($user));
            }

            // Queue welcome email
            Mail::to($user->email)->queue(new WelcomeEmail($user));

            DB::commit();

            return $user->load(['roles', 'permissions']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}