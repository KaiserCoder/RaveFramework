<?php

namespace rave\core\database\driver\SQLiteDriverPDO;

use PDO, PDOException;

use rave\core\Error;
use rave\core\Config;

use rave\core\database\driver\GenericDriver;

class SQLiteDriverPDO implements GenericDriver
{
    private static $instance;

    private static function getInstance()
    {
        $config = Config::get('database');

        if (!isset(self::$instance)) {
            try {
		        self::$instance = new PDO('sqlite:' . $config['path']);
		        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $pdoException) {
                Error::create($pdoException->getMessage(), 500);
            }
        }

	    return self::$instance;
    }

    private function queryDatabase(string $statement, array $values, bool $unique)
    {
        try {
            $sql = self::getInstance()->prepare($statement);
            $sql->execute($values);

            if ($unique === true) {
                $result = $sql->fetch(PDO::FETCH_OBJ);
                return $result === false ? null : $result;
            }
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result === false ? null : $result;
        } catch (PDOException $pdoException) {
            Error::create($pdoException->getMessage(), 500);
        }
    }

    public function query(string $statement, array $values = []): array
    {
	    return $this->queryDatabase($statement, $values, false);
    }

    public function queryOne(string $statement, array $values = [])
    {
	    return $this->queryDatabase($statement, $values, true);
    }

    public function execute(string $statement, array $values = [])
    {
        try {
            $sql = self::getInstance()->prepare($statement);
            $sql->execute($values);
        } catch (PDOException $pdoException) {
            Error::create($pdoException->getMessage(), 500);
        }
    }

    public function lastInsertId(): string
    {
        return self::getInstance()->lastInsertId();
    }

}