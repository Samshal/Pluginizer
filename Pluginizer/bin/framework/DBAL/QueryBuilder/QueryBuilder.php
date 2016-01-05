<?php
/**
 * QueryBuilder: An SQL Query Builder class
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 3rd January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/

namespace Plug\Framework\DBAL\QueryBuilder;

/**
 * A very simple demonstration of this class' usage is illustrated below
 * @example 
 *		require "my_autoloader.php"; //require your autoloader or manually invlude every class involved in this project
 *		
 *		$queryBuilder = new \Plug\DBAL\QueeryBuilder\QueryBuilder();
 *		$query_string = $queryBuilder
 *						->select("first_name", "last_name", "middle_name")
 *						->from("CustomerInfo")
 *						->where("customer_id > 300")
 *						->build();
 *		echo $query_string //outputs: "SELECT first_name, last_name, midddle_name FROM CustomerInfo WHERE customer_id > 300"
 */

class QueryBuilder implements BuildableInterface
{
	/**
	 * @var string $query_string The actual sql string objects that query fragments are appended to
	*/
	private $query_string;

	/**
	 * Constructor
	*/
	public function __construct(string $query_string = null)
	{
		//Initialize the $query_string object
		$this->query_string = $query_string;
	}

	/**
	 * build method.
	 *
	 * @return string
	 * @see BuildableInterface::build() for more info about this function
	*/
	public function build()
	{
		return $this->query_string;
	}

	/**
	 * Append a string to the $query_string object
	 *
	 * @return void
	*/
	private function appendToQueryString(string $string, $trim_comma = false)
	{
		if ($trim_comma === true)
		{
			$this->query_string = trim($this->query_string, ",");
		}
		if (strlen($string) > 0)
		{
			$this->query_string .= " ".$string;
			return;
		}

		$this->query_string .= $string;
	}

	/**
	 * select() method. Generate a SELECT Fragment
	 *
	 * Please Note That: calling this method with no parameters means you are "selecting * from ..."
	 * 
	 * @param variadic string|null $select_options Specify as many parameters as is possible
	 * @return void
	 * @example select("first_name", "last_name")
	*/
	public function select(string ...$select_options)
	{
		//was there any parameter?
		if (empty($select_options))
		{
			$select_options_string = "*";
		}
		else
		{
			/**
			 * @var string $select_options_string implode the $select_options array into a string delimited by a comma except
			 * the last value in the array
			 * @example if we have an array that looks like this
			 * array('first_name', 'last_name', 'middle_name');
			 * The statement below returns
			 * "first_name, last_name, middle_name";
			*/
			$select_options_string = rtrim(implode(",", $select_options), ",");
		}

		$select_option = "SELECT ".$select_options_string;

		$this->appendToQueryString($select_option);

		return new QueryBuilder($this->query_string);
	}

	/**
	 * from() method. Generate a FROM Fragment
	 *
	 * Please Note That: calling this method with no parameter is not supported
	 * 
	 * @param variadic string|null $select_options Specify as many parameters as is possible
	 * @return void
	*/
	public function from(string ...$from_options)
	{
		//was there any parameter?
		if (empty($from_options))
		{
			return;
		}

		/**
		 * @var string $from_options_string implode the $from_options array into a string delimited by a comma except
		 * the last value in the array
		 * @example if we have an array that looks like this
		 * array('customerInfo', 'employeeStatus');
		 * The statement below returns
		 * "customerInfo, employeeStatus";
		*/
		$from_options_string = rtrim(implode(",", $from_options), ",");

		$from_option = "FROM ".$from_options_string;

		$this->appendToQueryString($from_option);

		return new QueryBuilder($this->query_string);
	}

	/**
	 * where() method. Generate a WHERE Fragment
	 *
	 * Please Note That: calling this method with no parameter is not supported
	 * 
	 * @param string $where_option
	 * @return QueryBuilder new instance of the QueryBuilder object
	*/
	public function where(string $where_option)
	{
		//was there any parameter?
		if (empty($where_option))
		{
			return;
		}

		$where_option = "WHERE ".$where_option;

		$this->appendToQueryString($where_option, true);

		return new QueryBuilder($this->query_string);
	}

	/**
	 * insert() method. Generate an INSERT Fragment
	 */
	public function insert()
	{
		$insert_option = "INSERT";

		$this->appendToQueryString($insert_option);

		return new QueryBuilder($this->query_string);
	}

	/**
	 * into(). Generates an INTO Fragment
	 *
	 * @param string $into_option The table name to insert into
	 * @param QueryBuilder|null 
	 * @return QueryBuilder a new instance of this object
	 */
	public function into(string $into_option, $query_builder_columns_object = null)
	{
		//was there any parameter?
		if (empty($into_option))
		{
			return;
		}

		$into_option = "INTO ".$into_option;
		if (false === is_null($query_builder_columns_object))
		{
			$into_option .= "(".$query_builder_columns_object.")";
		}

		$this->appendToQueryString($into_option);

		return new QueryBuilder($this->query_string);
	}

	public static function columns(string ...$column_options)
	{
		//was there any parameter?
		if (empty($column_options))
		{
			return;
		}

		$columns = rtrim(implode(",", $column_options), ",");

		return $columns;
	}

	public function values(string ...$values_options)
	{
		if (empty($values_options))
		{
			return;
		}

		array_walk($values_options, function(&$value, $location){
			if (false === is_numeric($value))
			{
				$value = "'".$value."'";
			}
		});

		$values = "VALUES(".rtrim(implode(",", $values_options), ",").")";

		$this->appendToQueryString($values);

		return new QueryBuilder($this->query_string);
	}

	public function update(string $update_option)
	{
		if (empty($update_option))
		{
			return;
		}

		$update_string = "UPDATE TABLE ".$update_option." SET";

		$this->appendToQueryString($update_string);

		return new QueryBuilder($this->query_string);
	}

	public function set(string $set_option_name, string $set_option_value)
	{
		$set_option_value = is_numeric($set_option_value) ? $set_option_value : "'".$set_option_value."'";
		$set_option = $set_option_name." = ".$set_option_value.",";

		$this->appendToQueryString($set_option);

		return new QueryBuilder($this->query_string);
	}

	public function delete(string $delete_option)
	{
		if (empty($delete_option))
		{
			return;
		}

		$delete_string = "DELETE FROM ".$delete_option;

		$this->appendToQueryString($delete_string);

		return new QueryBuilder($this->query_string);
	}

}
?>