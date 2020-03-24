<?php
class IncludeVersion extends OModel{
  function __construct(){
    $table_name  = 'include_version';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id unico de la version del include'
        ],
        'id_include_type' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Id del tipo de include',
          'ref'      => 'include_type.id'
        ],
        'version' => [
          'type'     => OCore::TEXT,
          'size'     => 10,
          'nullable' => false,
          'comment'  => 'Número de versión del tipo de include'
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

  private $include_files = null;

  public function getIncludeFiles(){
    if (is_null($this->include_files)){
      $this->loadIncludeFiles();
    }
    return $this->include_files;
  }

  public function setIncludeFiles($files){
    $this->include_files = $files;
  }

  private function loadIncludeFiles(){
    $sql = "SELECT * FROM `include_file` WHERE `id_include_version` = ?";
    $this->db->query($sql, [$this->get('id')]);
    $files = [];

    while ($res=$this->db->next()){
      $inc_file = new IncludeFile();
      $inc_file->update($res);

      array_push($files, $inc_file);
    }

    $this->setIncludeFiles($files);
  }
}