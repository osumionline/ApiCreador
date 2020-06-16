<?php declare(strict_types=1);
class OFile {
	/**
	 * Copy a file from a source to a destination
	 *
	 * @param string $source Source path of a file
	 *
	 * @param string $destination Destination path of a file
	 *
	 * @param bool File gets copied or not
	 */
	public static function copy(string $source, string $destination): bool {
		return copy($source, $destination);
	}

	/**
	 * Rename or move a file from a source to a destination
	 *
	 * @param string $source Source path of a file
	 *
	 * @param string $destination Destination path of a file or new name
	 *
	 * @return bool File gets moved/renamed or not
	 */
	public static function rename(string $old_name, string $new_name): bool {
		return rename($old_name, $new_name);
	}

	/**
	 * Delete a file
	 *
	 * @param string $source Path of a file
	 *
	 * @return bool File gets deleted or not
	 */
	public static function delete(string $name): bool {
		return unlink($name);
	}

	/**
	 * Delete a folder and all of its content recursively
	 *
	 * @param string $dir Source path of a directory
	 *
	 * @return bool Folder gets deleted or not
	 */
	public static function rrmdir(string $dir): bool {
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

	/**
	 * Returns list of folders in the Osumi Framework
	 *
	 * @return array List of folders
	 */
	public static function getOFWFolders(): array {
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
			'ofw/lib/routing',
			'ofw/locale',
			'ofw/plugins',
			'ofw/task',
			'ofw/template',
			'ofw/template/backupAll',
			'ofw/template/backupDB',
			'ofw/template/extractor',
			'ofw/template/generateModel',
			'ofw/template/plugins',
			'ofw/template/update',
			'ofw/template/updateCheck',
			'ofw/template/updateUrls',
			'ofw/template/version',
			'ofw/tmp',
			'web'
		];
	}

	/**
	 * Returns list of files in the Osumi Framework
	 *
	 * @return array List of files
	 */
	public static function getOFWFiles(): array {
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
			'ofw/core/ORequest.php',
			'ofw/core/OService.php',
			'ofw/core/OSession.php',
			'ofw/core/OTask.php',
			'ofw/core/OTemplate.php',
			'ofw/core/OTools.php',
			'ofw/core/OUpdate.php',
			'ofw/core/OUrl.php',
			'ofw/core/version.json',
			'ofw/export/.gitignore',
			'ofw/lib/routing/sfObjectRoute.class.php',
			'ofw/lib/routing/sfObjectRouteCollection.class.php',
			'ofw/lib/routing/sfPatternRouting.class.php',
			'ofw/lib/routing/sfRequestRoute.class.php',
			'ofw/lib/routing/sfRoute.class.php',
			'ofw/lib/routing/sfRouteCollection.class.php',
			'ofw/lib/routing/sfRouting.class.php',
			'ofw/locale/en.php',
			'ofw/locale/es.php',
			'ofw/plugins/.gitignore',
			'ofw/plugins/plugins.txt',
			'ofw/task/backupAll.php',
			'ofw/task/backupDB.php',
			'ofw/task/extractor.php',
			'ofw/task/generateModel.php',
			'ofw/task/plugins.php',
			'ofw/task/update.php',
			'ofw/task/updateCheck.php',
			'ofw/task/updateUrls.php',
			'ofw/task/version.php',
			'ofw/template/error.php',
			'ofw/template/backupAll/backupAll.php',
			'ofw/template/backupDB/backupDB.php',
			'ofw/template/extractor/extractor.php',
			'ofw/template/generateModel/generateModel.php',
			'ofw/template/plugins/availablePlugins.php',
			'ofw/template/plugins/installedPlugins.php',
			'ofw/template/plugins/installPlugin.php',
			'ofw/template/plugins/plugins.php',
			'ofw/template/plugins/removePlugin.php',
			'ofw/template/plugins/updated.php',
			'ofw/template/plugins/updateCheck.php',
			'ofw/template/update/update.php',
			'ofw/template/updateCheck/updateCheck.php',
			'ofw/template/updateUrls/updateUrls.php',
			'ofw/template/version/version.php',
			'web/index.php',
			'ofw.php'
		];
	}

	private $zip_file = null;

	/**
	 * Adds dir to the zip file to be created
	 *
	 * @param string $location Base path to be added
	 *
	 * @param string $name Name of the file to be created
	 *
	 * @return void
	 */
	private function addDir(string $location, string $name): void {
		$this->zip_file->addEmptyDir($name);
		$this->addDirDo($location, $name);
	}

	/**
	 * Adds folder and all of its files to the zip file to be created
	 *
	 * @param string $location Base path to be added
	 *
	 * @param string $name Name of the file to be created
	 *
	 * @return void
	 */
	private function addDirDo(string $location, string $name): void {
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

	/**
	 * Create a new zip file
	 *
	 * @param string $route Path to be added
	 *
	 * @param string $zip_route Path of the new zip file
	 *
	 * @param string $basename Base path of the folder to be added
	 *
	 * @return void
	 */
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