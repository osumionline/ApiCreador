<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Tools\OTools;
use OsumiFramework\OFW\Plugins\OCrypt;
use OsumiFramework\App\Model\Project;
use OsumiFramework\App\Model\ProjectConfig;
use OsumiFramework\App\Model\ProjectConfigListItem;
use OsumiFramework\App\Model\Model;
use OsumiFramework\App\Model\Row;

#[OModuleAction(
	url: '/save-project',
	filters: ['login'],
	services: ['user']
)]
class saveProjectAction extends OAction {
	/**
	 * Función para guardar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');

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

			$prc = new ProjectConfig();
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
}
