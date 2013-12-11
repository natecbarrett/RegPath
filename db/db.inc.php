<?php

// Define configuration
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "reg_path");

class clsDataBase
{
	private $dbh;		//The database handle.
	private $error;		//Any connection errors.

	private $statement;	//The prepared statement.

	private $host = DB_HOST;		//Db host
	private $user = DB_USER;		//Db user
	private $pass = DB_PASS;		//Db password
	private $dbname = DB_NAME;		//Db name

	public function __construct()
	{
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

		// Set options
		$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try {
			//Create a new PDO instance.
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}

		// Catch any errors
		catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}

	public function bind($param, $value, $type = null)
	{
		//Check if no type was passed in,
		if (is_null($type))
		{
			//Determine the type.
			switch (true) {

				//Is it an int
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;

				//Is it a bool
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;

				//Is it a null param
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;

				//Otherwise, its a string.
				default:
					$type = PDO::PARAM_STR;
			}
		}

		//Bind the values.
		$this->statement->bindValue($param, $value, $type);
	}

	public function debugDumpParams()
	{
		$this->statement->debugDumpParams();
	}

	public function beginTransaction()
	{
		$this->dbh->beginTransaction();
	}

	public function endTransaction()
	{
		$this->dbh->commit();
	}

	public function cancelTransaction()
	{
		//Rollback the transaction,
		$this->dbh->rollBack();
	}
	public function lastInsetID()
	{
		//Return the last insert id.
		$this->dbh->lastInsertId();
	}

	public function rowcount()
	{
		//Return the row count.
		return $this->statement->rowCount();
	}

	public function single()
	{
		$this->execute();
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	public function resultset()
	{

		//Execute and return the results
		$this->execute();
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function execute()
	{
		//Execute the statement.
		return $this->statement->execute();
	}

	public function query($query)
	{
		//Prepare the statement
		$this->statement = $this->dbh->prepare($query);
	}
}