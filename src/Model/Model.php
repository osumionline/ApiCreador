<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Row;

class Model extends OModel {
	#[OPK(
	  comment: 'Id único para cada modelo'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del proyecto al que pertenece el modelo',
	  nullable: false,
	  ref: 'project.id'
	)]
	public ?int $id_project;

	#[OField(
	  comment: 'Nombre del modelo',
	  nullable: false,
	  max: 100
	)]
	public ?string $name;

	#[OField(
	  comment: 'Nombre de la tabla en la base de datos',
	  nullable: false,
	  max: 100
	)]
	public ?string $table_name;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Lista de campos de un modelo
	 */
	private ?array $rows = null;

	/**
	 * Obtiene la lista de campos de un modelo
	 *
	 * @return array Lista de campos
	 */
	public function getRows(): array {
		if (is_null($this->rows)) {
			$this->loadRows();
		}
		return $this->rows;
	}

	/**
	 * Guarda la lista de campos de un modelo
	 *
	 * @param array $rows Lista de campos
	 *
	 * @return void
	 */
	public function setRows(array $rows): void {
		$this->rows = $rows;
	}

	/**
	 * Carga la lista de campos de un modelo
	 *
	 * @return void
	 */
	public function loadRows(): void {
		$this->setRows(Row::where(['id_model' => $this->id], ['order_by' => 'order']));
	}
}
