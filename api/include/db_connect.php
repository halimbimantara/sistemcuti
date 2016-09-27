<?php

/**
 * Handling database connection
 *
 * @author RT
 * @link URL Tutorial link
 */
class DbConnect {

    private $conn,$conn_simpeg;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include_once dirname(__FILE__) . '/config.php';

        // Connecting to mysql database
        $this->conn = new PDO('mysql:dbname='.$dbName.';host='.$host, $user, $pwd);
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn;
    }
	
	function connect_simpeg(){
		include_once dirname(__FILE__) . '/config_simpeg.php';

        // Connecting to mysql database
        $this->conn_simpeg = new PDO('mysql:dbname='.$dbName.';host='.$host, $user, $pwd);
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn_simpeg;
	}

}

?>
