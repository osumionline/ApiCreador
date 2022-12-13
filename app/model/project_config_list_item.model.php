<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class ProjectConfigListItem extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada proyecto'
			),
			new OModelField(
				name: 'id_project_config',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Id de la configuración a la que hace referencia',
				ref: 'project_config.id'
			),
			new OModelField(
				name: 'type',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir'
			),
			new OModelField(
				name: 'key',
				type: OMODEL_TEXT,
				size: 20,
				nullable: true,
				default: 'null',
				comment: 'Clave para los tipos extra y dir'
			),
			new OModelField(
				name: 'value',
				type: OMODEL_TEXT,
				size: 100,
				nullable: false,
				comment: 'Valor del elemento de lista'
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
