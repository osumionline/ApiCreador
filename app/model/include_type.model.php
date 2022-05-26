<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class IncludeType extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para tipo de include'
			],
			'name' => [
				'type'     => OModel::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Nombre del tipo de include'
			],
			'show_include' => [
				'type'     => OModel::BOOL,
				'nullable' => false,
				'default'  => true,
				'comment'  => 'Indica si debe mostrarse en la lista de includes disponibles'
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
		$sql = "SELECT * FROM `include_version` WHERE `id_include_type` = ? ORDER BY `version` DESC";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $this->db->next()) {
			$ver = new IncludeVersion();
			$ver->update($res);

			array_push($list, $ver);
		}

		$this->setVersions($list);
	}
}
