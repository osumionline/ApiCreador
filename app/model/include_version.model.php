<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\App\Model\IncludeFile;

class IncludeVersion extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id unico de la version del include'
			),
			new OModelField(
				name: 'id_include_type',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Id del tipo de include',
				ref: 'include_type.id'
			),
			new OModelField(
				name: 'version',
				type: OMODEL_TEXT,
				size: 10,
				nullable: false,
				comment: 'Número de versión del tipo de include'
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
