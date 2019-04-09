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

  private $versions = null;

  public function getVersions(){
    if (is_null($this->versions)){
      $this->loadVersions();
    }
    return $this->versions;
  }

  public function setVersions($list){
    $this->versions = $list;
  }

  public function loadVersions(){
    $sql = "SELECT * FROM `include_version` WHERE `id_include_type` = ? ORDER BY `version` DESC";
    $this->db->query($sql, [$this->get('id')]);
    $list = [];

    while ($res = $this->db->next()){
      $ver = new IncludeVersion();
      $ver->update($res);

      array_push($list, $ver);
    }

    $this->setVersions($list);
  }
}