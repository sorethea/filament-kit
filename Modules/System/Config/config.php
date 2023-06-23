<?php

return [
    'name' => 'System',
    'default_role'=>'user',
    'groups' =>[
        'admin'=>'Administrator',
        'business'=>'Business',
        'system'=>'System',
        'subscription'=>'Subscription'
    ],
    'roles'=>[
        'owner'=>'owner',
        'employee'=>'employee',
        'customer'=>'customer',
        'supplier'=>'supplier',
    ],
    'custom_permissions' => [
        'manage'
    ],
];
