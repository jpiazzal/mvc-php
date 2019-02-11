<?php
namespace Core;

use \PDO;

/**
 * Used to manage database
 */
class Mysql {

	private $DBName;
	private $DBUser;
	private $DBPass;
	private $DBHost;
	private $DBPort;
	private $pdo;
	private $request;

	/**
	 * Instansiate variables
	 * @param string $DBName Use for the Data Source Name
	 * @param string $DBUser Database User
	 * @param string $DBPass Database password for the user
	 * @param string $DBHost Host of the database
	 * @param int    $DBPort Port of the database, default 3306
	 */
	public function __construct($DBName, $DBHost, $DBUser, $DBPass, $DBPort = 3306) {
		$this->DBName = $DBName;
		$this->DBHost = $DBHost;
		$this->DBUser = $DBUser;
		$this->DBPass = $DBPass;
		$this->DBPort = $DBPort;
		$this->connect();
	}

	/**
	 * Create a new PDO instance
	 */
	private function connect() {
		try {
			$this->pdo = new PDO('mysql:dbname=' . $this->DBName . ';host=' . $this->DBHost . ';port=' . $this->DBPort,
				$this->DBUser,
				$this->DBPass,
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				)
			);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Set parameters with bindParam() depending on it's a sequential or associative array
	 * @param  array  $params
	 */
	private function setParams($params) {
		$sequentialArray = false;
		// Check if $params is a sequential array
		if (array_keys($params) === range(0, count($params) - 1)) {
			$sequentialArray = true;
		}
		foreach ($params as $key => $value) {
			$this->request->bindParam($sequentialArray ? intval($key) + 1 : ":" . $key, $params[$key]);
		}
	}

	/**
	 * Make the request to the database
	 * @param  string $query
	 * @param  array  $params
	 * @return array  Returns the number of rows affected or an array containing all of the result set rows (default return is the success of the request)
	 */
	public function query($query, $params = array(), $fetchmode = PDO::FETCH_ASSOC) {
		// Isolate de request type in upper case (INSERT, SELECT...)
		$query = trim($query);
		$requestType = strtoupper(explode(" ", $query)[0]);

		$this->request = $this->pdo->prepare($query);
		if (!empty($params)) {
			$this->setParams($params);
		}
		$success = $this->request->execute();
		if ($requestType == 'INSERT' || $requestType == 'UPDATE' || $requestType == 'DELETE') {
			return array(
				"rowsAffected" => $this->request->rowCount()
			);
		} else if ($requestType == 'SELECT' || $requestType == 'SHOW') {
			return $this->request->fetchAll($fetchmode);
		}
		return array(
			"success" => $success
		);
	}

	/**
	 * @return string Returns the ID of the last inserted row or sequence value
	 */
	public function lastInsertId() {
		return $this->pdo->lastInsertId();
	}

}
