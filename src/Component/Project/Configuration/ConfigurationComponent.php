<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Component\Project\Configuration;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\Model\ProjectConfig;

class ConfigurationComponent extends OComponent {
  public ?ProjectConfig $configuration = null;
}
