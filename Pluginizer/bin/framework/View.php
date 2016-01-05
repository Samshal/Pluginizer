<?php
namespace Pluginizer\Framework;
/**
 * Pluginizer\Framework\View: Helper Class for simplifying most tasks within the custom view's of all modules
 *
 * Please note that this class provides no public interface for construction, so it can't be
 * instanticated using the 'new' keyword
 * It has `static` methods for loading images, scripts, styles and what have you from their absolute urls into
 * an included file.
 *
 * @author Samuel Adeshina <samueladeshina73@gmail.com> <http://samshal.github.io>
 * @copyright 2016 - Samuel Adeshina
 * @version 0.0.1
 * @since 04 January, 2016
 * @license MIT
*/
class View
{
	/**
	 * @var string $current_module_name;
	 * @access private
	*/
	private $current_module_name;

	/**
	 * @var string $protocol Current Protocol f.ex: http:// or file:// or //
	 * @access public
	*/
	public static $protocol;

	/**
	 * Constructor Gets the current module name from the return value of the debug_backtrace function\
	 * It also sets the protocol
	 * @access private
	 * Class cannot be instantiated using the `new` keyword
	*/
	private function __construct()
	{
		$current_module_name = dirname(debug_backtrace()[2]["file"]);

		$current_module = explode("\\", $current_module_name);
		if (false !== in_array("modules", $current_module))
		{
			$location = array_search("modules", $current_module);
			$module = $current_module[$location + 1];
			$this->current_module_name = $module;
			View::setProtocol();
		}
		return; 
		/**
		 * @todo instead of ending execution, shouldn't we be throwing an exception?
		*/
	}

	/**
	 * The getCurrentModule() method is a static one, and is responsible for getting the module name of the 
	 * module that's been worked on.
	 * @return string Current Module Name;
	*/
	private static function getCurrentModule()
	{
		return (new View())->current_module_name;
	}

	/**
	 * Set the protocol of the current web server
	 * @param string $protocol protocol name
	 * @return void
	*/
	public static function setProtocol(string $protocol = null)
	{
		if (false === is_null($protocol))
		{
			View::$protocol = $protocol;
			return;
		}
		View::$protocol = "//";
	}

	/**
	 * Based on the current module name, current protocol and relative file paths,
	 * this method returns an absolute url of the current module
	 * @param string $module_name
	 * @return string
	 */
	private static function generateModuleURI(string $module_name)
	{
		$module_uri = View::$protocol.$_SERVER["HTTP_HOST"];
		$module_uri .= DIRECTORY_SEPARATOR . "modules";
		$module_uri .= DIRECTORY_SEPARATOR . $module_name;
		$module_uri .= DIRECTORY_SEPARATOR . "bin";

		return $module_uri;
	}

	/**
	 * @return string
	*/
	private static function URI(string $uri)
	{
		$uri = str_replace(DIRECTORY_SEPARATOR, "/", $uri);
		return $uri;
	}
	public static function Image(string $image_name)
	{
		$bin = View::generateModuleURI(View::getCurrentModule());
		$image_uri = $bin.DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$image_name;

		return View::URI($image_uri);
	}

	public static function Script(string $script_name)
	{
		$bin = View::generateModuleURI(View::getCurrentModule());
		$script_uri = $bin.DIRECTORY_SEPARATOR."shared";
		$script_uri .= DIRECTORY_SEPARATOR."scripts";
		$script_uri .= DIRECTORY_SEPARATOR.$script_name;

		return View::URI($script_uri);
	}

	public static function Style(string $style_name)
	{
		$bin = View::generateModuleURI(View::getCurrentModule());
		$style_uri = $bin.DIRECTORY_SEPARATOR."shared";
		$style_uri .= DIRECTORY_SEPARATOR."styles";
		$style_uri .= DIRECTORY_SEPARATOR.$script_name;

		return View::URI($style_uri);
	}

	public static function File(string $file_path_plus_name)
	{
		
	}
}
?>