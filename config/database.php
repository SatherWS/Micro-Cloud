<?php
    class Database {
        private $hostname = "localhost";
        private $database = "swoop";
        private $user = "root";
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
