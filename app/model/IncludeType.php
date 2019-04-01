<?php
class IncludeType extends OBase{
  function __construct(){
    $table_name  = 'include_type';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para tipo de include'
        ],
        'name' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre del tipo de include'
        ],
        'show_include' => [
          'type'     => Base::BOOL,
          'nullable' => false,
          'default'  => true,
          'comment'  => 'Indica si debe mostrarse en la lista de includes disponibles'
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