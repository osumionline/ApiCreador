<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\IncludeFile;

class IncludeVersion extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'include_version';
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id unico de la version del include'
			],
			'id_include_type' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Id del tipo de include',
				'ref'      => 'include_type.id'
			],
			'version' => [
				'type'     => OModel::TEXT,
				'size'     => 10,
				'nullable' => false,
				'comment'  => 'Número de versión del tipo de include'
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

		parent::load($table_name, $model);
	}

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
		$sql = "SELECT * FROM `include_file` WHERE `id_include_version` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$files = [];

		while ($res=$this->db->next()) {
			$inc_file = new IncludeFile();
			$inc_file->update($res);

			array_push($files, $inc_file);
		}

		$this->setIncludeFiles($files);
	}
}