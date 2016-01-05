<?php
/**
 * Interface ParseableInterface
 * All ConfigParser Object must implement This interface.
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 5th January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/

namespace Plug\Framework\ConfigParser;

interface ParseableInterface
{
	/**
	 * Parses the configuration file.
	 *
	 * @return array an object content of the parsed file
	*/
	public function parse();
}
?>