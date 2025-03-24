<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class ProjectConfigListItem extends OModel {
	#[OPK(
	  comment: 'Id único para cada proyecto'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id de la configuración a la que hace referencia',
	  nullable: false,
	  ref: 'project_config.id'
	)]
	public ?int $id_project_config;

	#[OField(
	  comment: 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir',
	  nullable: false,
	)]
	public ?int $type;

	#[OField(
	  comment: 'Clave para los tipos extra y dir',
	  nullable: true,
		default: null,
	  max: 20
	)]
	public ?string $key;

	#[OField(
	  comment: 'Valor del elemento de lista',
	  nullable: false,
	  max: 100
	)]
	public ?string $value;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
