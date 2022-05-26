<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Routing\OUrl;
use OsumiFramework\OFW\Web\ORequest;

#[OModuleAction(
	url: '/closed'
)]
class closedAction extends OAction {
	/**
	 * Página temporal, sitio cerrado
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		OUrl::goToUrl('https://creador.osumi.es');
	}
}
