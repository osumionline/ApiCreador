<?php
class userService extends OService{
  function __construct($controller=null){
    $this->setController($controller);
  }

  public function getProjects($id_user){
    $db = $this->getController()->getDB();
    $sql = "SELECT * FROM `project` WHERE `id_user` = ?";
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
    $db = $this->getController()->getDB();
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
    $db = $this->getController()->getDB();
    $sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` = ?";
    $db->query($sql, [$id_configuration]);
  }

  public function cleanDeletedRows($id_model, $model_row_ids){
    $db = $this->getController()->getDB();
    $in  = str_repeat('?,', count($model_row_ids) - 1) . '?';
    array_unshift($model_row_ids, $id_model);
    $sql = "DELETE FROM `row` WHERE `id_model` = ? AND `id` NOT IN (".$in.")";
    $db->query($sql, $model_row_ids);
  }

  public function updateProjectIncludes($id_project, $project_includes){
    $db = $this->getController()->getDB();
    $sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
    $db->query($sql, [$id_project]);
    foreach ($project_includes as $inc){
      $pri = new ProjectInclude();
      $pri->set('id_project', $id_project);
      $pri->set('id_type', $inc);
      $pri->save();
    }
  }

  public function getProjectConfigurationLists($id_configuration){
    $db = $this->getController()->getDB();
    $sql = "SELECT * FROM `project_config_list_item` WHERE `id_project_config` = ?";
    $db->query($sql, [$id_configuration]);
    $ret = ['css' => [], 'css_ext' => [], 'js' => [], 'js_ext' => [], 'libs' => [], 'extra' => [], 'dir' => []];

    while ($res = $db->next()){
      $prcli = new ProjectConfigListItem();
      $prcli->update($res);

      switch ($prcli->get('type')){
        case 0: { array_push($ret['css'], '"'.urlencode($prcli->get('value')).'"'); }
        break;
        case 1: { array_push($ret['css_ext'], '"'.urlencode($prcli->get('value')).'"'); }
        break;
        case 2: { array_push($ret['js'], '"'.urlencode($prcli->get('value')).'"'); }
        break;
        case 3: { array_push($ret['js_ext'], '"'.urlencode($prcli->get('value')).'"'); }
        break;
        case 4: { array_push($ret['libs'], '"'.urlencode($prcli->get('value')).'"'); }
        break;
        case 5: { array_push($ret['extra'], ['key' => urlencode($prcli->get('key')), 'value' => urlencode($prcli->get('value'))]); }
        break;
        case 6: { array_push($ret['dir'], ['key' => urlencode($prcli->get('key')), 'value' => urlencode($prcli->get('value'))]); }
        break;
      }
    }

    return $ret;
  }

  public function getProjectModels($id_project){
    $db = $this->getController()->getDB();
    $sql = "SELECT * FROM `model` WHERE `id_project` = ?";
    $db->query($sql, [$id_project]);
    $ret = [];

    while ($res = $db->next()){
      $model = new Model();
      $model->update($res);

      array_push($ret, $model);
    }

    return $ret;
  }

  public function getProjectIncludes($id_project){
    $db = $this->getController()->getDB();
    $sql = "SELECT * FROM `project_include` WHERE `id_project` = ?";
    $db->query($sql, [$id_project]);
    $ret = [];

    while ($res = $db->next()){
      $pri = new ProjectInclude();
      $pri->update($res);

      array_push($ret, $pri->get('id_type'));
    }

    return $ret;
  }
}