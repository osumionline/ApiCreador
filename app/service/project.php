<?php
class projectService extends OService{
  function __construct($controller=null){
    $this->setController($controller);
  }

  public function createBasicStructure($project){
    $c = $this->getController()->getConfig();
    $route = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/project_'.$project->get('id');
    if (file_exists($route)){
      OFile::rrmdir($route);
    }
    mkdir($route);

    $folder_list = OFile::getOFWFolders();

    foreach ($folder_list as $folder){
      mkdir($route.'/'.$folder, 0777, true);
    }

    $file_list = OFile::getOFWFiles();
    array_push($file_list, ['template'=>'config/translations.json', 'to'=>'app/config/translations.json']);
    array_push($file_list, ['template'=>'config/urls.json', 'to'=>'app/config/urls.json']);
    array_push($file_list, ['template'=>'template/default.php', 'to'=>'app/template/layout/default.php']);
    array_push($file_list, ['template'=>'web/.htaccess', 'to'=>'web/.htaccess']);

    foreach ($file_list as $file){
      if (is_array($file)){
        copy($c->getDir('include').'default/'.$file['template'], $route.'/'.$file['to']);
      }
      else{
        copy($c->getDir('base').$file, $route.'/'.$file);
      }
    }
  }

  public function createConfigFile($project){
    $c = $this->getController()->getConfig();
    $crypt = new OCrypt( $c->getExtra('crypt_key') );
    $route = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/project_'.$project->get('id').'/app/config/config.json';
    if (file_exists($route)){
      unlink($route);
    }

    $configuration = $project->getProjectConfig();
    $lists         = $configuration->getProjectConfigurationLists();

    $conf = "{\n";
    if ($configuration->get('module_browser') ||
        $configuration->get('module_email') ||
        $configuration->get('module_email_smtp') ||
        $configuration->get('module_ftp') ||
        $configuration->get('module_image') ||
        $configuration->get('module_pdf') ||
        $configuration->get('module_translate') ||
        $configuration->get('module_crypt') ||
        $configuration->get('module_file')){
      $conf .= "  \"base_modules\": {\n";
      $conf .= "    \"browser\": ".($configuration->get('module_browser') ? 'true' : 'false').",\n";
      $conf .= "    \"email\": ".($configuration->get('module_email') ? 'true' : 'false').",\n";
      $conf .= "    \"email_smtp\": ".($configuration->get('module_email_smtp') ? 'true' : 'false').",\n";
      $conf .= "    \"ftp\": ".($configuration->get('module_ftp') ? 'true' : 'false').",\n";
      $conf .= "    \"image\": ".($configuration->get('module_image') ? 'true' : 'false').",\n";
      $conf .= "    \"pdf\": ".($configuration->get('module_pdf') ? 'true' : 'false').",\n";
      $conf .= "    \"translate\": ".($configuration->get('module_translate') ? 'true' : 'false').",\n";
      $conf .= "    \"crypt\": ".($configuration->get('module_crypt') ? 'true' : 'false').",\n";
      $conf .= "    \"file\": ".($configuration->get('module_file') ? 'true' : 'false')."\n";
      $conf .= "  },\n";
    }
    if (!is_null($configuration->get('db_host')) || !is_null($configuration->get('db_user')) || !is_null($configuration->get('db_pass')) || !is_null($configuration->get('db_name')) || !is_null($configuration->get('db_charset'))){
      $conf .= "  \"db\": {\n";
      $conf .= "    \"host\": ".(is_null($configuration->get('db_host')) ? "null" : "\"".$configuration->get('db_host')."\"").",\n";
      $conf .= "    \"user\": ".(is_null($configuration->get('db_user')) ? "null" : "\"".$configuration->get('db_user')."\"").",\n";
      $conf .= "    \"pass\": ".(is_null($configuration->get('db_pass')) ? "null" : "\"".$crypt->decrypt($configuration->get('db_pass'))."\"").",\n";
      $conf .= "    \"name\": ".(is_null($configuration->get('db_name')) ? "null" : "\"".$configuration->get('db_name')."\"").",\n";
      $conf .= "    \"charset\": ".(is_null($configuration->get('db_charset')) ? "null" : "\"".$configuration->get('db_charset')."\"")."\n";
      $conf .= "  },\n";
    }
    if (!is_null($configuration->get('cookies_prefix')) || !is_null($configuration->get('cookies_url'))){
      $conf .= "  \"cookies\": {\n";
      $conf .= "    \"prefix\": ".(is_null($configuration->get('cookies_prefix')) ? "null" : "\"".$configuration->get('cookies_prefix')."\"").",\n";
      $conf .= "    \"url\": ".(is_null($configuration->get('cookies_url')) ? "null" : "\"".$configuration->get('cookies_url')."\"")."\n";
      $conf .= "  },\n";
    }
    if (!is_null($configuration->get('base_url'))){
      $conf .= "  \"base_url\": \"".$configuration->get('base_url')."\",\n";
    }
    if (!is_null($configuration->get('admin_email'))){
      $conf .= "  \"admin_email\": \"".$configuration->get('admin_email')."\",\n";
    }
    if (!is_null($configuration->get('default_title'))){
      $conf .= "  \"default_title\": \"".$configuration->get('default_title')."\",\n";
    }
    if (!is_null($configuration->get('lang'))){
      $conf .= "  \"lang\": \"".$configuration->get('lang')."\",\n";
    }
    if (!is_null($configuration->get('smtp_host')) || !is_null($configuration->get('smtp_port')) || !is_null($configuration->get('smtp_secure')) || !is_null($configuration->get('smtp_user')) || !is_null($configuration->get('smtp_pass'))){
      $conf .= "  \"smtp\": {\n";
      $conf .= "    \"host\": ".(is_null($configuration->get('smtp_host')) ? "null" : "\"".$configuration->get('smtp_host')."\"").",\n";
      $conf .= "    \"port\": ".(is_null($configuration->get('smtp_port')) ? "null" : $configuration->get('smtp_port')).",\n";
      $conf .= "    \"secure\": ".(is_null($configuration->get('smtp_secure')) ? "null" : "\"".$configuration->get('smtp_secure')."\"").",\n";
      $conf .= "    \"user\": ".(is_null($configuration->get('smtp_user')) ? "null" : "\"".$configuration->get('smtp_user')."\"").",\n";
      $conf .= "    \"pass\": ".(is_null($configuration->get('smtp_pass')) ? "null" : "\"".$crypt->decrypt($configuration->get('smtp_pass'))."\"").",\n";
      $conf .= "  },\n";
    }
    if (!is_null($configuration->get('error_403')) || !is_null($configuration->get('error_404')) || !is_null($configuration->get('error_500'))){
      $conf .= "  \"error_pages\": {\n";
      $conf .= "    \"403\": ".(is_null($configuration->get('error_403')) ? "null" : "\"".$configuration->get('error_403')."\"").",\n";
      $conf .= "    \"404\": ".(is_null($configuration->get('error_404')) ? "null" : "\"".$configuration->get('error_404')."\"").",\n";
      $conf .= "    \"500\": ".(is_null($configuration->get('error_500')) ? "null" : "\"".$configuration->get('error_500')."\"")."\n";
      $conf .= "  },\n";
    }
    if (count($lists['css'])>0){
      $conf .= "  \"css\": [".implode(', ', $lists['css'])."],\n";
    }
    if (count($lists['css_ext'])>0){
      $conf .= "  \"css_ext\": [".implode(', ', $lists['css_ext'])."],\n";
    }
    if (count($lists['js'])>0){
      $conf .= "  \"js\": [".implode(', ', $lists['js'])."],\n";
    }
    if (count($lists['js_ext'])>0){
      $conf .= "  \"js_ext\": [".implode(', ', $lists['js_ext'])."],\n";
    }
    if (count($lists['libs'])>0){
      $conf .= "  \"libs\": [".implode(', ', $lists['libs'])."],\n";
    }
    if (count($lists['extra'])>0){
      $conf .= "  \"extra\": {\n";
      $extras = [];
      foreach ($lists['extra'] as $item){
        array_push($extras, "    \"".urldecode($item['key'])."\": \"".urldecode($item['value'])."\"");
      }
      $conf .= implode(",\n", $extras);
      $conf .= "\n  },\n";
    }
    if (count($lists['dir'])>0){
      $conf .= "  \"dir\": {\n";
      $dirs = [];
      foreach ($lists['dir'] as $item){
        array_push($dirs, "    \"".urldecode($item['key'])."\": \"".urldecode($item['value'])."\"");
      }
      $conf .= implode(",\n", $dirs);
      $conf .= "\n  },\n";
    }
    $conf .= "  \"debug\": false\n";
    $conf .= "}";

    file_put_contents($route, $conf);
  }

