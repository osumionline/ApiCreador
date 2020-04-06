<?php
class userService extends OService{
  function __construct(){
    $this->loadService();
  }

  public function getProjects($id_user){
    $db = new ODB();
    $sql = "SELECT * FROM `project` WHERE `id_user` = ? ORDER BY `updated_at` DESC";
    $db->query($sql, [$id_user]);
    $ret = [];

    while ($res = $db->next()){
      $pr = new Project();
      $pr->update($res);

      array_push($ret, $pr);
    }

    return $ret;
  }

  public function getIncludes(){
    $db = new ODB();
    $sql = "SELECT * FROM `include_type` WHERE `show_include` = 1 ORDER BY `name`";
    $db->query($sql);
    $ret = [];

    while ($res = $db->next()){
      $inc = new IncludeType();
      $inc->update($res);

      array_push($ret, $inc);
    }

    return $ret;
  }

  public function cleanProjectConfigurationLists($id_configuration){
    $db = new ODB();
    $sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` = ?";
    $db->query($sql, [$id_configuration]);
  }

  public function cleanDeletedRows($id_model, $model_row_ids){
    $db = new ODB();
    $in  = str_repeat('?,', count($model_row_ids) - 1) . '?';
    array_unshift($model_row_ids, $id_model);
    $sql = "DELETE FROM `row` WHERE `id_model` = ? AND `id` NOT IN (".$in.")";
    $db->query($sql, $model_row_ids);
  }

  public function updateProjectIncludes($id_project, $project_includes){
    $db = new ODB();
    $sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
    $db->query($sql, [$id_project]);
    foreach ($project_includes as $inc){
      $pri = new ProjectInclude();
      $pri->set('id_project', $id_project);
      $pri->set('id_type', $inc);
      $pri->save();
    }
  }
}