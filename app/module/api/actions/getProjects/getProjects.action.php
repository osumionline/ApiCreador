<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\ProjectListComponent;

#[OModuleAction(
	url: '/get-projects',
	filters: ['login'],
	services: ['user'],
	components: ['api/project_list']
)]
class getProjectsAction extends OAction {
	/**
	 * Función para obtener la lista de proyectos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');
		$project_list_component = new ProjectListComponent(['list' => []]);

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok'){
			$list = $this->user_service->getProjects($filter['id']);
			$project_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $project_list_component);
	}
}
