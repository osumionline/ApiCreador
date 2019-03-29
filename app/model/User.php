<?php
class User extends OBase{
  function __construct(){
    $table_name  = 'user';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Unique id for every user'
        ],
        'user' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Users name'
        ],
        'pass' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Users password'
        ],
        'num_photos' => [
          'type'     => Base::NUM,
          'default'  => 0,
          'nullable' => false,
          'comment'  =>'Number of pictures a user has'
        ],
        'score' => [
          'type'    => Base::FLOAT,
          'comment' => 'Users score'
        ],
        'active' => [
          'type'     => Base::BOOL,
          'default'  => true,
          'nullable' => false,
          'comment'  => 'Active user 1 or not 0'
        ],
        'last_login' => [
          'type'     => Base::DATE,
          'nullable' => false,
          'comment'  => 'Last time the user logged in'
        ],
        'notes' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Notes about the user'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Row creation date'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Rows last update date'
        ]
    ];

    parent::load($table_name, $model);
  }
}
