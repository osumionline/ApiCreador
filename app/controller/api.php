<?php
class api extends OController{
  private $user_service;

  function __construct(){
    $this->user_service  = new userService($this);
  }

  /*
   * Function to get the date
   */
  function getDate($req){
    $this->getTemplate()->add('date', $this->user_service->getLastUpdate());
  }
}
