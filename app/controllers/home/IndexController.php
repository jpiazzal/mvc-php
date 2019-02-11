<?php
namespace App\Controllers\Home;

use \Core\Controller;

/**
 * Display home index
 */
class IndexController extends Controller {

	public function __construct() {
		// $this->loadModel('Example');
	}

	public function index() {
		// $data = $this->ExampleModel->getAll();
		$this->render("index", ["message" => "Hello from Home Page"]);
	}
}
