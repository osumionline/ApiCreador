<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Row extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada campo del modelo'
			],
			'id_model' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Id del modelo al que pertenece el campo',
				'ref'      => 'model.id'
			],
			'name' => [
				'type'     => OModel::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Nombre del campo'
			],
			'type' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9'
			],
			'size' => [
				'type'     => OModel::NUM,
				'nullable' => true,
				'comment'  => 'Tamaño del campo'
			],
			'auto_increment' => [
				'type'     => OModel::BOOL,
				'nullable' => true,
				'default'  => false,
				'comment'  => 'Indica si el campo es AUTO_INCREMENT 1 o no 0'
			],
			'nullable' => [
				'type'     => OModel::BOOL,
				'nullable' => true,
				'default'  => false,
				'comment'  => 'Indica si el campo puede ser nulo 1 o no 0'
			],
			'default' => [
				'type'     => OModel::TEXT,
				'size'     => 250,
				'nullable' => true,
				'comment'  => 'Valor por defecto para un campo'
			],
			'ref' => [
				'type'     => OModel::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Referencia a otra tabla'
			],
			'comment' => [
				'type'     => OModel::TEXT,
				'size'     => 200,
				'nullable' => true,
				'comment'  => 'Comentario para el campo'
			],
			'order' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Orden del campo en el modelo'
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
}
