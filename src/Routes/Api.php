<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\DeleteProject\DeleteProjectComponent;
use Osumi\OsumiFramework\App\Module\Api\DownloadProject\DownloadProjectComponent;
use Osumi\OsumiFramework\App\Module\Api\GenerateProject\GenerateProjectComponent;
use Osumi\OsumiFramework\App\Module\Api\GetIncludes\GetIncludesComponent;
use Osumi\OsumiFramework\App\Module\Api\GetPluginList\GetPluginListComponent;
use Osumi\OsumiFramework\App\Module\Api\GetProject\GetProjectComponent;
use Osumi\OsumiFramework\App\Module\Api\GetProjects\GetProjectsComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\SaveProject\SaveProjectComponent;
use Osumi\OsumiFramework\App\Module\Api\SaveSettings\SaveSettingsComponent;
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::prefix('/api', function() {
  ORoute::post('/delete-project',      DeleteProjectComponent::class,   [LoginFilter::class]);
  ORoute::get('/download-project/:id', DownloadProjectComponent::class);
  ORoute::post('/generate-project',    GenerateProjectComponent::class, [LoginFilter::class]);
  ORoute::post('/get-includes',        GetIncludesComponent::class,     [LoginFilter::class]);
  ORoute::post('/get-plugin-list',     GetPluginListComponent::class,   [LoginFilter::class]);
  ORoute::post('/get-project',         GetProjectComponent::class,      [LoginFilter::class]);
  ORoute::post('/get-projects',        GetProjectsComponent::class,     [LoginFilter::class]);
  ORoute::post('/login',               LoginComponent::class);
  ORoute::post('/register',            RegisterComponent::class);
  ORoute::post('/save-project',        SaveProjectComponent::class,     [LoginFilter::class]);
  ORoute::post('/saveSettings',        SaveSettingsComponent::class,    [LoginFilter::class]);
});
