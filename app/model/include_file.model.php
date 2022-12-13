<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class IncludeFile extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada archivo a incluir'
			),
			new OModelField(
				name: 'id_include_version',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Id de la version del include',
				ref: 'include_version.id'
			),
			new OModelField(
				name: 'type',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Tipo de archivo 0 CSS 1 JS'
			),
			new OModelField(
				name: 'filename',
				type: OMODEL_TEXT,
				size: 50,
				nullable: false,
				comment: 'Nombre del archivo a incluir'
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
}
