<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class IncludeFile extends OModel {
	#[OPK(
	  comment: 'Id único para cada archivo a incluir'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id de la version del include',
	  nullable: false,
	  ref: 'include_version.id'
	)]
	public ?int $id_include_version;

	#[OField(
	  comment: 'Tipo de archivo 0 CSS 1 JS',
	  nullable: false,
	)]
	public ?int $type;

	#[OField(
	  comment: 'Nombre del archivo a incluir',
	  nullable: false,
	  max: 50
	)]
	public ?string $filename;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
