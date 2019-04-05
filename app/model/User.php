<?php
class User extends OBase{
  function __construct(){
    $table_name  = 'user';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para cada usuario'
        ],
        'username' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre de usuario'
        ],
        'pass' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Contraseña cifrada del usuario'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }
}