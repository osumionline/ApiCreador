<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetPluginList;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Api\PluginList\PluginListComponent;
use Osumi\OsumiFramework\App\Service\ProjectService;

class GetPluginListComponent extends OComponent {
	private ?ProjectService $ps = null;

	public ?PluginListComponent $list = null;

	public function __construct() {
    parent::__construct();
    $this->ps = inject(ProjectService::class);
  }

	/**
	 * Función para obtener la lista de plugins
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new PluginListComponent(['list' => $this->ps->getPluginList()]);
	}
}
