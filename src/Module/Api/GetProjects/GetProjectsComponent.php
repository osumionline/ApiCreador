<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetProjects;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Api\ProjectList\ProjectListComponent;
use Osumi\OsumiFramework\App\Service\UserService;


class GetProjectsComponent extends OComponent {
	private ?UserService $us = null;

	public string $status = 'ok';
	public ?ProjectListComponent $list = null;

	public function __construct() {
    parent::__construct();
    $this->us = inject(UserService::class);
		$this->list = new ProjectListComponent();
  }

	/**
	 * Función para obtener la lista de proyectos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$filter = $req->getFilter('Login');

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->list = $this->us->getProjects($filter['id']);
		}
	}
}
