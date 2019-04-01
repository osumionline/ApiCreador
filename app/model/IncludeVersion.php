<?php
class IncludeVersion extends OBase{
  function __construct(){
    $table_name  = 'include_version';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id unico de la version del include'
        ],
        'id_include_type' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Id del tipo de include',
          'ref'      => 'include_type.id'
        ],
        'version' => [
          'type'     => Base::TEXT,
          'size'     => 10,
          'nullable' => false,
          'comment'  => 'Número de versión del tipo de include'
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