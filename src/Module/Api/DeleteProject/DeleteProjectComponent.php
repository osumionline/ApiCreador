<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteProject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Project;

class DeleteProjectComponent extends OComponent {
	public string $status = 'ok';

	/**
	 * Función para borrar un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$pr = Project::findOne(['id' => $id]);
			if (!is_null($pr)) {
				if ($pr->id_user === $filter['id']) {
					$pr->deleteFull();
				}
				else {
					$this->status = 'error';
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
