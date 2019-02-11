<?php
namespace Core;

/**
 * Base Controller class
 * All controllers extends from this class
 */
class Controller {

	/**
	 * Send $variables to the view page and put it in $content.
	 * @param  string $view Is the current view file
	 * @param  array  $variables Format as Key => Value, where key is the variable that will be manipulate in the view
	 */
	protected function render(string $view, array $variables = []) {
		ob_start();
		// Import variables into the current symbol table
		extract($variables);
		if (!file_exists(CURR_VIEW_PATH . "{$view}.php")) {
			$this->notFound();
		}
		require(CURR_VIEW_PATH . "{$view}.php");
		$content = ob_get_clean();
		// Require the layout
		require(VIEW_PATH . 'layout.php');
	}

	/**
	 * Load the model name as variable inside the controller
	 * @param  string $modelName
	 */
	protected function loadModel($modelName) {
		$className = 'App\\Models\\' . ucfirst($modelName) . 'Model';
		$this->$modelName = new $className();
	}

	/**
	 * Access forbidden
	 */
	public function forbidden() {
		header('HTTP/1.0 403 Forbidden');
		ob_start();
		// Import message as variable into the current symbol table
		extract(array("message" => "403 Forbidden"));
		require(VIEW_PATH . "error.php");
		$content = ob_get_clean();
		// Require the layout
		require(VIEW_PATH . 'layout.php');
		die();
	}

	/**
	 * Page not found
	 */
	public function notFound() {
		header('HTTP/1.0 404 Not Found');
		ob_start();
		// Import message as variable into the current symbol table
		extract(array("message" => "404 Page Not Found"));
		require(VIEW_PATH . "error.php");
		$content = ob_get_clean();
		// Require the layout
		require(VIEW_PATH . 'layout.php');
		die();
	}

}
