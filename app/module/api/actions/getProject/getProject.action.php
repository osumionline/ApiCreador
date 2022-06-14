<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Project;
use OsumiFramework\App\Component\ProjectComponent;
use OsumiFramework\App\Component\ConfigurationComponent;
use OsumiFramework\App\Component\ListsComponent;
use OsumiFramework\App\Component\ModelsComponent;
use OsumiFramework\App\Component\IncludesComponent;

#[OModuleAction(
	url: '/get-project',
	filter: 'login',
	services: ['user'],
	components: ['project/project', 'project/configuration', 'project/lists', 'project/models', 'project/includes']
)]
class getProjectAction extends OAction {
	/**
	 * Función para obtener los detalles de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('login');

		$project       = new ProjectComponent(['project' => null]);
		$configuration = new ConfigurationComponent(['configuration' => null]);
		$lists         = new ListsComponent(['lists' => null]);
		$models        = new ModelsComponent(['models' => null]);
		$includes      = new IncludesComponent(['includes' => null]);

		if (is_null($filter) || !array_key_exists('id', $filter) || is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$pr = new Project();
			if ($pr->find(['id' => $id])) {
				if ($pr->get('id_user')==$filter['id']) {
					$conf = $pr->getProjectConfig();

					$project->setValue('project', $pr);
					$configuration->setValue('configuration', $conf);
					$lists->setValue('lists', $conf->getProjectConfigurationLists());
					$models->setValue('models', $pr->getProjectModels());
					$includes->setValue('includes', $pr->getProjectIncludes());
				}
				else {
					// El proyecto es de otro usuario
					$status  = 'error';
				}
			}
			else {
				// No encuentro el proyecto
				$status  = 'error';
			}
		}

		$this->getTemplate()->add('status',        $status);
		$this->getTemplate()->add('project',       $project);
		$this->getTemplate()->add('configuration', $configuration);
		$this->getTemplate()->add('lists',         $lists);
		$this->getTemplate()->add('models',        $models);
		$this->getTemplate()->add('includes',      $includes);
	}
}
