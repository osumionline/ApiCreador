<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: ['deleteProject', 'downloadProject', 'generateProject', 'getIncludes', 'getPluginList', 'getProject', 'getProjects', 'login', 'register', 'saveProject', 'saveSettings'],
	type: 'json',
	prefix: '/api'
)]
class apiModule {}
