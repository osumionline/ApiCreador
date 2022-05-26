<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\Model\Project;

#[OModuleAction(
	url: '/download-project/:id'
)]
class downloadProjectAction extends OAction {
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
}
