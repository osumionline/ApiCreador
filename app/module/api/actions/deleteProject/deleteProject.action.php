<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Project;

#[OModuleAction(
	url: '/delete-project',
	filter: 'login'
)]
class deleteProjectAction extends OAction {
	/**
	 * Función para borrar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('login');

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
}
