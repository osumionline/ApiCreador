<?php
class Project extends OModel{
  function __construct(){
    $table_name  = 'project';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único para cada proyecto'
        ],
        'id_user' => [
          'type'     => OCore::NUM,
          'nullable' => false,
          'comment'  => 'Id del usuario dueño del proyecto',
          'ref'      => 'user.id'
        ],
        'name' => [
          'type'     => OCore::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Nombre del proyecto'
        ],
        'slug' => [
          'type'     => OCore::TEXT,
          'size'     => 50,
          'nullable' => false,
          'comment'  => 'Slug del nombre del proyecto'
        ],
        'description' => [
          'type'     => OCore::LONGTEXT,
          'nullable' => true,
          'comment'  => 'Descripción del proyecto'
        ],
        'last_compilation' => [
          'type'     => OCore::DATE,
          'nullable' => true,
          'default'  => null,
          'comment'  => 'Fecha de la última compilación'
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

  public function deleteFull(){
    $sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
    $this->db->query($sql, [$this->get('id')]);
    $sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` IN (SELECT `id` FROM `project_config` WHERE `id_project` = ?)";
    $this->db->query($sql, [$this->get('id')]);
    $sql = "DELETE FROM `project_config` WHERE `id_project` = ?";
    $this->db->query($sql, [$this->get('id')]);
    $sql = "DELETE FROM `row` WHERE `id_model` IN (SELECT `id` FROM `model` WHERE `id_project` = ?)";
    $this->db->query($sql, [$this->get('id')]);
    $sql = "DELETE FROM `model` WHERE `id_project` = ?";
    $this->db->query($sql, [$this->get('id')]);

    $this->delete();
  }

  private $project_config = null;

  public function getProjectConfig(){
    if (is_null($this->project_config)){
      $this->loadProjectConfig();
    }
    return $this->project_config;
  }

  public function setProjectConfig($conf){
    $this->project_config = $conf;
  }

  private function loadProjectConfig(){
    $conf = new ProjectConfig();
    $conf->find(['id_project'=>$this->get('id')]);
    $this->setProjectConfig($conf);
  }

  private $project_models = null;

  public function getProjectModels(){
    if (is_null($this->project_models)){
      $this->loadProjectModels();
    }
    return $this->project_models;
  }

  public function setProjectModels($models){
    $this->project_models = $models;
  }

  private function loadProjectModels(){
    $sql = "SELECT * FROM `model` WHERE `id_project` = ?";
    $this->db->query($sql, [$this->get('id')]);
    $models = [];

    while ($res = $this->db->next()){
      $model = new Model();
      $model->update($res);

      array_push($models, $model);
    }

    $this->setProjectModels($models);
  }

  private $project_includes = null;

  public function getProjectIncludes(){
    if (is_null($this->project_includes)){
      $this->loadProjectIncludes();
    }
    return $this->project_includes;
  }

  public function setProjectIncludes($includes){
    $this->project_includes = $includes;
  }

  private function loadProjectIncludes(){
    $sql = "SELECT * FROM `project_include` WHERE `id_project` = ?";
    $this->db->query($sql, [$this->get('id')]);
    $includes = [];

    while ($res = $this->db->next()){
      $pri = new ProjectInclude();
      $pri->update($res);

      array_push($includes, $pri->get('id_type'));
    }

    $this->setProjectIncludes($includes);
  }

  private $project_include_versions = null;

  public function getProjectIncludeVersions(){
    if (is_null($this->project_include_versions)){
      $this->loadProjectIncludeVersions();
    }
    return $this->project_include_versions;
  }

  public function setProjectIncludeVersions($versions){
    $this->project_include_versions = $versions;
  }

  private function loadProjectIncludeVersions(){
    $sql = "SELECT * FROM `include_version` WHERE `id` IN (SELECT `id_type` FROM `project_include` WHERE `id_project` = ?)";
    $this->db->query($sql, [$this->get('id')]);
    $versions = [];

    while ($res = $this->db->next()){
      $ver = new IncludeVersion();
      $ver->update($res);

      array_push($versions, $ver);
    }

    $this->setProjectIncludeVersions($versions);
  }
}