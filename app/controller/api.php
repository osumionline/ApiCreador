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

  /*
   * Función para guardar un proyecto
   */
  function saveProject($req){
    $status = 'ok';
    $project                   = Base::getParam('project',                   $req['url_params'], false);
    $projectConfiguration      = Base::getParam('projectConfiguration',      $req['url_params'], false);
    $projectConfigurationLists = Base::getParam('projectConfigurationLists', $req['url_params'], false);
    $projectModel              = Base::getParam('projectModel',              $req['url_params'], false);
    $includeTypes              = Base::getParam('includeTypes',              $req['url_params'], false);

    if ($project===false || $projectConfiguration===false || $projectConfigurationLists===false || $projectModel===false || $includeTypes===false){
      $status = false;
    }

    if ($status=='ok'){
      $pr = new Project();
      if (!is_null($project['id'])){
        $pr->find(['id'=>$project['id']]);
      }
      else{
        $pr->set('id_user', $req['filter']['id']);
      }
      $pr->set('name', $project['name']);
      $pr->set('slug', Base::slugify($project['name']));
      $pr->set('description', $project['description']);
      $pr->save();

      $prc = new projectConfiguration();
      if (!is_null($project['id'])){
        $prc->find(['id_project'=>$project['id']]);
      }
      else{
        $prc->set('id_project', $pr->get('id'));
      }
      if ($projectConfiguration['hasDB']){
        $prc->set('db_host', $projectConfiguration['dbHost']);
        $prc->set('db_user', $projectConfiguration['dbUser']);
        $prc->set('db_pass', $projectConfiguration['dbPass']);
        $prc->set('db_name', $projectConfiguration['dbName']);
      }
    }
    /*
    array(5) {
        ["project"]=>
        array(4) {
          ["id"]=>
          NULL
          ["name"]=>
          string(14) "Nuevo proyecto"
          ["slug"]=>
          string(14) "nuevo-proyecto"
          ["description"]=>
          string(0) ""
        }
        ["projectConfiguration"]=>
        array(26) {
          ["baseUrl"]=>
          string(18) "https://prueba.com"
          ["adminEmail"]=>
          string(25) "inigo.gorosabel@gmail.com"
          ["defaultTitle"]=>
          string(6) "Prueba"
          ["lang"]=>
          string(2) "es"
          ["hasDB"]=>
          bool(true)
          ["dbHost"]=>
          string(9) "localhost"
          ["dbName"]=>
          string(6) "prueba"
          ["dbUser"]=>
          string(4) "user"
          ["dbPass"]=>
          string(4) "pass"
          ["cookiesPrefix"]=>
          string(0) ""
          ["cookiesUrl"]=>
          string(0) ""
          ["modBrowser"]=>
          bool(false)
          ["modEmail"]=>
          bool(true)
          ["modEmailSmtp"]=>
          bool(true)
          ["modFtp"]=>
          bool(false)
          ["modImage"]=>
          bool(false)
          ["modPdf"]=>
          bool(false)
          ["modTranslate"]=>
          bool(false)
          ["smtpHost"]=>
          string(8) "hostsmtp"
          ["smtpPort"]=>
          string(3) "487"
          ["smtpSecure"]=>
          string(3) "TLS"
          ["smtpUser"]=>
          string(8) "usersmtp"
          ["smtpPass"]=>
          string(8) "passsmtp"
          ["error403"]=>
          string(0) ""
          ["error404"]=>
          string(28) "https://prueba.com/not-found"
          ["error500"]=>
          string(0) ""
        }
        ["projectConfigurationLists"]=>
        array(7) {
          ["css"]=>
          array(1) {
            [0]=>
            string(6) "common"
          }
          ["cssExt"]=>
          array(0) {
          }
          ["js"]=>
          array(1) {
            [0]=>
            string(6) "common"
          }
          ["jsExt"]=>
          array(0) {
          }
          ["libs"]=>
          array(0) {
          }
          ["extra"]=>
          array(1) {
            [0]=>
            array(2) {
              ["key"]=>
              string(7) "api_key"
              ["value"]=>
              string(30) "afjbefjsifuano93rh29fhufh9qhfq"
            }
          }
          ["dir"]=>
          array(1) {
            [0]=>
            array(2) {
              ["key"]=>
              string(8) "includes"
              ["value"]=>
              string(17) "/var/www/includes"
            }
          }
        }
        ["projectModel"]=>
        array(1) {
          [0]=>
          array(3) {
            ["name"]=>
            string(4) "User"
            ["tableName"]=>
            string(4) "user"
            ["rows"]=>
            array(5) {
              [0]=>
              array(8) {
                ["name"]=>
                string(2) "id"
                ["type"]=>
                string(1) "1"
                ["size"]=>
                NULL
                ["autoIncrement"]=>
                bool(true)
                ["nullable"]=>
                bool(true)
                ["defaultValue"]=>
                string(0) ""
                ["ref"]=>
                string(0) ""
                ["comment"]=>
                string(24) "Id unico de cada usuario"
              }
              [1]=>
              array(8) {
                ["name"]=>
                string(8) "username"
                ["type"]=>
                string(1) "6"
                ["size"]=>
                string(2) "50"
                ["autoIncrement"]=>
                bool(false)
                ["nullable"]=>
                bool(false)
                ["defaultValue"]=>
                string(0) ""
                ["ref"]=>
                string(0) ""
                ["comment"]=>
                string(17) "Nombre de usuario"
              }
              [2]=>
              array(8) {
                ["name"]=>
                string(4) "pass"
                ["type"]=>
                string(1) "6"
                ["size"]=>
                string(3) "100"
                ["autoIncrement"]=>
                bool(false)
                ["nullable"]=>
                bool(false)
                ["defaultValue"]=>
                string(0) ""
                ["ref"]=>
                string(0) ""
                ["comment"]=>
                string(31) "Contraseña cifrada del usuario"
              }
              [3]=>
              array(8) {
                ["name"]=>
                string(10) "created_at"
                ["type"]=>
                string(1) "3"
                ["size"]=>
                NULL
                ["autoIncrement"]=>
                bool(false)
                ["nullable"]=>
                bool(true)
                ["defaultValue"]=>
                string(0) ""
                ["ref"]=>
                string(0) ""
                ["comment"]=>
                string(31) "Fecha de creación del registro"
              }
              [4]=>
              array(8) {
                ["name"]=>
                string(10) "updated_at"
                ["type"]=>
                string(1) "4"
                ["size"]=>
                NULL
                ["autoIncrement"]=>
                bool(false)
                ["nullable"]=>
                bool(true)
                ["defaultValue"]=>
                string(0) ""
                ["ref"]=>
                string(0) ""
                ["comment"]=>
                string(43) "Fecha de última modificación del registro"
              }
            }
          }
        }
        ["includeTypes"]=>
        array(4) {
          [0]=>
          array(4) {
            ["id"]=>
            int(2)
            ["name"]=>
            string(7) "Angular"
            ["versions"]=>
            array(1) {
              [0]=>
              array(2) {
                ["id"]=>
                int(2)
                ["version"]=>
                string(5) "1.7.8"
              }
            }
            ["selected"]=>
            int(2)
          }
          [1]=>
          array(4) {
            ["id"]=>
            int(3)
            ["name"]=>
            string(16) "Angular+Material"
            ["versions"]=>
            array(1) {
              [0]=>
              array(2) {
                ["id"]=>
                int(3)
                ["version"]=>
                string(6) "1.1.18"
              }
            }
            ["selected"]=>
            int(3)
          }
          [2]=>
          array(3) {
            ["id"]=>
            int(4)
            ["name"]=>
            string(9) "Bootstrap"
            ["versions"]=>
            array(1) {
              [0]=>
              array(2) {
                ["id"]=>
                int(4)
                ["version"]=>
                string(5) "4.1.3"
              }
            }
          }
          [3]=>
          array(3) {
            ["id"]=>
            int(1)
            ["name"]=>
            string(6) "jQuery"
            ["versions"]=>
            array(1) {
              [0]=>
              array(2) {
                ["id"]=>
                int(1)
                ["version"]=>
                string(5) "3.3.1"
              }
            }
          }
        }
      }
    */

    $this->getTemplate()->add('status', $status);
  }
}