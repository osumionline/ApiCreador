<?php
class api extends OController{
  private $user_service;
  private $project_service;

  function __construct(){
    $this->user_service = new userService($this);
    $this->project_service = new projectService($this);
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
      $crypt = new OCrypt( $this->getConfig()->getExtra('crypt_key') );

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

      $prc = new projectConfig();
      if (!is_null($project['id'])){
        $prc->find(['id_project'=>$project['id']]);
      }
      else{
        $prc->set('id_project', $pr->get('id'));
      }
      if ($projectConfiguration['hasDB']){
        $prc->set('db_host', $projectConfiguration['dbHost']);
        $prc->set('db_user', $projectConfiguration['dbUser']);
        $prc->set('db_name', $projectConfiguration['dbName']);
        if (is_null($project['id']) || (!is_null($project['id']) && $projectConfiguration['dbPass']!='')){
          $prc->set('db_pass', $crypt->encrypt($projectConfiguration['dbPass']));
        }
      }
      else{
        $prc->set('db_host', null);
        $prc->set('db_user', null);
        $prc->set('db_pass', null);
        $prc->set('db_name', null);
      }
      $prc->set('cookies_prefix',    ($projectConfiguration['cookiesPrefix']=='') ? null : $projectConfiguration['cookiesPrefix']);
      $prc->set('cookies_url',       ($projectConfiguration['cookiesUrl']=='')    ? null : $projectConfiguration['cookiesUrl']);
      $prc->set('module_browser',    $projectConfiguration['modBrowser']);
      $prc->set('module_email',      $projectConfiguration['modEmail']);
      $prc->set('module_email_smtp', $projectConfiguration['modEmailSmtp']);
      $prc->set('module_ftp',        $projectConfiguration['modFtp']);
      $prc->set('module_image',      $projectConfiguration['modImage']);
      $prc->set('module_pdf',        $projectConfiguration['modPdf']);
      $prc->set('module_translate',  $projectConfiguration['modTranslate']);
      $prc->set('module_crypt',      $projectConfiguration['modCrypt']);
      $prc->set('module_file',       $projectConfiguration['modFile']);
      if ($projectConfiguration['modEmailSmtp']){
        $prc->set('smtp_host',   $projectConfiguration['smtpHost']);
        $prc->set('smtp_user',   $projectConfiguration['smtpUser']);
        $prc->set('smtp_port',   $projectConfiguration['smtpPort']);
        $prc->set('smtp_secure', $projectConfiguration['smtpSecure']);
        if (is_null($project['id']) || (!is_null($project['id']) && $projectConfiguration['smtpPass']!='')){
          $prc->set('smtp_pass',   $crypt->encrypt($projectConfiguration['smtpPass']));
        }
      }
      else{
        $prc->set('smtp_host',   null);
        $prc->set('smtp_user',   null);
        $prc->set('smtp_pass',   null);
        $prc->set('smtp_port',   null);
        $prc->set('smtp_secure', null);
      }
      $prc->set('base_url',      ($projectConfiguration['baseUrl']=='')      ? null : $projectConfiguration['baseUrl']);
      $prc->set('admin_email',   ($projectConfiguration['adminEmail']=='')   ? null : $projectConfiguration['adminEmail']);
      $prc->set('default_title', ($projectConfiguration['defaultTitle']=='') ? null : $projectConfiguration['defaultTitle']);
      $prc->set('lang',          ($projectConfiguration['lang']=='')         ? null : $projectConfiguration['lang']);
      $prc->set('error_403',     ($projectConfiguration['error403']=='')     ? null : $projectConfiguration['error403']);
      $prc->set('error_404',     ($projectConfiguration['error404']=='')     ? null : $projectConfiguration['error404']);
      $prc->set('error_500',     ($projectConfiguration['error500']=='')     ? null : $projectConfiguration['error500']);

      $prc->save();

      $this->user_service->cleanProjectConfigurationLists($prc->get('id'));

      foreach ($projectConfigurationLists['css'] as $value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 0);
        $prcli->set('key', null);
        $prcli->set('value', $value);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['cssExt'] as $value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 1);
        $prcli->set('key', null);
        $prcli->set('value', $value);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['js'] as $value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 2);
        $prcli->set('key', null);
        $prcli->set('value', $value);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['jsExt'] as $value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 3);
        $prcli->set('key', null);
        $prcli->set('value', $value);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['extra'] as $key_value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 4);
        $prcli->set('key', $key_value['key']);
        $prcli->set('value', $key_value['value']);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['libs'] as $value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 5);
        $prcli->set('key', null);
        $prcli->set('value', $value);
        $prcli->save();
      }
      foreach ($projectConfigurationLists['dir'] as $key_value) {
        $prcli = new ProjectConfigListItem();
        $prcli->set('id_project_config', $prc->get('id'));
        $prcli->set('type', 6);
        $prcli->set('key', $key_value['key']);
        $prcli->set('value', $key_value['value']);
        $prcli->save();
      }

      foreach ($projectModel as $model){
        $prm = new Model();
        if (!is_null($model['id'])){
          $prm->find(['id'=>$model['id']]);
        }
        else{
          $prm->set('id_project', $pr->get('id'));
        }
        $prm->set('name',       $model['name']);
        $prm->set('table_name', $model['tableName']);
        $prm->save();
        $model_row_ids = [];

        foreach ($model['rows'] as $ind => $row){
          $prmr = new Row();
          if (!is_null($row['id'])){
            $prmr->find(['id'=>$row['id']]);
          }
          else{
            $prmr->set('id_model', $prm->get('id'));
          }
          $prmr->set('name',           $row['name']);
          $prmr->set('type',           $row['type']);
          $prmr->set('size',           ($row['size']=='') ? null : $row['size']);
          $prmr->set('auto_increment', $row['autoIncrement']);
          $prmr->set('nullable',       $row['nullable']);
          $prmr->set('default',        ($row['defaultValue']=='') ? null : $row['defaultValue']);
          $prmr->set('ref',            ($row['ref']=='')          ? null : $row['ref']);
          $prmr->set('comment',        ($row['comment']=='')      ? null : $row['comment']);
          $prmr->set('order',          $ind);
          $prmr->save();

          array_push($model_row_ids, $prmr->get('id'));
        }

        $this->user_service->cleanDeletedRows($prm->get('id'), $model_row_ids);
      }

      $project_includes = [];
      foreach ($includeTypes as $inc){
        if (array_key_exists('selected', $inc)){
          array_push($project_includes, $inc['selected']);
        }
      }
      $this->user_service->updateProjectIncludes($pr->get('id'), $project_includes);
    }

    $this->getTemplate()->add('status', $status);
  }

  /*
   * Función para obtener los detalles de un proyecto
   */
  function getProject($req){
    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);
    $project       = null;
    $configuration = null;
    $lists         = null;
    $models        = null;
    $includes      = null;

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $project = new Project();
      if ($project->find(['id' => $id])){
        $configuration = $project->getProjectConfig();
        $lists         = $configuration->getProjectConfigurationLists();
        $models        = $project->getProjectModels();
        $includes      = $project->getProjectIncludes();
      }
      else{
        // No encuentro el proyecto
        $project = null;
        $status  = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('project',       'project/project',       ['project'       => $project,       'extra' => 'nourlencode']);
    $this->getTemplate()->addPartial('configuration', 'project/configuration', ['configuration' => $configuration, 'extra' => 'nourlencode']);
    $this->getTemplate()->addPartial('lists',         'project/lists',         ['lists'         => $lists,         'extra' => 'nourlencode']);
    $this->getTemplate()->addPartial('models',        'project/models',        ['models'        => $models,        'extra' => 'nourlencode']);
    $this->getTemplate()->addPartial('includes',      'project/includes',      ['includes'      => $includes,      'extra' => 'nourlencode']);
  }

  /*
   * Función para borrar un proyecto
   */
  function deleteProject($req){
    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $pr = new Project();
      if ($pr->find(['id'=>$id])){
        $pr->deleteFull();
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
  }

  /*
   * Función para generar el descargable de un proyecto
   */
  function generateProject($req){
    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $step   = Base::getParam('step', $req['url_params'], false);
    $date   = '';

    if ($id===false || $step===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $pr = new Project();
      if ($pr->find(['id'=>$id])){
        if ($pr->get('id_user')==$req['filter']['id']){
          switch($step){
            case 0: { $this->project_service->createBasicStructure($pr); }
            break;
            case 1: { $this->project_service->createConfigFile($pr); }
            break;
            case 2: { $this->project_service->createModels($pr); }
            break;
            case 3: { $this->project_service->addIncludes($pr); }
            break;
            case 4: {
              $this->project_service->packToZip($pr);
              $date = date('Y-m-d H:i:s', time());

              $pr->set('last_compilation', $date);
              $pr->save();
            }
            break;
          }
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
    $this->getTemplate()->add('date',   $date);
  }
}