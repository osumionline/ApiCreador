<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\IncludeVersion;

class IncludeType extends OModel {
	#[OPK(
	  comment: 'Id único para tipo de include'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Nombre del tipo de include',
	  nullable: false,
	  max: 50
	)]
	public ?string $name;

	#[OField(
	  comment: 'Indica si debe mostrarse en la lista de includes disponibles',
	  nullable: false,
	  default: true
	)]
	public ?bool $show_include;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Lista de versiones de un include
	 */
	private ?array $versions = null;

	/**
	 * Obtiene la lista de versiones de un include
	 *
	 * @return array Lista de versiones
	 */
	public function getVersions(): array {
		if (is_null($this->versions)) {
			$this->loadVersions();
		}
		return $this->versions;
	}

	/**
	 * Guarda la lista de versiones de un include
	 *
	 * @param array $list Lista de versiones de un include
	 *
	 * @return void
	 */
	public function setVersions(array $list): void {
		$this->versions = $list;
	}

	/**
	 * Carga la lista de versiones de un include
	 *
	 * @return void
	 */
	public function loadVersions(): void {
		$this->setVersions(IncludeVersion::where(['id_include_type' => $this->id], ['order_by' => 'version#desc']));
	}
}
