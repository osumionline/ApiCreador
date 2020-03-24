<?php
class Model extends OModel{
  function __construct(){
    $table_name  = 'model';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único para cada modelo'
        ],
        'id_project' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Id del proyecto al que pertenece el modelo',
          'ref'      => 'project.id'
        ],
        'name' => [
          'type'     => OCore::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Nombre del modelo'
        ],
        'table_name' => [
          'type'     => OCore::TEXT,
          'size'     => 100,
          'nullable' => false,
          'comment'  => 'Nombre de la tabla en la base de datos'
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

  private $rows = null;

  public function getRows(){
    if (is_null($this->rows)){
      $this->loadRows();
    }
    return $this->rows;
  }

  public function setRows($rows){
    $this->rows = $rows;
  }

  public function loadRows(){
    $sql = "SELECT * FROM `row` WHERE `id_model` = ? ORDER BY `order`";
    $this->db->query($sql, [$this->get('id')]);
    $rows = [];

    while ($res = $this->db->next()){
      $row = new Row();
      $row->update($res);
      array_push($rows, $row);
    }

    $this->setRows($rows);
  }
}