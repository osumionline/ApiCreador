<?php
class IncludeFile extends OModel{
  function __construct(){
    $table_name  = 'include_file';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único para cada archivo a incluir'
        ],
        'id_include_version' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Id de la version del include',
          'ref'      => 'include_version.id'
        ],
        'type' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Tipo de archivo 0 CSS 1 JS'
        ],
        'filename' => [
          'type'     => OCore::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre del archivo a incluir'
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