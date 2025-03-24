<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetProject;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Project\Project\ProjectComponent;
use Osumi\OsumiFramework\App\Component\Project\Configuration\ConfigurationComponent;
use Osumi\OsumiFramework\App\Component\Project\Lists\ListsComponent;
use Osumi\OsumiFramework\App\Component\Project\Models\ModelsComponent;
use Osumi\OsumiFramework\App\Component\Project\Includes\IncludesComponent;
use Osumi\OsumiFramework\App\Model\Project;

class GetProjectComponent extends OComponent {
	public string                  $status        = 'ok';
	public ?ProjectComponent       $project       = null;
	public ?ConfigurationComponent $configuration = null;
	public ?ListsComponent         $lists         = null;
	public ?ModelsComponent        $models        = null;
	public ?IncludesComponent      $includes      = null;

	public function __construct() {
    parent::__construct();
		$this->project       = new ProjectComponent();
		$this->configuration = new ConfigurationComponent();
		$this->lists         = new ListsComponent();
		$this->models        = new ModelsComponent();
		$this->includes      = new IncludesComponent();
  }

	/**
	 * Función para obtener los detalles de un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($filter) || !array_key_exists('id', $filter) || is_null($id)) {
			$status = 'error';
		}

		if ($this->status === 'ok') {
			$pr = Project::findOne(['id' => $id]);
			if (!is_null($pr)) {
				if ($pr->id_user === $filter['id']) {
					$conf = $pr->getProjectConfig();

					$this->project->project             = $pr;
					$this->configuration->configuration = $conf;
					$this->lists->lists                 = $conf->getProjectConfigurationLists();
					$this->models->models               = $pr->getProjectModels();
					$this->includes->includes           = $pr->getProjectIncludes();
				}
				else {
					// El proyecto es de otro usuario
					$this->status  = 'error';
				}
			}
			else {
				// No encuentro el proyecto
				$this->status  = 'error';
			}
		}
	}
}
