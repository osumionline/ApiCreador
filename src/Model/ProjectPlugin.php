<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class ProjectPlugin extends OModel {
	#[OPK(
	  comment: 'Id único de cada plugin en el proyecto'
	)]
	public ?int $id;

  #[OField(
	  comment: 'Id del proyecto en el que va el plugin',
	  nullable: false,
	  ref: 'project.id'
	)]
	public ?int $id_project;

  #[OField(
	  comment: 'Nombre del plugin',
	  nullable: false,
	  max: 20
	)]
	public ?string $name;

  #[OField(
	  comment: 'Version del plugin',
	  nullable: false,
	  max: 10
	)]
	public ?string $version;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
