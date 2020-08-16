<?php
    class Database {
        public function getConnection(){
	        $db_params = parse_ini_file(dirname(__FILE__).'/db_params.ini', false);
            $curs = new mysqli($db_params["host"], $db_params["user"], $db_params["password"], $db_params["dbname"]);

            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>
