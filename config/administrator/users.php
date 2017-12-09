<?php

use App\Models\User;

return [
    // 页面标题
    'title' => '用户',

    // 模型单数，用作页面『新建 $single』
    'single' => '用户',

    // 数据模型，用作数据的 CRUD
    'model' => User::class,

    'permission' => function()
    {
        return Auth::user()->can('manage_users');
    },

    'columns' => [
        'id',
        'avatar' => [
            'title' => '头像',

            'output' => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" width="40">';
            },

            'sortable' => false,
        ],

        'name' => [
            'title' => '用户名',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="/users/'.$model->id.'" target=_blank>'.$name.'</a>';
            }
        ],

        'email' => [
            'title' => '邮箱'
        ],

        'operation' => [
            'title' => '管理',
            'sortable' => false
        ]
    ],

    // 『模型表单』设置项
    'edit_fields' => [
        'name' => [
            'title' => '用户名'
        ],
        'email' => [
            'title' => '邮箱'
        ],
        'password' => [
            'title' => '密码',

            'type' => 'password'
        ],
        'avatar' => [
            'title' => '用户头像',

            'type' => 'image',

            'location' => public_path() . '/uploads/images/avatars/'
        ],
        'roles' => [
            'title' => '用户角色',

            'type' => 'relationship',

            'name_field' => 'name'
        ]
    ],

    'filters' => [
        'id' => [
            'title' => '用户 ID'
        ],
        'name' => [
            'title' => '用户名'
        ],
        'email' => [
            'title' => '邮箱'
        ]
    ]
];
