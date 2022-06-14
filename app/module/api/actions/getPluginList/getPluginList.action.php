<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\PluginListComponent;

#[OModuleAction(
	url: '/get-plugin-list',
	services: ['project'],
	components: ['api/plugin_list']
)]
class getPluginListAction extends OAction {
	/**
	 * Función para obtener la lista de plugins
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$plugin_list_component = new PluginListComponent(['list' => $this->project_service->getPluginList()]);
		$this->getTemplate()->add('list', $plugin_list_component);
	}
}
