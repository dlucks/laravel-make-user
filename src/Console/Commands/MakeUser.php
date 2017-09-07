<?php

namespace MakeUser\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user 
                            {email : Email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Collect all the input.
        $input = [
            'email' => $this->argument('email'),
            'password' => $this->secret(trans('make_user.input.password')),
            'password_confirmation' => $this->secret(trans('make_user.input.password_confirmation')),
            'name' => '',
        ];

        // Load all the configs.
        $userClass = config('make_user.user_class', 'App\\User');
        $roleClass = config('make_user.role_class', 'App\\Role');
        $rules = config('make_user.user_validation_rules', []);
        $rolesRelationMethod = config('make_user.user_roles_relation_method', 'roles');
        $hashPassword = config('make_user.hash_password', true);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($input, $rules);

        // Show validation errors and quit.
        if ($validator->fails()) {

            $errors = $validator->errors();

            foreach($errors->keys() as $key) {
                $this->error($errors->first($key));
            }

            return;
        }

        // Hash password before saving data.
        if ($hashPassword) {
            $input['password'] = Hash::make($input['password']);
        }

        // Create new user and store data to database.
        $user = $userClass::create($input);

        // Yay!
        $this->comment(trans('make_user.user.created', $user->attributesToArray()));

        // Optional: attach roles to created user.
        if ($this->confirm(trans('make_user.user.attach_roles'), true)) {

            $availableRoleNames = $roleClass::all()->pluck('name')->toArray();

            $chosenRoleNames = $this->choice(trans('make_user.user.choose_roles'), $availableRoleNames, null, null, true);

            $roles = $roleClass::whereIn('name', $chosenRoleNames)->get();

            $user->{$rolesRelationMethod}()->sync($roles);
        }
    }
}
