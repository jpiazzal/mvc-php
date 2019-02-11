<?php
/**
 * Used to setup the application
 */
class Router {

	/**
	 * Run all class functions
	 */
	public static function run() {
		self::init();
		self::autoload();
		self::dispatch();
	}

	/**
	 * Initialization of the constants
	 * Prepare the routing
	 * Load configuration file
	 * Start session
	 */
	private static function init() {
		// Define path constants
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", dirname(__DIR__) . DS);

		define("APP_PATH", ROOT . "app" . DS);
		define("CORE_PATH", ROOT . "core" . DS);
		define("PUBLIC_PATH", ROOT . "public" . DS);
		define("CONFIG_PATH", ROOT . "config" . DS);

		define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
		define("MODEL_PATH", APP_PATH . "models" . DS);
		define("VIEW_PATH", APP_PATH . "views" . DS);

		// Define controllers namespace
		define("CONTROLLER_NAMESPACE", "\App\Controllers\\");

		// Define platform, controller and action
		// Example: index.php?p=home&c=index&a=index
		define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
		define("CONTROLLER", isset($_REQUEST['c']) ? ucfirst($_REQUEST['c']) : 'Index');
		define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

		define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
		define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

		define("CURR_CONTROLLER_NAMESPACE", CONTROLLER_NAMESPACE . ucfirst(PLATFORM) . "\\");

		// Load Router core classes
		require CORE_PATH . "Controller.php";
		require CORE_PATH . "Model.php";
		require CORE_PATH . "Mysql.php";

		// Load configuration file
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";

		// Start session
		session_start();
	}

	/**
	 * Autoloading
	 */
	private static function autoload() {
		spl_autoload_register(array(__CLASS__, 'load'));
	}

	/**
	 * Custom load method
	 * @param  string $className
	 */
	private static function load($className) {
		// Remove the namespace to require only the class name
		$classArray = explode("\\", $className);
		$arrayLength = count($classArray);
		$className = $classArray[$arrayLength -1];
		// Autoload app’s controller or model class
		if (substr($className, -10) == "Controller") {
			// If file doesn't exist
			if (!file_exists(CURR_CONTROLLER_PATH . "{$className}.php")) {
				require_once CONTROLLER_PATH . "home/IndexController.php";
			} else {
				require_once CURR_CONTROLLER_PATH . "{$className}.php";
			}
		} else if (substr($className, -5) == "Model") {
			require_once  MODEL_PATH . "{$className}.php";
		}
	}

	/**
	 * Routing and dispatching
	 */
	private static function dispatch(){
		// Instantiate the controller class and call its action method
		$controllerName = CURR_CONTROLLER_NAMESPACE . CONTROLLER . "Controller";
		$action = ACTION;
		// If class doesn't exist
		if (!class_exists($controllerName)) {
			$controllerName = CONTROLLER_NAMESPACE . "Home\IndexController";
		}
		$controller = new $controllerName;
		if (method_exists($controller, $action)) {
			$controller->$action();
		} else {
			$controller->notFound();
		}
	}

}
