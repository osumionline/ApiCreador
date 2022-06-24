<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Project;

#[OModuleAction(
	url: '/generate-project',
	filters: ['login'],
	services: ['project']
)]
class generateProjectAction extends OAction {
	/**
	 * Función para generar el descargable de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$step   = $req->getParamInt('step');
		$filter = $req->getFilter('login');

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
}
