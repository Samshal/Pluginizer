<?php
/**
 * A curated list of functions and properties that makes file management and access very easy
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 5th January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/

namespace Pluginizer\Framework\Utility;

class FileUtility
{
	/**
	 * Get a files extension
	 *
	 * @param string $file_name
	 * @return string File Extension
	*/
	public static function getExtension(string $file_name)
	{
		$file_name_exploded = explode(".", $file_name);

		$file_extension = $file_name_exploded[count($file_name_exploded) - 1];

		return $file_extension;
	}
}
?>