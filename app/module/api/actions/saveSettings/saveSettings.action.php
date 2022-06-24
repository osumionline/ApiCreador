<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/saveSettings',
	filters: ['login']
)]
class saveSettingsAction extends OAction {
	/**
	 * Función para modificar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$pass   = $req->getParamString('pass');
		$filter = $req->getFilter('login');
		$id     = 'null';
		$token  = '';

		if (is_null($name) || is_null($pass)  || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['username'=>$name]) && $u->get('id') != $filter['id']) {
				$status = 'error-user';
			}
			else {
				$u->set('username', $name);
				$u->set('pass',     password_hash($pass, PASSWORD_BCRYPT));
				$u->save();

				$id = $u->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $id);
				$tk->addParam('name', $name);
				$tk->addParam('exp', time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}
}
