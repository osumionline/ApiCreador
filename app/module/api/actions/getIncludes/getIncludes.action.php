<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\IncludeListComponent;

#[OModuleAction(
	url: '/get-includes',
	filter: 'login',
	services: ['user'],
	components: ['api/include_list']
)]
class getIncludesAction extends OAction {
	/**
	 * Función para obtener la lista de includes para añadir a un proyecto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');
		$include_list_component = new IncludeListComponent(['list' => []]);

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok'){
			$list = $this->user_service->getIncludes();
			$include_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $include_list_component);
	}
}
