<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Login;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class LoginComponent extends OComponent {
	public string       $status = 'ok';
	public string | int $id     = 'null';
	public string       $name   = '';
	public string       $token  = 'ok';

	/**
	 * Función para iniciar sesión en la aplicación
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
			$u = User::findOne(['username' => $this->name]);
			if (!is_null($u)) {
				if (password_verify($pass, $u->pass)) {
					$this->id = $u->id;

					$tk = new OToken($this->getConfig()->getExtra('secret'));
					$tk->addParam('id',   $this->id);
					$tk->addParam('name', $this->name);
					$tk->setEXP(time() + (24 * 60 * 60));
					$this->token = $tk->getToken();
				}
				else {
					$this->status = 'error';
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