  public function createModels($project){
    $c = $this->getController()->getConfig();
    $models = $project->getProjectModels();

    foreach ($models as $model){
      $route = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/project_'.$project->get('id').'/app/model/'.$model->get('name').'.php';
      if (file_exists($route)){
        unlink($route);
      }

      $mod = "<"."?php\n";
      $mod .= "class ".$model->get('name')." extends OBase{\n";
      $mod .= "  function __construct(){\n";
      $mod .= "    $"."table_name  = '".$model->get('table_name')."';\n";
      $mod .= "    $"."model = [\n";
      $rows = [];
      $types = [1 => 'PK', 10 => 'PK_STR', 2 => 'CREATED', 3 => 'UPDATED', 4 => 'NUM', 5 => 'TEXT', 6 => 'DATE', 7 => 'BOOL', 8 => 'LONGTEXT', 9 => 'FLOAT'];
      foreach ($model->getRows() as $row){
        $str = "      '".$row->get('name')."' => [\n";
        $str .= "        'type'    => Base::".$types[$row->get('type')].",\n";
        if ($row->get('type')==1 && !$row->get('auto_increment')){
          $str .= "        'incr' => false,\n";
        }
        if ($row->get('type')==3 || $row->get('type')==4 || $row->get('type')==5 || $row->get('type')==6 || $row->get('type')==8 || $row->get('type')==9){
          $str .= "        'nullable' => ".($row->get('nullable') ? 'true':'false').",\n";
        }
        if ($row->get('type')==3 || $row->get('type')==4 || $row->get('type')==5 || $row->get('type')==6 || $row->get('type')==8 || $row->get('type')==9){
          $str .= "        'default' => ".(is_null($row->get('default')) ? 'null' : "'".$row->get('default')."'").",\n";
        }
        if (!is_null($row->get('size'))){
          $str .= "        'size' => ".$row->get('size').",\n";
        }
        if (!is_null($row->get('ref'))){
          $str .= "        'ref' => '".$row->get('ref')."',\n";
        }
        $str .= "        'comment' => '".$row->get('comment')."'\n";
        $str .= "      ]";

        array_push($rows, $str);
      }
      $mod .= implode(",\n", $rows);
      $mod .= "\n    ];\n\n";
      $mod .= "    parent::load($"."table_name, $"."model);\n";
      $mod .= "  }\n";
      $mod .= "}";

      file_put_contents($route, $mod);
    }
  }

