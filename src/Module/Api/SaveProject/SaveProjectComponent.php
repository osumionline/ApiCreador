<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\SaveProject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\Plugins\OCrypt;
use Osumi\OsumiFramework\App\Model\Project;
use Osumi\OsumiFramework\App\Model\ProjectConfig;
use Osumi\OsumiFramework\App\Model\ProjectConfigListItem;
use Osumi\OsumiFramework\App\Model\Model;
use Osumi\OsumiFramework\App\Model\Row;
use Osumi\OsumiFramework\App\Model\ProjectPlugin;
use Osumi\OsumiFramework\App\Service\UserService;

class SaveProjectComponent extends OComponent {
	private ?UserService $us = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
    $this->us = inject(UserService::class);
  }

	/**
	 * Función para guardar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$filter = $req->getFilter('Login');

		$project                   = $req->getParam('project');
		$projectConfiguration      = $req->getParam('projectConfiguration');
		$projectConfigurationLists = $req->getParam('projectConfigurationLists');
		$projectModel              = $req->getParam('projectModel');
		$includeTypes              = $req->getParam('includeTypes');
		$plugins                   = $req->getParam('plugins');

		if (
			is_null($filter) ||
			!array_key_exists('id', $filter) ||
			is_null($project) ||
			is_null($projectConfiguration) ||
			is_null($projectConfigurationLists) ||
			is_null($projectModel) ||
			is_null($includeTypes) ||
			is_null($plugins)
		) {
			$this->status = false;
		}

		if ($this->status === 'ok') {
			$crypt = new OCrypt( $this->getConfig()->getExtra('crypt_key') );

			$pr = Project::create();
			if (!is_null($project['id'])) {
				$pr = Project::findOne(['id' => $project['id']]);
			}
			else {
				$pr->id_user = $filter['id'];
			}
			$pr->name = urldecode($project['name']);
			$pr->slug = OTools::slugify($pr->name);
			$pr->description = urldecode($project['description']);
			$pr->save();

			$prc = ProjectConfig::create();
			if (!is_null($project['id'])) {
				$prc = ProjectConfig::findOne(['id_project' => $project['id']]);
			}
			else {
				$prc->id_project = $pr->id;
			}
			if ($projectConfiguration['hasDB']) {
				$prc->db_host = urldecode($projectConfiguration['dbHost']);
				$prc->db_user = urldecode($projectConfiguration['dbUser']);
				$prc->db_name = urldecode($projectConfiguration['dbName']);
				$prc->db_charset = urldecode($projectConfiguration['dbCharset']);
				$prc->db_collate = urldecode($projectConfiguration['dbCollate']);
				if (is_null($project['id']) || (!is_null($project['id']) && $projectConfiguration['dbPass'] !== '')) {
					$prc->db_pass = $crypt->encrypt(urldecode($projectConfiguration['dbPass']));
				}
			}
			else {
				$prc->db_host = null;
				$prc->db_user = null;
				$prc->db_pass = null;
				$prc->db_name = null;
				$prc->db_charset = null;
				$prc->db_collate = null;
			}
			$prc->cookies_prefix = ($projectConfiguration['cookiesPrefix'] === '') ? null : urldecode($projectConfiguration['cookiesPrefix']);
			$prc->cookies_url    = ($projectConfiguration['cookiesUrl'] === '')    ? null : urldecode($projectConfiguration['cookiesUrl']);
			$prc->base_url       = ($projectConfiguration['baseUrl'] === '')       ? null : urldecode($projectConfiguration['baseUrl']);
			$prc->admin_email    = ($projectConfiguration['adminEmail'] === '')    ? null : urldecode($projectConfiguration['adminEmail']);
			$prc->default_title  = ($projectConfiguration['defaultTitle'] === '')  ? null : urldecode($projectConfiguration['defaultTitle']);
			$prc->lang           = ($projectConfiguration['lang'] === '')          ? null : urldecode($projectConfiguration['lang']);
			$prc->error_403      = ($projectConfiguration['error403'] === '')      ? null : urldecode($projectConfiguration['error403']);
			$prc->error_404      = ($projectConfiguration['error404'] === '')      ? null : urldecode($projectConfiguration['error404']);
			$prc->error_500      = ($projectConfiguration['error500'] == '')       ? null : urldecode($projectConfiguration['error500']);

			$prc->save();

			$this->us->cleanProjectConfigurationLists($prc->id);

			foreach ($projectConfigurationLists['css'] as $value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 0;
				$prcli->key               = null;
				$prcli->value             = urldecode($value);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['cssExt'] as $value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 1;
				$prcli->key               = null;
				$prcli->value             = urldecode($value);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['js'] as $value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 2;
				$prcli->key               = null;
				$prcli->value             = urldecode($value);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['jsExt'] as $value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 3;
				$prcli->key               = null;
				$prcli->value             = urldecode($value);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['extra'] as $key_value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 4;
				$prcli->key               = urldecode($key_value['key']);
				$prcli->value             = urldecode($key_value['value']);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['libs'] as $value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 5;
				$prcli->key               = null;
				$prcli->value             = urldecode($value);
				$prcli->save();
			}
			foreach ($projectConfigurationLists['dir'] as $key_value) {
				$prcli = ProjectConfigListItem::create();
				$prcli->id_project_config = $prc->id;
				$prcli->type              = 6;
				$prcli->key               = urldecode($key_value['key']);
				$prcli->value             = urldecode($key_value['value']);
				$prcli->save();
			}

			foreach ($projectModel as $model) {
				$prm = Model::create();
				if (!is_null($model['id'])) {
					$prm = Model::findOne(['id' => $model['id']]);
				}
				else {
					$prm->id_project = $pr->id;
				}
				$prm->name       = urldecode($model['name']);
				$prm->table_name = urldecode($model['tableName']);
				$prm->save();
				$model_row_ids = [];

				foreach ($model['rows'] as $ind => $row) {
					$prmr = Row::create();
					if (!is_null($row['id'])) {
						$prmr = Row::findOne(['id' => $row['id']]);
					}
					else {
						$prmr->id_model = $prm->id;
					}
					$prmr->name           = urldecode($row['name']);
					$prmr->type           = $row['type'];
					$prmr->size           = ($row['size'] === '') ? null : $row['size'];
					$prmr->auto_increment = $row['autoIncrement'];
					$prmr->nullable       = $row['nullable'];
					$prmr->default        = ($row['defaultValue'] === '') ? null : urldecode($row['defaultValue']);
					$prmr->ref            = ($row['ref'] === '')          ? null : urldecode($row['ref']);
					$prmr->comment        = ($row['comment'] === '')      ? null :urldecode( $row['comment']);
					$prmr->order          = $ind;
					$prmr->save();

					$model_row_ids[] = $prmr->id;
				}

				$this->us->cleanDeletedRows($prm->id, $model_row_ids);
			}

			$project_includes = [];
			foreach ($includeTypes as $inc) {
				if (array_key_exists('selected', $inc)) {
					$project_includes[] = $inc['selected'];
				}
			}
			$this->us->updateProjectIncludes($pr->id, $project_includes);

			$this->us->cleanProjectPlugins($pr->id);

			foreach ($plugins as $plugin) {
				$p = ProjectPlugin::create();
				$p->id_project = $pr->id;
				$p->name       = $plugin['name'];
				$p->version    = $plugin['version'];
				$p->save();
			}
		}
	}
}
