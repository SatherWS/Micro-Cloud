<?php
    class Database {
        /* For development
        private $server = "localhost";
        private $db = "lhapps";
        private $user = "root";
        private $pass = "mysql";
        */
	$db_params = parse_ini_file(dirname(__FILE__).'/db_params.ini', false);
        
        public function getConnection(){
            $curs = new mysqli($db_params["host"], $db_params["user"], $db_parms["password"], $db_params["dbname"]);

            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>
