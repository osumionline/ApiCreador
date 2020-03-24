<?php
class User extends OModel{
  function __construct(){
    $table_name  = 'user';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único para cada usuario'
        ],
        'username' => [
          'type'     => OCore::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre de usuario'
        ],
        'pass' => [
          'type'     => OCore::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Contraseña cifrada del usuario'
        ],
        'created_at' => [
          'type'    => OCore::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => OCore::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }
}