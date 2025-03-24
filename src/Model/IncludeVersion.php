<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\IncludeFile;

class IncludeVersion extends OModel {
	#[OPK(
	  comment: 'Id unico de la version del include'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del tipo de include',
	  nullable: false,
	  ref: 'include_type.id'
	)]
	public ?int $id_include_type;

	#[OField(
	  comment: 'Número de versión del tipo de include',
	  nullable: false,
	  max: 10
	)]
	public ?string $version;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Lista de archivos de una versión concreta de un include
	 */
	private ?array $include_files = null;

	/**
	 * Obtiene la lista de archivos de una versión de un include
	 *
	 * @return array Lista de archivos
	 */
	public function getIncludeFiles(): array {
		if (is_null($this->include_files)) {
			$this->loadIncludeFiles();
		}
		return $this->include_files;
	}

	/**
	 * Guarda la lista de archivos de una versión de un include
	 *
	 * @param array $list Lista de archivos
	 *
	 * @return void
	 */
	public function setIncludeFiles(array $files): void {
		$this->include_files = $files;
	}

	/**
	 * Carga la lista de archivos de una versión de un include
	 *
	 * @return void
	 */
	private function loadIncludeFiles(): void {
		$this->setIncludeFiles(IncludeFile::where(['id_include_version' => $this->id]));
	}
}
