<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validator::make($input, [
        //     ...$this->profileRules(),
        //     'password' => $this->passwordRules(),
        //     'gare_id' => ['nullable', 'exists:gares,id'],
        //     'role' => ['required', 'in:admin,user,agent,superviseur'],
        // ])->validate();

        
        //  Validator::make($input, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => $this->passwordRules(),
        //     'gare_id' => ['nullable', 'exists:gares,id'],
        //     'role' => ['required', 'in:admin,agent,superviseur,utilisateur'],
        // ])->validate();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gare_id' => ['nullable', 'exists:gares,id'],
            'role' => ['required', Role::in([
                User::ROLE_ADMIN,
                User::ROLE_AGENT,
                User::ROLE_SUPERVISEUR,
                User::ROLE_UTILISATEUR
            ])],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            // 'password' => $input['password'],
            'password' => Hash::make($input['password']),
            'gare_id' => $input['gare_id'] ?? null,
            'role' => $input['role'],
        ]);
    }
}
