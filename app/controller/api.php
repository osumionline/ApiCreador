<?php
class api extends OController{
  private $user_service;

  function __construct(){
    $this->user_service = new userService($this);
  }

  /*
   * Función para iniciar sesión en la aplicación
   */
  function login($req){
    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $pass   = Base::getParam('pass', $req['url_params'], false);

    $id    = 'null';
    $token = '';

    if ($name===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $u = new User();
      if ($u->find(['username'=>$name])){
        if (password_verify($pass, $u->get('pass'))){
          $id = $u->get('id');

          $tk = new OToken($this->getConfig()->getExtra('secret'));
          $tk->addParam('id',   $id);
          $tk->addParam('name', $name);
          $tk->addParam('exp', mktime() + (24 * 60 * 60));
          $token = $tk->getToken();
        }
        else{
          $status = 'error';
        }
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('id',     $id);
    $this->getTemplate()->add('name',   $name);
    $this->getTemplate()->add('token',  $token);
  }

  /*
   * Función para registrarse en la aplicación
   */
  function register($req){
    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $pass   = Base::getParam('pass', $req['url_params'], false);
    $id     = 'null';
    $token  = '';

    if ($name===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $u = new User();
      if ($u->find(['username'=>$name])){
        $status = 'error-user';
      }
      else{
        $u->set('username', $name);
        $u->set('pass',     password_hash($pass, PASSWORD_BCRYPT));
        $u->save();

        $id = $u->get('id');

        $tk = new OToken($this->getConfig()->getExtra('secret'));
        $tk->addParam('id',   $id);
        $tk->addParam('name', $name);
        $tk->addParam('exp', mktime() + (24 * 60 * 60));
        $token = $tk->getToken();
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('id',     $id);
    $this->getTemplate()->add('name',   $name);
    $this->getTemplate()->add('token',  $token);
  }

  /*
   * Función para obtener la lista de proyectos
   */
  function getProjects($req){
    $status = 'ok';
    $id     = $req['filter']['id'];
    $list   = [];

    if (!$id){
      $status = 'error';
    }

    if ($status=='ok'){
      $list = $this->user_service->getProjects($id);
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('list', 'api/project_list', ['list' => $list, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener la lista de includes para añadir a un proyecto
   */
  function getIncludes($req){
    $status = 'ok';
    $id     = $req['filter']['id'];
    $list   = [];

    if (!$id){
      $status = 'error';
    }

    if ($status=='ok'){
      $list = $this->user_service->getIncludes();
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('list', 'api/include_list', ['list' => $list, 'extra'=>'nourlencode']);
  }
}