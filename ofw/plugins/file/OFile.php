<?php
class OFile {
	public static function copy($source, $destination) {
		return copy($source, $destination);
	}

	public static function rename($old_name, $new_name) {
		return rename($old_name, $new_name);
	}

	public static function delete($name) {
		return unlink($name);
	}

	public static function rrmdir($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			if (is_dir($dir.'/'.$file)) {
				self::rrmdir($dir.'/'.$file);
			}
			else {
				unlink($dir.'/'.$file);
			}
		}
		return rmdir($dir);
	}

	public static function getOFWFolders() {
		return [
			'app',
			'app/cache',
			'app/config',
			'app/controller',
			'app/filter',
			'app/model',
			'app/service',
			'app/task',
			'app/template',
			'app/template/layout',
			'app/template/partials',
			'logs',
			'ofw',
			'ofw/core',
			'ofw/export',
			'ofw/lib',
			'ofw/locale',
			'ofw/lib/routing',
			'ofw/plugins',
			'ofw/task',
			'ofw/tmp',
			'web'
		];
	}

	public static function getOFWFiles() {
		return [
			'ofw/core/OCache.php',
			'ofw/core/OColors.php',
			'ofw/core/OConfig.php',
			'ofw/core/OController.php',
			'ofw/core/OCookie.php',
			'ofw/core/OCore.php',
			'ofw/core/ODB.php',
			'ofw/core/OForm.php',
			'ofw/core/OLog.php',
			'ofw/core/OModel.php',
			'ofw/core/OPlugin.php',
			'ofw/core/OService.php',
			'ofw/core/OSession.php',
			'ofw/core/OTemplate.php',
			'ofw/core/OTools.php',
			'ofw/core/OUrl.php',
			'ofw/core/error.php',
			'ofw/core/version.json',
			'ofw/lib/routing/sfObjectRoute.class.php',
			'ofw/lib/routing/sfObjectRouteCollection.class.php',
			'ofw/lib/routing/sfPatternRouting.class.php',
			'ofw/lib/routing/sfRequestRoute.class.php',
			'ofw/lib/routing/sfRoute.class.php',
			'ofw/lib/routing/sfRouteCollection.class.php',
			'ofw/lib/routing/sfRouting.class.php',
			'ofw/plugins/.gitignore',
			'ofw/plugins/plugins.txt',
			'ofw/task/backupAll.php',
			'ofw/task/backupDB.php',
			'ofw/task/composer.php',
			'ofw/task/generateModel.php',
			'ofw/task/plugins.php',
			'ofw/task/update.php',
			'ofw/task/updateCheck.php',
			'ofw/task/updateUrls.php',
			'ofw/task/version.php',
			'web/index.php',
			'ofw.php'
		];
	}

	private $zip_file = null;

	private function addDir($location, $name) {
		$this->zip_file->addEmptyDir($name);
		$this->addDirDo($location, $name);
	}

	private function addDirDo($location, $name) {
		$name .= '/';
		$location .= '/';
		$dir = opendir($location);
		while ($file = readdir($dir)) {
			if ($file == '.' || $file == '..') { continue; }
			if (filetype( $location . $file) == 'dir') {
				$this->addDir($location . $file, $name . $file);
			}
			else {
				$this->zip_file->addFile($location . $file, $name . $file);
			}
		}
	}

	public function zip($route, $zip_route, $basename=null) {
		if (file_exists($zip_route)) {
			unlink($zip_route);
		}

		$this->zip_file = new ZipArchive();
		$this->zip_file->open($zip_route, ZipArchive::CREATE);
		$this->addDir($route, is_null($basename) ? basename($route) : $basename);
		$this->zip_file->close();
	}
}