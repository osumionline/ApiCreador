<?php
class ProjectConfigListItem extends OModel{
  function __construct(){
    $table_name  = 'project_config_list_item';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único para cada proyecto'
        ],
        'id_project_config' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Id de la configuración a la que hace referencia',
          'ref'      => 'project_config.id'
        ],
        'type' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir'
        ],
        'key' => [
          'type'     => OCore::TEXT,
          'size'     => 20,
          'nullable' => true,
          'default'  => null,
          'comment'  => 'Clave para los tipos extra y dir'
        ],
        'value' => [
          'type'     => OCore::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Valor del elemento de lista'
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