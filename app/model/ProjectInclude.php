<?php
class ProjectInclude extends OBase{
  function __construct(){
    $table_name  = 'project_include';
    $model = [
        'id_project' => [
          'type'    => Base::PK,
          'comment' => 'Id del proyecto en el que se incluye',
          'incr'    => false
        ],
        'id_type' => [
          'type'    => Base::PK,
          'comment' => 'Id del tipo de include',
          'incr'    => false
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