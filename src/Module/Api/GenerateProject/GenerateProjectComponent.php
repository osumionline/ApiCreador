<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GenerateProject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Project;
use Osumi\OsumiFramework\App\Service\ProjectService;

class GenerateProjectComponent extends OComponent {
	private ?ProjectService $ps = null;

	public string $status = 'ok';
	public string $date   = '';

	public function __construct() {
    parent::__construct();
    $this->ps = inject(ProjectService::class);
  }

	/**
	 * Función para generar el descargable de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id     = $req->getParamInt('id');
		$step   = $req->getParamInt('step');
		$filter = $req->getFilter('Login');

		$date   = '';
		if (is_null($filter) || !array_key_exists('id', $filter) || is_null($id) || is_null($step)){
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$pr = Project::findOne(['id' => $id]);
			if (!is_null($pr)) {
				if ($pr->id_user === $filter['id']) {
					switch($step) {
						case 0: { $this->ps->createBasicStructure($pr); }
						break;
						case 1: { $this->ps->createConfigFile($pr); }
						break;
						case 2: { $this->ps->createModels($pr); }
						break;
						case 3: { $this->ps->addIncludes($pr); }
						break;
						case 4: {
							$this->ps->packToZip($pr);
							$date = date('Y-m-d H:i:s', time());

							$pr->last_compilation = $date;
							$pr->save();
						}
						break;
					}
				}
				else{
					$this->status = 'error';
				}
			}
			else{
				$this->status = 'error';
			}
		}
	}
}
