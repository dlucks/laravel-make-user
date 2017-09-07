<?php

return [

    // Class of user model.
    'user_class' => 'App\\User',

    // Class of role model.
    'role_class' => 'App\\Role',

    // Validation rules used for creating new users.
    'user_validation_rules' => [

        'email' => 'required|unique:users,email|email',

        'password' => 'required|confirmed|min:8',
    ],

    // Method in user model to access the roles relation (BelongsToMany).
    'user_roles_relation_method' => 'roles',

    // Do or do not hash password before saving it in database.
    'hash_password' => true,
];
