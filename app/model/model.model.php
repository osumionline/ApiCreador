<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Model extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada modelo'
			),
			new OModelField(
				name: 'id_project',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Id del proyecto al que pertenece el modelo',
				ref: 'project.id'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				size: 100,
				nullable: false,
				comment: 'Nombre del modelo'
			),
			new OModelField(
				name: 'table_name',
				type: OMODEL_TEXT,
				size: 100,
				nullable: false,
				comment: 'Nombre de la tabla en la base de datos'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				comment: 'Fecha de última modificación del registro'
			)
		);

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