  private function createRouteIncludes($route){
    if (!file_exists($route)){
      mkdir($route);
    }
  }

  public function addIncludes($project){
    $c = $this->getController()->getConfig();
    $route_web = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/project_'.$project->get('id').'/web/';
    $route_css = $route_web.'css';
    $css_ok    = false;
    $route_js  = $route_web.'js';
    $js_ok     = false;

    $versions = $project->getProjectIncludeVersions();
    foreach ($versions as $version){
      $files = $version->getIncludeFiles();
      foreach ($files as $file){
        // CSS
        if ($file->get('type')==0){
          if (!$css_ok){
            $this->createRouteIncludes($route_css);
            $css_ok = true;
          }
          $route = $c->getDir('include').$version->get('id_include_type').'/'.$version->get('id').'/0/'.$file->get('filename');
          copy ($route, $route_css.'/'.$file->get('filename'));
        }
        // JS
        if ($file->get('type')==1){
          if (!$js_ok){
            $this->createRouteIncludes($route_js);
            $js_ok = true;
          }
          $route = $c->getDir('include').$version->get('id_include_type').'/'.$version->get('id').'/1/'.$file->get('filename');
          copy ($route, $route_js.'/'.$file->get('filename'));
        }
      }
    }
  }

  public function packToZip($project){
    $c         = $this->getController()->getConfig();
    $route     = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/project_'.$project->get('id');
    $route_zip = $c->getDir('ofw_tmp').'user_'.$project->get('id_user').'/'.$project->get('slug').'.zip';

    $zip_file = new OFile();
    $zip_file->zip($route, $route_zip, $project->get('slug'));
    OFile::rrmdir($route);
  }
}