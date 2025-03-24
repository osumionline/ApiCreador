<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DownloadProject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Project;
use Osumi\OsumiFramework\Plugins\OToken;

class DownloadProjectComponent extends OComponent {
	/**
	 * Función para descargar el archivo ZIP de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$tk     = $req->getParamString('tk');

		if (is_null($id) || is_null($tk)) {
			$status = 'error';
		}

		if ($status == 'ok'){
			$project = Project::findOne(['id' => $id]);
			if (!is_null($project)){
				$token = new OToken($this->getConfig()->getExtra('secret'));
				$token_id = null;
				if ($token->checkToken(base64_decode($tk))) {
					$token_id = intval($token->getParam('id'));
				}

				if ($project->id_user === $token_id) {
					$filename = $project->slug . '.zip';
					$route_zip = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/' . $filename;

					if (file_exists($route_zip)){
						header('Content-Type: application/zip');
						header('Content-Transfer-Encoding: Binary');
						header('Content-disposition: attachment; filename=' . $filename);
						readfile($route_zip);
						exit;
					}
				}
			}
		}

		echo 'ERROR';
		exit;
	}
}
