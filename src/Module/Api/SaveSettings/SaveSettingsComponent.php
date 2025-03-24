<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\SaveSettings;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class SaveSettingsComponent extends OComponent {
	public string       $status = 'ok';
	public string | int $id     = 'null';
	public string       $name   = '';
	public string       $token  = 'ok';

	/**
	 * Función para modificar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->name = $req->getParamString('name');
		$pass       = $req->getParamString('pass');
		$filter     = $req->getFilter('Login');

		if (is_null($this->name) || is_null($pass)  || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['username'=>$name]);
			if (!is_null($u) && $u->id !== $filter['id']) {
				$status = 'error-user';
			}
			else {
				$u->username = $name;
				$u->pass     = password_hash($pass, PASSWORD_BCRYPT);
				$u->save();

				$this->id = $u->id;

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $this->id);
				$tk->addParam('name', $this->name);
				$tk->setEXP(time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
		}
	}
}
