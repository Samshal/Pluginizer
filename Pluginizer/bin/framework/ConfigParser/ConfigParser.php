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

class ConfigParser implements ParseableInterface
{
	private $config_file;

	/**
	 * Constructor
	*/
	public function __construct($config_file)
	{
		if (false === file_exists($config_file))
		{
			return;
		}

		$this->config_file = $config_file;
	}

	/**
	 * @see Plug\Framework\ConfigParser\ParseableInterface::parse()
	 * for a detailed explanation of what this method is all about
	 * @return array
	 * @todo the file below contains some todo dockblock tags.
	 * @throws (@todo check for the exceptions this class throws)
	*/
	public function parse()
	{
		$file_type = FileUtility::getExtension($this->config_file);

		switch(strtolower($file_type))
		{
			case "json":
			{
				$parsed_content = JsonConfigParser::parse($config_file);
				break;
			}
			case "xml":
			{
				$parsed_content = XmlConfigParser::parse($config_file);
				break;
			}
			default:
			{
				/**
				 * @todo Throw an exception: Invalid file type encountered
				*/
				return;
			}
		}
		if (isset($parsed_content) === false || is_array($parsed_content) === false)
		{
			/**
			 * @todo Something fishy is going on here. Why is $parsed_content not set?
			 * probably becase the compiler forgot to execute the default statement up there
			 * anyway, maybe another exception definition will do?
			*/
			return;
		}

		return $parsed_content;

	}
}
?>