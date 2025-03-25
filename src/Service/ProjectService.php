<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\Tools\OBuild;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\Plugins\OCrypt;
use Osumi\OsumiFramework\Plugins\OFile;
use Osumi\OsumiFramework\App\Model\Project;

class ProjectService extends OService {
	/**
	 * Crea la estructura de archivos y carpetas propia del Framework
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function createBasicStructure(Project $project): void {
		$route = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id;
		if (file_exists($route)) {
			OFile::rrmdir($route);
		}
		mkdir($route);

		$folder_list = OFile::getOFWFolders();
		foreach ($folder_list as $folder) {
			mkdir($route . '/' . $folder, 0777, true);
		}

		$file_list = OFile::getOFWFiles();
		foreach ($file_list as $file) {
			file_put_contents(
				$route . '/' . $file['where'],
				file_get_contents($file['url'])
			);
		}
	}

	/**
	 * Crea archivo de configuración del proyecto
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function createConfigFile(Project $project): void {
		$crypt = new OCrypt( $this->getConfig()->getExtra('crypt_key') );
		$route = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id . '/src/Config/Config.json';
		if (file_exists($route)) {
			unlink($route);
		}

		$configuration = $project->getProjectConfig();
		$lists         = $configuration->getProjectConfigurationLists();

		$conf = "{\n";
		if (!is_null($configuration->db_host) ||
			!is_null($configuration->db_user) ||
			!is_null($configuration->db_pass) ||
			!is_null($configuration->db_name) ||
			!is_null($configuration->db_charset) ||
			!is_null($configuration->db_collate)) {
			$conf .= "  \"db\": {\n";
			$conf .= "    \"host\": " . (is_null($configuration->db_host) ? "null" : "\"" . $configuration->db_host . "\"") . ",\n";
			$conf .= "    \"user\": " . (is_null($configuration->db_user) ? "null" : "\"" . $configuration->db_user . "\"") . ",\n";
			$conf .= "    \"pass\": " . (is_null($configuration->db_pass) ? "null" : "\"" . $crypt->decrypt($configuration->db_pass) . "\"") . ",\n";
			$conf .= "    \"name\": " . (is_null($configuration->db_name) ? "null" : "\"" . $configuration->db_name . "\"") . ",\n";
			$conf .= "    \"charset\": " . (is_null($configuration->db_charset) ? "null" : "\"" . $configuration->db_charset . "\"") . ",\n";
			$conf .= "    \"collate\": " . (is_null($configuration->db_collate) ? "null" : "\"" . $configuration->db_collate . "\"") . "\n";
			$conf .= "  },\n";
		}
		if (!is_null($configuration->cookies_prefix) || !is_null($configuration->cookies_url)) {
			$conf .= "  \"cookies\": {\n";
			$conf .= "    \"prefix\": " . (is_null($configuration->cookies_prefix) ? "null" : "\"" . $configuration->cookies_prefix . "\"") . ",\n";
			$conf .= "    \"url\": " . (is_null($configuration->cookies_url) ? "null" : "\"" . $configuration->cookies_url . "\"") . "\n";
			$conf .= "  },\n";
		}
		if (!is_null($configuration->base_url)) {
			$conf .= "  \"base_url\": \"" . $configuration->base_url . "\",\n";
		}
		if (!is_null($configuration->admin_email)) {
			$conf .= "  \"admin_email\": \"" . $configuration->admin_email . "\",\n";
		}
		if (!is_null($configuration->default_title)) {
			$conf .= "  \"default_title\": \"" . $configuration->default_title . "\",\n";
		}
		if (!is_null($configuration->lang)) {
			$conf .= "  \"lang\": \"" . $configuration->lang . "\",\n";
		}
		if (!is_null($configuration->error_403) || !is_null($configuration->error_404) || !is_null($configuration->error_500)) {
			$conf .= "  \"error_pages\": {\n";
			$conf .= "    \"403\": " . (is_null($configuration->error_403) ? "null" : "\"" . $configuration->error_403 . "\"") . ",\n";
			$conf .= "    \"404\": " . (is_null($configuration->error_404) ? "null" : "\"" . $configuration->error_404 . "\"") . ",\n";
			$conf .= "    \"500\": " . (is_null($configuration->error_500) ? "null" : "\"" . $configuration->error_500 . "\"") . "\n";
			$conf .= "  },\n";
		}
		if (count($lists['css']) > 0) {
			$conf .= "  \"css\": [" . implode(', ', $lists['css']) . "],\n";
		}
		if (count($lists['css_ext']) > 0) {
			$conf .= "  \"css_ext\": [" . implode(', ', $lists['css_ext']) . "],\n";
		}
		if (count($lists['js']) > 0) {
			$conf .= "  \"js\": [" . implode(', ', $lists['js']) . "],\n";
		}
		if (count($lists['js_ext']) > 0) {
			$conf .= "  \"js_ext\": [" . implode(', ', $lists['js_ext']) . "],\n";
		}
		if (count($lists['libs']) > 0) {
			$conf .= "  \"libs\": [" . implode(', ', $lists['libs']) . "],\n";
		}
		if (count($lists['extra']) > 0) {
			$conf .= "  \"extra\": {\n";
			$extras = [];
			foreach ($lists['extra'] as $item) {
				$extras[] = "    \"" . urldecode($item['key']) . "\": \"" . urldecode($item['value']) . "\"";
			}
			$conf .= implode(",\n", $extras);
			$conf .= "\n  },\n";
		}
		if (count($lists['dir']) > 0) {
			$conf .= "  \"dir\": {\n";
			$dirs = [];
			foreach ($lists['dir'] as $item) {
				$dirs[] = "    \"" . urldecode($item['key']) . "\": \"" . urldecode($item['value']) . "\"";
			}
			$conf .= implode(",\n", $dirs);
			$conf .= "\n  },\n";
		}
		$conf .= "  \"log_level\": \"DEBUG\"\n";
		$conf .= "}";

		file_put_contents($route, $conf);
	}

	/**
	 * Genera el archivo composer.json del proyecto
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function createComposerFile(Project $project): void {
		$route = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id . '/composer.json';
		if (file_exists($route)) {
			unlink($route);
		}

		$configuration = $project->getProjectConfig();

		$composer = "{\n";
		$composer .= "  \"name\": \"".$project->name."\",\n";
		$composer .= "  \"description\": \"".$project->description."\",\n";
		$composer .= "  \"type\": \"project\",\n";
		$composer .= "  \"keywords\": [\"osumi\", \"framework\"],\n";
		if (!is_null($configuration->base_url)) {
			$composer .= "  \"homepage\": \"".$configuration->base_url."\",\n";
		}
		$composer .= "  \"require\": {\n";
		$composer .= "    \"php\": \">=8.2\",\n";

		$plugins = $project->getProjectPlugins();
		$required = ["    \"osumionline/framework\": \"^".OTools::getVersion()."\""];
		foreach ($plugins as $plugin) {
			$required[] = "    \"".$plugin->name."\": \"^".$plugin->version."\"";
		}

		$composer .= implode(",\n", $required)."\n";
		$composer .= "  },\n";
		$composer .= "  \"autoload\": {\n";
		$composer .= "    \"psr-4\": {\n";
		$composer .= "      \"Osumi\\\\OsumiFramework\\\\App\\\\\": \"src/\"\n";
		$composer .= "    }\n";
		$composer .= "  },\n";
		$composer .= "  \"config\": {\n";
		$composer .= "    \"preferred-install\": \"dist\",\n";
		$composer .= "    \"sort-packages\": true\n";
		$composer .= "  },\n";
		$composer .= "  \"minimum-stability\": \"stable\",\n";
		$composer .= "  \"prefer-stable\": true\n";
		$composer .= "}\n";

		file_put_contents($route, $composer);
	}

	/**
	 * Crea las clases del modelo del proyecto
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function createModels(Project $project): void {
		$models = $project->getProjectModels();
		$types = [
			1 =>  ['decorator' => 'OPK',        'attribute_type' => 'int'],
			10 => ['decorator' => 'OPK',        'attribute_type' => 'string'],
			2 =>  ['decorator' => 'OCreatedAt', 'attribute_type' => 'string'],
			3 =>  ['decorator' => 'OUpdatedAt', 'attribute_type' => 'string'],
			4 =>  ['decorator' => 'OField',     'attribute_type' => 'int'],
			5 =>  ['decorator' => 'OField',     'attribute_type' => 'string'],
			6 =>  ['decorator' => 'OField',     'attribute_type' => 'string', 'type' => 'OField::DATE'],
			7 =>  ['decorator' => 'OField',     'attribute_type' => 'bool'],
			8 =>  ['decorator' => 'OField',     'attribute_type' => 'string', 'type' => 'OField::LONGTEXT'],
			9 =>  ['decorator' => 'OField',     'attribute_type' => 'float'],
		];

		foreach ($models as $model) {
			$route = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id . '/src/Model/' . $model->name . '.php';
			if (file_exists($route)) {
				unlink($route);
			}

			$model_object = [
				'fields' => [],
				'refs' => []
			];

			foreach ($model->getRows() as $row) {
				$row_item = [
					'name' => $row->name,
					'comment' => $row->comment,
					'decorator' => $types[$row->type]['decorator'],
					'attribute_type' => $types[$row->type]['attribute_type'],
				];
				if (array_key_exists('type', $types[$row->type])) {
					$row_item['type'] = $types[$row->type]['type'];
				}
				if ($row->type === 3 || $row->type === 4 || $row->type === 5 || $row->type === 6 || $row->type === 8 || $row->type === 9) {
					$row_item['nullable'] = $row->nullable;
					$row_item['default'] = is_null($row->default) ? null : $row->default;
				}
				if (!is_null($row->size)) {
					$row_item['max'] = $row->size;
				}

				$model_object['fields'][] = $row_item;

				if (!is_null($row->ref)) {
					$ref_parts = explode('.', $row->ref);
					$model_object['refs'][] = [
						'to'         => $ref_parts[0],
	          'field_from' => $ref_parts[1],
	          'field_to'   => $row->name
					];
				}
			}

			$values = [
	      'table_name' => $model->name,
	      'class_file' => $route,
	      'fields'     => $model_object['fields'],
	      'refs'       => $model_object['refs']
	    ];
			/*var_dump($values);
			echo "\n";*/
	    $status = OBuild::addModelClass($values);
		}
	}

	/**
	 * Crea la ruta para los includes
	 *
	 * @param string $route Ruta para los includes
	 *
	 * @return void
	 */
	private function createRouteIncludes(string $route): void {
		if (!file_exists($route)) {
			mkdir($route);
		}
	}

	/**
	 * Añade includes al proyecto
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function addIncludes(Project $project): void {
		$route_web = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id . '/web/';
		$route_css = $route_web . 'css';
		$css_ok    = false;
		$route_js  = $route_web . 'js';
		$js_ok     = false;

		$versions = $project->getProjectIncludeVersions();
		foreach ($versions as $version) {
			$files = $version->getIncludeFiles();
			foreach ($files as $file) {
				// CSS
				if ($file->type === 0) {
					if (!$css_ok) {
						$this->createRouteIncludes($route_css);
						$css_ok = true;
					}
					$route = $this->getConfig()->getDir('include') . $version->id_include_type . '/' . $version->id . '/0/' . $file->filename;
					copy($route, $route_css . '/' . $file->filename);
				}
				// JS
				if ($file->type === 1) {
					if (!$js_ok) {
						$this->createRouteIncludes($route_js);
						$js_ok = true;
					}
					$route = $this->getConfig()->getDir('include') . $version->id_include_type . '/' . $version->id . '/1/' . $file->filename;
					copy($route, $route_js . '/' . $file->filename);
				}
			}
		}
	}

	/**
	 * Crea el archivo ZIP comprimido de todo el proyecto generado
	 *
	 * @param Project $project Objeto con la información del proyecto
	 *
	 * @return void
	 */
	public function packToZip(Project $project): void {
		$route     = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/project_' . $project->id;
		$route_zip = $this->getConfig()->getDir('ofw_tmp') . 'user_' . $project->id_user . '/'.$project->slug . '.zip';

		$zip_file = new OFile();
		$zip_file->zip($route, $route_zip, $project->slug);
		OFile::rrmdir($route);
	}

	/**
	 * Obtiene la lista de plugins disponibles
	 *
	 * @return string Archivo JSON con la lista de plugins disponibles
	 */
	public function getPluginList(): string {
		return file_get_contents($this->getConfig()->getExtra('plugins_url'));
	}
}
