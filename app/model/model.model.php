<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Model extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada modelo'
			],
			'id_project' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Id del proyecto al que pertenece el modelo',
				'ref'      => 'project.id'
			],
			'name' => [
				'type'     => OModel::TEXT,
				'size'     => 100,
				'nullable' => false,
				'comment'  => 'Nombre del modelo'
			],
			'table_name' => [
				'type'     => OModel::TEXT,
				'size'     => 100,
				'nullable' => false,
				'comment'  => 'Nombre de la tabla en la base de datos'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}

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
		$sql = "SELECT * FROM `row` WHERE `id_model` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		$rows = [];

		while ($res = $this->db->next()) {
			$row = new Row();
			$row->update($res);
			array_push($rows, $row);
		}

		$this->setRows($rows);
	}
}
