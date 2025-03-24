<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Row extends OModel {
	#[OPK(
	  comment: 'Id único para cada campo del modelo'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del modelo al que pertenece el campo',
	  nullable: false,
	  ref: 'model.id'
	)]
	public ?int $id_model;

	#[OField(
	  comment: 'Nombre del campo',
	  nullable: false,
	  max: 50
	)]
	public ?string $name;

	#[OField(
	  comment: 'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9',
	  nullable: false,
	)]
	public ?int $type;

	#[OField(
	  comment: 'Tamaño del campo',
	  nullable: true,
		default: null
	)]
	public ?int $size;

	#[OField(
	  comment: 'Indica si el campo es AUTO_INCREMENT 1 o no 0',
	  nullable: true,
	  default: false
	)]
	public ?bool $auto_increment;

	#[OField(
	  comment: 'Indica si el campo puede ser nulo 1 o no 0',
	  nullable: true,
	  default: false
	)]
	public ?bool $nullable;

	#[OField(
	  comment: 'Valor por defecto para un campo',
	  nullable: true,
		default: null,
	  max: 250
	)]
	public ?string $default;

	#[OField(
	  comment: 'Referencia a otra tabla',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $ref;

	#[OField(
	  comment: 'Comentario para el campo',
	  nullable: true,
		default: null,
	  max: 200
	)]
	public ?string $comment;

	#[OField(
	  comment: 'Orden del campo en el modelo',
	  nullable: false,
	)]
	public ?int $order;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
