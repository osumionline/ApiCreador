<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class RegisterComponent extends OComponent {
	public string       $status = 'ok';
	public string | int $id     = 'null';
	public string       $name   = '';
	public string       $token  = 'ok';

	/**
	 * Función para registrarse en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->name = $req->getParamString('name');
		$pass       = $req->getParamString('pass');

		if (is_null($this->name) || is_null($pass)) {
			$status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['username'=>$name]);
			if (!is_null($u)) {
				$this->status = 'error-user';
			}
			else {
				$u = User::create();
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
