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
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
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
     $this->conn_simpeg = new mysqli(DB_HOST_SI, DB_USERNAME_SI, DB_PASSWORD_SI, DB_NAME_SI);
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn_simpeg;
	}

}

?>
