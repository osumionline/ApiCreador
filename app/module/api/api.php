<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Core\OModule;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Routing\ORoute;
use OsumiFramework\App\Model\Model;
use OsumiFramework\App\Model\ProjectConfig;
use OsumiFramework\App\Model\Row;
use OsumiFramework\App\Model\ProjectConfigListItem;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Model\Project;
use OsumiFramework\App\Service\userService;
use OsumiFramework\App\Service\projectService;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\OFW\Plugins\OCrypt;

#[ORoute(
	type: 'json',
	prefix: '/api'
)]
class api extends OModule {
	private ?userService $user_service = null;
	private ?projectService $project_service = null;

	function __construct(){
		$this->user_service = new userService();
		$this->project_service = new projectService();
	}

	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/login')]
	public function login(ORequest $req): void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$pass   = $req->getParamString('pass');

		$id    = 'null';
		$token = '';

		if (is_null($name) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['username'=>$name])) {
				if (password_verify($pass, $u->get('pass'))) {
					$id = $u->get('id');

					$tk = new OToken($this->getConfig()->getExtra('secret'));
					$tk->addParam('id',   $id);
					$tk->addParam('name', $name);
					$tk->addParam('exp', time() + (24 * 60 * 60));
					$token = $tk->getToken();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para registrarse en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/register')]
	public function register(ORequest $req): void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$pass   = $req->getParamString('pass');
		$id     = 'null';
		$token  = '';

		if (is_null($name) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['username'=>$name])) {
				$status = 'error-user';
			}
			else {
				$u->set('username', $name);
				$u->set('pass',     password_hash($pass, PASSWORD_BCRYPT));
				$u->save();

				$id = $u->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $id);
				$tk->addParam('name', $name);
				$tk->addParam('exp', time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para modificar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/saveSettings',
		filter: 'loginFilter'
	)]
	public function saveSettings(ORequest $req): void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$pass   = $req->getParamString('pass');
		$filter = $req->getFilter('loginFilter');
		$id     = 'null';
		$token  = '';

		if (is_null($name) || is_null($pass)  || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['username'=>$name]) && $u->get('id') != $filter['id']) {
				$status = 'error-user';
			}
			else {
				$u->set('username', $name);
				$u->set('pass',     password_hash($pass, PASSWORD_BCRYPT));
				$u->save();

				$id = $u->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $id);
				$tk->addParam('name', $name);
				$tk->addParam('exp', time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para obtener la lista de proyectos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-projects',
		filter: 'loginFilter'
	)]
	public function getProjects(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('loginFilter');
		$list   = [];

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok'){
			$list = $this->user_service->getProjects($filter['id']);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'api/project_list', ['list' => $list, 'extra'=>'nourlencode']);
	}

	/**
	 * Función para obtener la lista de includes para añadir a un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-includes',
		filter: 'loginFilter'
	)]
	public function getIncludes(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('loginFilter');
		$list   = [];

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok'){
			$list = $this->user_service->getIncludes();
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'api/include_list', ['list' => $list, 'extra'=>'nourlencode']);
	}

	/**
	 * Función para guardar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-project',
		filter: 'loginFilter'
	)]
	public function saveProject(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('loginFilter');

		$project                   = $req->getParam('project',                   false);
		$projectConfiguration      = $req->getParam('projectConfiguration',      false);
		$projectConfigurationLists = $req->getParam('projectConfigurationLists', false);
		$projectModel              = $req->getParam('projectModel',              false);
		$includeTypes              = $req->getParam('includeTypes',              false);

		if (is_null($filter) || !array_key_exists('id', $filter) || $project===false || $projectConfiguration===false || $projectConfigurationLists===false || $projectModel===false || $includeTypes===false) {
			$status = false;
		}

		if ($status=='ok') {
			$crypt = new OCrypt( $this->getConfig()->getExtra('crypt_key') );

			$pr = new Project();
			if (!is_null($project['id'])) {
				$pr->find(['id'=>$project['id']]);
			}
			else {
				$pr->set('id_user', $filter['id']);
			}
			$pr->set('name', $project['name']);
			$pr->set('slug', OTools::slugify($project['name']));
			$pr->set('description', $project['description']);
			$pr->save();

			$prc = new projectConfig();
			if (!is_null($project['id'])) {
				$prc->find(['id_project'=>$project['id']]);
			}
			else {
				$prc->set('id_project', $pr->get('id'));
			}
			if ($projectConfiguration['hasDB']) {
				$prc->set('db_host',    $projectConfiguration['dbHost']);
				$prc->set('db_user',    $projectConfiguration['dbUser']);
				$prc->set('db_name',    $projectConfiguration['dbName']);
				$prc->set('db_charset', $projectConfiguration['dbCharset']);
				$prc->set('db_collate', $projectConfiguration['dbCollate']);
				if (is_null($project['id']) || (!is_null($project['id']) && $projectConfiguration['dbPass']!='')) {
					$prc->set('db_pass', $crypt->encrypt($projectConfiguration['dbPass']));
				}
			}
			else {
				$prc->set('db_host',    null);
				$prc->set('db_user',    null);
				$prc->set('db_pass',    null);
				$prc->set('db_name',    null);
				$prc->set('db_charset', null);
				$prc->set('db_collate', null);
			}
			$prc->set('cookies_prefix',    ($projectConfiguration['cookiesPrefix']=='') ? null : $projectConfiguration['cookiesPrefix']);
			$prc->set('cookies_url',       ($projectConfiguration['cookiesUrl']=='')    ? null : $projectConfiguration['cookiesUrl']);
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

			foreach ($projectModel as $model) {
				$prm = new Model();
				if (!is_null($model['id'])) {
					$prm->find(['id'=>$model['id']]);
				}
				else {
					$prm->set('id_project', $pr->get('id'));
				}
				$prm->set('name',       $model['name']);
				$prm->set('table_name', $model['tableName']);
				$prm->save();
				$model_row_ids = [];

				foreach ($model['rows'] as $ind => $row) {
					$prmr = new Row();
					if (!is_null($row['id'])) {
						$prmr->find(['id'=>$row['id']]);
					}
					else {
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
			foreach ($includeTypes as $inc) {
				if (array_key_exists('selected', $inc)) {
					array_push($project_includes, $inc['selected']);
				}
			}
			$this->user_service->updateProjectIncludes($pr->get('id'), $project_includes);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para obtener los detalles de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-project',
		filter: 'loginFilter'
	)]
	public function getProject(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('loginFilter');

		$project       = null;
		$configuration = null;
		$lists         = null;
		$models        = null;
		$includes      = null;

		if (is_null($filter) || !array_key_exists('id', $filter) || is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$project = new Project();
			if ($project->find(['id' => $id])) {
				if ($project->get('id_user')==$filter['id']) {
					$configuration = $project->getProjectConfig();
					$lists         = $configuration->getProjectConfigurationLists();
					$models        = $project->getProjectModels();
					$includes      = $project->getProjectIncludes();
				}
				else {
					// El proyecto es de otro usuario
					$project = null;
					$status  = 'error';
				}
			}
			else {
				// No encuentro el proyecto
				$project = null;
				$status  = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('project',       'project/project',       ['project'       => $project,       'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('configuration', 'project/configuration', ['configuration' => $configuration, 'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('lists',         'project/lists',         ['lists'         => $lists,         'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('models',        'project/models',        ['models'        => $models,        'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('includes',      'project/includes',      ['includes'      => $includes,      'extra' => 'nourlencode']);
	}

	/**
	 * Función para borrar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-project',
		filter: 'loginFilter'
	)]
	public function deleteProject(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('loginFilter');

		if (is_null($filter) || !array_key_exists('id', $filter) || is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$pr = new Project();
			if ($pr->find(['id'=>$id])) {
				if ($pr->get('id_user')==$filter['id']) {
					$pr->deleteFull();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para generar el descargable de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/generate-project',
		filter: 'loginFilter'
	)]
	public function generateProject(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$step   = $req->getParamInt('step');
		$filter = $req->getFilter('loginFilter');

		$date   = '';
		if (is_null($filter) || !array_key_exists('id', $filter) || $id===false || $step===false){
			$status = 'error';
		}

		if ($status=='ok'){
			$pr = new Project();
			if ($pr->find(['id'=>$id])){
				if ($pr->get('id_user')==$filter['id']){
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

	/**
	 * Función para descargar el archivo ZIP de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/download-project/:id')]
	public function downloadProject(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$tk     = $req->getParamString('tk');

		if (is_null($id) || is_null($tk)) {
			$status = 'error';
		}

		if ($status=='ok'){
			$project = new Project();
			if ($project->find(['id'=>$id])){
				$token = new OToken($this->getConfig()->getExtra('secret'));
				$token_id = null;
				if ($token->checkToken(base64_decode($tk))) {
					$token_id = intval($token->getParam('id'));
				}

				if ($project->get('id_user')==$token_id) {
					$filename = $project->get('slug').'.zip';
					$route_zip = $this->getConfig()->getDir('ofw_tmp').'user_'.$project->get('id_user').'/'.$filename;

					if (file_exists($route_zip)){
						header('Content-Type: application/zip');
						header('Content-Transfer-Encoding: Binary');
						header('Content-disposition: attachment; filename='.$filename);
						readfile($route_zip);
						exit;
					}
				}
			}
		}

		echo 'ERROR';
		exit;
	}

	/**
	 * Función para obtener la lista de plugins
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/get-plugin-list')]
	public function getPluginList(ORequest $req): void {
		$list = $this->project_service->getPluginList();
		$this->getTemplate()->addComponent('list', 'api/plugin_list', ['list' => $list, 'extra' => 'nourlencode']);
	}
}
