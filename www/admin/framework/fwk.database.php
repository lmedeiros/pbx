<?php
class Database {
    private $username = db_user;
    private $password = db_password;
    private $server = db_server;
    private $schema = db_database;
    public $database;

    function connectToDatabase() {
	try {
            $this->database = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->schema . "", $this->username, $this->password,  array(PDO::ATTR_PERSISTENT => true));
	     $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
            echo $e->getMessage();
	}
    }

    function selectRow($sql) {
        $this->database->exec("SET NAMES UTF8");
        try {
            $query = $this->database->query($sql);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
	} catch(PDOException $e) {
            print "ERROR ON SQL COMMAND: " . $sql . "<br/>" .$e;
            return $e;
	}
    }

    function selectAll($sql) {
        $this->database->exec("SET NAMES UTF8");
        try {
            $query = $this->database->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            print "ERROR ON SQL COMMAND: " . $sql . "<br/>" .$e;
            return $e;
        }
    }


    function command($sql) {
    $this->database->exec("SET NAMES UTF8");
        try {
            $result = $this->database->exec($sql);
            return $result;
        } catch(PDOException $e) {
            //echo "ERROR ON SQL COMMAND: " . $sql . "<br/>" .$e;
            return $e;
        }
    }

    function __construct() {
        $this->connectToDatabase();
        return $this->database;
    }
}

$db = new Database;
?>
