<?php

/**
 * A model to handle all operations over a database
 */

class Task {

    protected $_database = null;
    private $_table = "";
	private $_taskList;

    public function __construct() {

         // parses the settings file
		$settings = parse_ini_file(ROOT_PATH . '/config/settings.ini', true);
		
        // starts the connection to the database
		$this->_database = new PDO(
			sprintf(
				"%s:host=%s;dbname=%s",
				$settings['database']['driver'],
				$settings['database']['host'],
				$settings['database']['dbname']
			),
			$settings['database']['user'],
			$settings['database']['password'],
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		);

    }

	public function fetchAll()
	{
		$sql = 'SELECT * FROM task';

		$result = $this->_database->query($sql);
	
		while ($row = $result->fetch(PDO::FETCH_OBJ))
		{
			$this->_taskList[] = $row;
		}
		
		return $this->_taskList;
	}

    public function fetchOne($id)
	{
		$sql = 'SELECT * FROM task WHERE id = ?';
		
		$statement = $this->_database->prepare($sql);

		$_result = $this->_database->query($sql);

		$row = $_result->fetch(PDO::FETCH_ASSOC);
		
		return $row;
	}
	
	/**
	 * Get the 'id' of the last task inseted into the database
	 */
	public function getLastId()
	{
		$lastId = $this->_database->lastInsertId();

		return $lastId;
	}

	/**
	 * Saves the current data to the database. If an key named "id" is given,
	 * an update will be issued.
	 * @param array $data the data to save
	 * @return int the id the data was saved under
	 */
	public function save($data = array())
	{
		$sql = '';
		
		$values = array();
		
		if (array_key_exists('id', $data)) {
			$sql = 'UPDATE task SET ';
			
			$first = true;
			foreach($data as $key => $value) {
				if ($key != 'id') {
					$sql .= ($first == false ? ',' : '') . ' ' . $key . ' = ?';
					
					$values[] = $value;
					
					$first = false;
				}
			}
			
			// adds the id as well
			$values[] = $data['id'];
			
			$sql .= ' where id = ?';// . $data['id'];
			
			$statement = $this->_database->prepare($sql);
			return $statement->execute($values);
		}
		else {
			$keys = array_keys($data);
			
			$sql = 'INSERT INTO task (';
			$sql .= implode(',', $keys);
			$sql .= ')';
			$sql .= ' VALUES (';
			
			$dataValues = array_values($data);
			$first = true;
			foreach($dataValues as $value) {
				$sql .= ($first == false ? ',?' : '?');
				
				$values[] = $value;
				
				$first = false;
			}
			
			$sql .= ')';
			
			$statement = $this->_database->prepare($sql);
			if ($statement->execute($values)) {
				return $this->_database->lastInsertId();
			}
		}
		
		return false;
	}
	
	/**
	 * Deletes a single entry
	 * @param int $id the id of the entry to delete
	 * @return boolean true if all went well, else false.
	 */
	public function delete($id)
	{
		$statement = $this->_database->prepare("DELETE FROM task WHERE id = ?");
		return $statement->execute(array($id));
	}
}

?>