<?php
class Project extends OBase{
  function __construct(){
    $table_name  = 'project';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para cada proyecto'
        ],
        'id_user' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Id del usuario dueño del proyecto',
          'ref'      => 'user.id'
        ],
        'name' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre del proyecto'
        ],
        'slug' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Slug del nombre del proyecto'
        ],
        'description' => [
          'type'     => Base::LONGTEXT,
          'nullable' => true,
          'comment'  => 'Descripción del proyecto'
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