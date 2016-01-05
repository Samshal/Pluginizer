<?php
namespace Plug\Framework\DBAL\QueryBuilder;

/**
 * BuildableInterface: All QueryBuilder object must implement this interface
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 3rd January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/
interface BuildableInterface
{
	/**
	 * build method. Call this method on a QueryBuilder object to piece together every sql fragment
	 * and generate an sql string. It then emits the generated string as a return value.
	 *
	 * @return string An SQL string.
	 *
	*/
	public function build();
}
?>