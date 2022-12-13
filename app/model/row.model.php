<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Row extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada campo del modelo'
			),
			new OModelField(
				name: 'id_model',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Id del modelo al que pertenece el campo',
				ref: 'model.id'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				size: 50,
				nullable: false,
				comment: 'Nombre del campo'
			),
			new OModelField(
				name: 'type',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9'
			),
			new OModelField(
				name: 'size',
				type: OMODEL_NUM,
				nullable: true,
				comment: 'Tamaño del campo'
			),
			new OModelField(
				name: 'auto_increment',
				type: OMODEL_BOOL,
				nullable: true,
				default: false,
				comment: 'Indica si el campo es AUTO_INCREMENT 1 o no 0'
			),
			new OModelField(
				name: 'nullable',
				type: OMODEL_BOOL,
				nullable: true,
				default: false,
				comment: 'Indica si el campo puede ser nulo 1 o no 0'
			),
			new OModelField(
				name: 'default',
				type: OMODEL_TEXT,
				size: 250,
				nullable: true,
				comment: 'Valor por defecto para un campo'
			),
			new OModelField(
				name: 'ref',
				type: OMODEL_TEXT,
				size: 50,
				nullable: true,
				comment: 'Referencia a otra tabla'
			),
			new OModelField(
				name: 'comment',
				type: OMODEL_TEXT,
				size: 200,
				nullable: true,
				comment: 'Comentario para el campo'
			),
			new OModelField(
				name: 'order',
				type: OMODEL_NUM,
				nullable: false,
				comment: 'Orden del campo en el modelo'
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
