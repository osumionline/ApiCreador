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
}