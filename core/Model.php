<?php
namespace Core;

/**
 * Base Model class
 * All models extends from this class
 */
class Model {

	protected $table;
	protected $db;

	/**
	 * Instansiate db variable
	 * @param Mysql $db
	 */
	public function __construct() {
		$this->db = new Mysql(
			$GLOBALS['config']['DBName'],
			$GLOBALS['config']['DBHost'],
			$GLOBALS['config']['DBUser'],
			$GLOBALS['config']['DBPass'],
			isset($GLOBALS['config']['DBPort']) ? $GLOBALS['config']['DBPort'] : null
		);
	}

	/**
	 * Get all rows of a table
	 * @return array Result of the query
	 */
	public function getAll() {
		return $this->db->query("SELECT * FROM {$this->table}");
	}

	/**
	 * Select a row by its id
	 * @param  int   $id
	 * @return array Result of the query
	 */
	public function getOne($id) {
		return $this->db->query("
			SELECT *
			FROM {$this->table}
			WHERE id = ?
		", [$id]);
	}

	/**
	 * Insert a new row
	 * @param  array $fields
	 * @return array Result of the query
	 */
	public function create($fields) {
		$sql_parts = [];
		$attributes = [];
		foreach ($fields as $key => $value) {
			$sql_parts[] = $key . " = ?";
			$attributes[] = $value;
		}
		$sql_part = implode(', ', $sql_parts);
		return $this->db->query("
			INSERT INTO {$this->table}
			SET {$sql_part}
		", $attributes);
	}

	/**
	 * Update a row
	 * @param  int   $id
	 * @param  array $fields
	 * @return array Result of the query
	 */
	public function update($id, $fields) {
		$sql_parts = [];
		$attributes = [];
		foreach ($fields as $key => $value) {
			$sql_parts[] = $key . " = ?";
			$attributes[] = $value;
		}
		$attributes[] = $id;
		$sql_part = implode(', ', $sql_parts);
		return $this->db->query("
			UPDATE {$this->table}
			SET {$sql_part}
			WHERE id = ?
		", $attributes);
	}

	/**
	 * Delete a row
	 * @param  int   $id
	 * @return array Result of the query
	 */
	public function delete($id) {
		return $this->db->query("
			DELETE FROM {$this->table}
			WHERE id = ?
		", [$id]);
	}

}
