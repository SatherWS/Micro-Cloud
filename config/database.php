<?php

    class Database {
        private $hostname = "localhost";
        private $user = "root";
        private $database = "swoop";
        private $password = "toor";

        public function getConnection(){
            $curs = new mysqli($this->hostname, $this->user, $this->password, $this->database);

            if ($curs->connect_error) {
                die("Connection failed: " . $curs->connect_error);
            }
            return $curs;
        }
    }
?>
