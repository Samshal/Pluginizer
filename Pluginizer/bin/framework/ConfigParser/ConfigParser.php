<?php
/**
 * ConfigParser: Parses a configuration file into an array object
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 5th January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/

namespace Plug\Framework\ConfigParser;

use Plug\Framework\Utitlity\FileUtility as FileUtility;

class ConfigParser
{
	private $config_file;

	public function __construct($config_file)
	{
		if (false === file_exists($config_file))
		{
			return;
		}

		$this->config_file = $config_file;
	}

	public function parse()
	{
		$file_type = FileUtility::getExtension($this->config_file);
	}
}
?>