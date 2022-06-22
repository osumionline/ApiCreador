<?php declare(strict_types=1);

namespace OsumiFramework\OFW\Plugins;

/**
 * Class with static functions to manage files (copy, rename, delete, zip...)
 */
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
			'app/component',
			'app/config',
			'app/dto',
			'app/filter',
			'app/layout',
			'app/model',
			'app/module',
			'app/service',
			'app/task',
			'logs',
			'ofw',
			'ofw/cache',
			'ofw/export',
			'ofw/lib',
			'ofw/locale',
			'ofw/plugins',
			'ofw/task',
			'ofw/template',
			'ofw/template/add',
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
			'ofw/vendor',
			'ofw/vendor/cache',
			'ofw/vendor/cli',
			'ofw/vendor/core',
			'ofw/vendor/db',
			'ofw/vendor/log',
			'ofw/vendor/migrations',
			'ofw/vendor/routing',
			'ofw/vendor/tools',
			'ofw/vendor/web',
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
			'ofw/cache/.gitignore',
			'ofw/export/.gitignore',
			'ofw/locale/en.po',
			'ofw/locale/es.po',
			'ofw/locale/eu.po',
			'ofw/plugins/.gitignore',
			'ofw/plugins/plugins.txt',
			'ofw/task/add.task.php',
			'ofw/task/backupAll.task.php',
			'ofw/task/backupDB.task.php',
			'ofw/task/extractor.task.php',
			'ofw/task/generateModel.task.php',
			'ofw/task/plugins.task.php',
			'ofw/task/reset.task.php',
			'ofw/task/update.task.php',
			'ofw/task/updateCheck.task.php',
			'ofw/task/updateUrls.task.php',
			'ofw/task/version.task.php',
			'ofw/template/error.php',
			'ofw/template/add/add.php',
			'ofw/template/add/createAction.php',
			'ofw/template/add/createModelComponent.php',
			'ofw/template/add/createModule.php',
			'ofw/template/add/createService.php',
			'ofw/template/add/createTask.php',
			'ofw/template/backupAll/backupAll.php',
			'ofw/template/backupDB/backupDB.php',
			'ofw/template/extractor/extractor.php',
			'ofw/template/generateModel/generateModel.php',
			'ofw/template/plugins/availablePlugins.php',
			'ofw/template/plugins/installedPlugins.php',
			'ofw/template/plugins/installPlugin.php',
			'ofw/template/plugins/plugins.php',
			'ofw/template/plugins/removePlugin.php',
			'ofw/template/plugins/update.php',
			'ofw/template/plugins/updateCheck.php',
			'ofw/template/update/update.php',
			'ofw/template/updateCheck/updateCheck.php',
			'ofw/template/updateUrls/updateUrls.php',
			'ofw/template/version/version.php',
			'ofw/tmp/.gitignore',
			'ofw/vendor/cache/ocache.class.php',
			'ofw/vendor/cache/ocache.container.class.php',
			'ofw/vendor/cli/cli.php',
			'ofw/vendor/core/ocomponent.class.php',
			'ofw/vendor/core/oconfig.class.php',
			'ofw/vendor/core/ocore.class.php',
			'ofw/vendor/core/odto.interface.php',
			'ofw/vendor/core/oplugin.class.php',
			'ofw/vendor/core/oservice.class.php',
			'ofw/vendor/core/otask.class.php',
			'ofw/vendor/core/otemplate.class.php',
			'ofw/vendor/core/otranslate.class.php',
			'ofw/vendor/core/oupdate.class.php',
			'ofw/vendor/db/odb.class.php',
			'ofw/vendor/db/odb.container.class.php',
			'ofw/vendor/db/omodel.class.php',
			'ofw/vendor/log/olog.class.php',
			'ofw/vendor/routing/oaction.class.php',
			'ofw/vendor/routing/omodule.class.php',
			'ofw/vendor/routing/omoduleaction.class.php',
			'ofw/vendor/routing/oroutecheck.class.php',
			'ofw/vendor/routing/ourl.class.php',
			'ofw/vendor/tools/ocolors.class.php',
			'ofw/vendor/tools/oform.class.php',
			'ofw/vendor/tools/otools.class.php',
			'ofw/vendor/web/ocookie.class.php',
			'ofw/vendor/web/orequest.class.php',
			'ofw/vendor/web/osession.class.php',
			'ofw/vendor/version.json',
			'web/.htaccess',
			'web/favicon.png',
			'web/index.php'
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