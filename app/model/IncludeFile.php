<?php
class IncludeFile extends OBase{
  function __construct(){
    $table_name  = 'include_file';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único para cada archivo a incluir'
        ],
        'id_include_version' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Id de la version del include',
          'ref'      => 'include_version.id'
        ],
        'type' => [
          'type'     => Base::NUM,
          'nullable' => false,
          'comment'  => 'Tipo de archivo 0 CSS 1 JS'
        ],
        'filename' => [
          'type'     => Base::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre del archivo a incluir'
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