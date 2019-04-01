<?php
class Model extends OBase{
  function __construct(){
    $table_name  = 'model';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para cada modelo'
        ],
        'id_project' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Id del proyecto al que pertenece el modelo',
          'ref'      => 'project.id'
        ],
        'name' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Nombre del modelo'
        ],
        'table_name' => [
          'type'     => Base::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Nombre de la tabla en la base de datos'
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